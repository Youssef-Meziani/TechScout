document.addEventListener('DOMContentLoaded', function () {
  const compareCountElement = document.querySelector('.compare .count');

  function updateCompareCount() {
    const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];
    compareCountElement.textContent = compareItems.length;
  }

  function updateCompareButtons() {
    const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];
    document.querySelectorAll('.product-item').forEach(productItem => {
      const productId = productItem.getAttribute('data-product-id');
      const isInCompareList = compareItems.some(item => item.id === productId);
      const compareButton = productItem.querySelector('.compare-button');
      if (compareButton) {
        compareButton.textContent = isInCompareList ? 'remove from compare' : 'add to compare';
      }
    });
  }

  updateCompareCount();
  updateCompareButtons();

  document.querySelectorAll('.compare-button').forEach(button => {
    button.addEventListener('click', function (event) {
      event.preventDefault();

      const productElement = this.closest('.product-item');
      const productId = productElement.getAttribute('data-product-id');
      const productName = productElement.getAttribute('data-product-name');
      const productImage = productElement.getAttribute('data-product-image');
      const productPrice = productElement.getAttribute('data-product-price');

      let compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];

      const productIndex = compareItems.findIndex(item => item.id === productId);
      if (productIndex === -1) {
        compareItems.push({
          id: productId,
          name: productName,
          image: productImage,
          price: productPrice
        });
        this.textContent = 'remove from compare';
      } else {
        compareItems.splice(productIndex, 1);
        this.textContent = 'add to compare';
      }

      localStorage.setItem('compareItems', JSON.stringify(compareItems));
      updateCompareCount();
      updateCompareButtons();
    });
  });

  if (document.getElementById('comparison-table')) {
    const comparisonTable = document.getElementById('comparison-table');
    const compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];

    compareItems.forEach(item => {
      comparisonTable.querySelector('tbody tr:nth-child(1)').innerHTML += `<td><a href="product-details.html"><strong>${item.name}</strong></a></td>`;
      comparisonTable.querySelector('tbody tr:nth-child(2)').innerHTML += `<td><img height="100" src="${basePath + themeDirectory}/assets/img/product/product 2.jpg" alt="${item.name}" class="img-thumbnail"></td>`;
      comparisonTable.querySelector('tbody tr:nth-child(3)').innerHTML += `<td><span>${item.price}</span></td>`;
      comparisonTable.querySelector('tbody tr:nth-child(4)').innerHTML += `<td><button onclick="removeFromCompare(event)" data-product-id="${item.id}" class="remove-from-compare"><i class="fa fa-trash"></i></button></td>`;
    });
  }

});

function removeFromCompare(event) {
  event.preventDefault();
  const productId = event.currentTarget.getAttribute('data-product-id');
  let compareItems = JSON.parse(localStorage.getItem('compareItems')) || [];
  compareItems = compareItems.filter(item => item.id !== productId);
  localStorage.setItem('compareItems', JSON.stringify(compareItems));
  window.location.href = '/compare';
}
