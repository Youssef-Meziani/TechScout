vcl 4.0;

# Default backend definition. Pointez ceci vers votre serveur de contenu.
backend default {
    .host = "appserver";
    .port = "80";
}

# ACL pour les IP autorisées à purger le cache
acl purge {
    "localhost";
    "127.0.0.1";
    "::1";
}

sub vcl_recv {
    # Gestion des requêtes PURGE
    if (req.method == "PURGE") {
        if (!client.ip ~ purge) {
            return (synth(405, "Non autorisé."));
        }
        return (purge);
    }

    # Ne pas mettre en cache les requêtes POST
    if (req.method != "GET" && req.method != "HEAD") {
        return (pass);
    }

    # Ne pas mettre en cache les pages d'administration et utilisateur
    if (req.url ~ "^/admin" || req.url ~ "^/user") {
        return (pass);
    }

    # Supprimer tous les cookies sauf le cookie de session
    if (req.http.Cookie) {
        set req.http.Cookie = regsuball(req.http.Cookie, "(?i)^[^;]+;\s*", "");
        if (req.http.Cookie == "") {
            unset req.http.Cookie;
        }
    }
}

sub vcl_backend_response {
    # Définir la durée de vie du cache à 1 heure par défaut
    set beresp.ttl = 1h;
}

sub vcl_deliver {
    # Ajouter un en-tête pour indiquer un hit ou un miss du cache
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }
}
