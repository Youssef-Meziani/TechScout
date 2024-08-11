document.addEventListener('DOMContentLoaded', function () {
    // Récupérer le compteur de comparaison
    const compareCountElement = document.querySelector('.compare .count');

    // Fonction pour mettre à jour le compteur de comparaison
    function updateCompareCount() {
        const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];
        compareCountElement.textContent = compareItems.length;
    }

    // Initialiser le compteur de comparaison
    updateCompareCount();

    // Ajouter un produit à comparer
    document.querySelectorAll('.compare-button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const productElement = this.closest('.product-item');
            const productId = productElement.getAttribute('data-product-id');
            const productName = productElement.getAttribute('data-product-name');
            const productImage = productElement.getAttribute('data-product-image');
            const productPrice = productElement.getAttribute('data-product-price');

            const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];

            // Vérifier si le produit est déjà dans la liste de comparaison
            const productIndex = compareItems.findIndex(item => item.id === productId);
            if (productIndex === -1) {
                compareItems.push({
                    id: productId,
                    name: productName,
                    image: productImage,
                    price: productPrice
                });
                localStorage.setItem('compareItems', JSON.stringify(compareItems));
                updateCompareCount();
            } else {
                alert('Ce produit est déjà dans la liste de comparaison.');
            }
        });
    });

    // Charger les produits à comparer dans compare.html
    if (document.getElementById('comparison-table')) {
        const comparisonTable = document.getElementById('comparison-table');
        const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];

        compareItems.forEach(item => {
            comparisonTable.querySelector('tbody tr:nth-child(1)').innerHTML += `<td><a href="product-details.html"><strong>${item.name}</strong></a></td>`;
            comparisonTable.querySelector('tbody tr:nth-child(2)').innerHTML += `<td><img src="${basePath + themeDirectory}/${item.image}" alt="${item.name}" class="img-thumbnail"></td>`;
            comparisonTable.querySelector('tbody tr:nth-child(3)').innerHTML += `<td><span>${item.price}</span></td>`;
            // Ajoutez d'autres colonnes si nécessaire
        });
    }
});
