# Guide d'Installation et de Mise en Route du Projet sur Windows 11 avec WSL

Ce guide vous aidera à installer et configurer votre environnement de développement pour faire fonctionner un projet Drupal sur Windows 11 en utilisant WSL 2, Docker Desktop, et Lando.

## 1. Installation et Configuration de WSL

### Étapes :

1. **Activer WSL et la Plateforme de Machine Virtuelle :**
    ```powershell
    dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart
    dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
    ```

2. **Définir WSL 2 comme version par défaut :**
    ```powershell
    wsl --set-default-version 2
    ```

3. **Redémarrez votre ordinateur pour appliquer les changements.**

4. **Installer la distribution Ubuntu :**
    ```powershell
    wsl --install -d Ubuntu
    ```



## 2. Installation de Docker Desktop sur Windows

Téléchargez et installez Docker Desktop depuis le [site officiel de Docker](https://www.docker.com/products/docker-desktop). Suivez les instructions d'installation et assurez-vous que Docker Desktop utilise le moteur WSL 2.



## 3. Configuration de Docker avec WSL 2

### Étapes :

1. **Ouvrir Docker Desktop et accéder aux Paramètres :**

   - Lancez Docker Desktop.
   - Cliquez sur **Settings**.

2. **Vérifier que Docker Utilise WSL 2 comme moteur :**

   - Dans l'onglet **General**, assurez-vous que l'option **Use the WSL 2 based engine** est activée.
   <img alt="Configuration Docker" src="Documentation assets/Configuration Docker.png">

3. **Activer l'Intégration WSL 2 :**

   - Allez dans l'onglet **Resources**.
   - Sélectionnez **WSL Integration**.
   - Activez l'intégration pour la distribution Ubuntu en cochant la case correspondante.
   <img alt="WSL Integration" src="Documentation assets/WSL Integration.png">



## 4. Installation de Lando dans la Distribution Ubuntu

### Étapes :

1. **Mettre à jour les paquets :**
    ```bash
    sudo apt-get update
    ```

2. **Télécharger et installer Lando :**
    ```bash
    wget https://files.lando.dev/lando-x64-stable.deb
    sudo apt install -y ./lando-x64-stable.deb
    ```

3. **Installer PHP et Composer :**
    ```bash
    sudo apt install -y php
    sudo apt install -y composer
    ```



## 5. Cloner le Projet dans le Dossier Utilisateur de la Distribution Ubuntu

Utilisez la commande `git clone` pour cloner le projet dans votre dossier utilisateur sur Ubuntu. Par exemple :
```bash
git clone https://github.com/Youssef-Meziani/TechScout.git
cd TechScout
```



## 6. Démarrer le Projet avec Lando

### Étapes :

1. **Configurer le projet avec Lando :**
    ```bash
    lando setup
    ```

2. **Démarrer les services Lando :**
    ```bash
    lando start
    ```

3. **Installer les dépendances PHP avec Composer :**
    ```bash
    lando composer install
    ```



## 7. Importer la Configuration de Drupal

### Étapes :

1. **Importer la configuration Drupal :**
    ```bash
    lando drush si --db-url=mysql://drupal9:techrootscout@kfTkUcJFstoVJ/techscout -y

    lando drush cset system.site uuid fe926cbc-b8ff-43dc-80d0-467754178069

    lando drush cset shortcut.set.default uuid fe926cbc-b8ff-43dc-80d0-467754178069

    lando drush sql:query "DELETE FROM shortcut;"

    lando drush config:import -y
    ```

2. **Rebuild du cache Drupal :**
    ```bash
    lando drush cache:rebuild
    ```



## 8. Importation et Gestion des Données Produit

### Importer les Données Produit

Si aucun produit n'est affiché dans la liste des produits dans la section commerce de Drupal, vous pouvez importer des données en utilisant :

  ```bash
  lando drush migrate-import laptop_import
  ```

### Gérer les Migrations

Si vous devez annuler les modifications effectuées par la migration, vous pouvez utiliser les commandes suivantes :

1. Réinitialiser le statut de la migration :
  ```bash
  lando drush migrate-reset-status laptop_import
  ```

2. Annuler la migration :
  ```bash
  lando drush migrate-rollback laptop_import
  ```
