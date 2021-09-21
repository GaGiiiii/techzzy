// let origin = window.location.origin;   // Returns base URL (https://example.com)

let liMinuses = document.querySelectorAll('.li-minus');
let liCurrents = document.querySelectorAll('.li-current');
let liPluses = document.querySelectorAll('.li-plus');

let currentCountSpans = document.querySelectorAll('.current-count-span');
let totalProductPrices = document.querySelectorAll('.total-product-price');
let originalProductPrices = document.querySelectorAll('.original-product-price');

let subtotalPriceSpan = document.querySelector('.subtotal-price-span');
let totalPriceSpan = document.querySelector('.total-price-span');
let taxSpan = document.querySelector('.tax-span');

liMinuses.forEach((liMinus, index) => {
  liMinus.addEventListener('click', () => {
    let currentQuantity = parseInt(liCurrents[index].innerHTML.replaceAll(',', ''));
    let originalProductPrice = parseFloat(originalProductPrices[index].innerHTML.replaceAll(',', ''));
    let currentSubtotalPrice = parseFloat(subtotalPriceSpan.innerHTML.replaceAll(',', ''));

    if (currentQuantity == 1) {
      return;
    }

    liCurrents[index].innerHTML = currentQuantity - 1;
    currentCountSpans[index].innerHTML = --currentQuantity;
    totalProductPrices[index].innerHTML = (Math.round(originalProductPrice * currentQuantity * 100) / 100).toLocaleString();

    let newSubtotalPrice = Math.round((currentSubtotalPrice - originalProductPrice) * 100) / 100;
    subtotalPriceSpan.innerHTML = newSubtotalPrice.toLocaleString();
    let newTax = Math.round(newSubtotalPrice * 0.1 * 100) / 100;
    taxSpan.innerHTML = newTax.toLocaleString();
    totalPriceSpan.innerHTML = (newSubtotalPrice + newTax).toLocaleString();

    updateCart(liMinus.dataset.cartId, currentQuantity);
  });
});

liPluses.forEach((liPlus, index) => {
  liPlus.addEventListener('click', () => {
    let currentQuantity = parseInt(liCurrents[index].innerHTML.replaceAll(',', ''));
    let originalProductPrice = parseFloat(originalProductPrices[index].innerHTML.replaceAll(',', ''));
    let currentSubtotalPrice = parseFloat(subtotalPriceSpan.innerHTML.replaceAll(',', ''));

    liCurrents[index].innerHTML = currentQuantity + 1;
    currentCountSpans[index].innerHTML = ++currentQuantity;
    totalProductPrices[index].innerHTML = (Math.round(originalProductPrice * currentQuantity * 100) / 100).toLocaleString();

    let newSubtotalPrice = Math.round((currentSubtotalPrice + originalProductPrice) * 100) / 100;
    subtotalPriceSpan.innerHTML = newSubtotalPrice.toLocaleString();
    let newTax = Math.round(newSubtotalPrice * 0.1 * 100) / 100;
    taxSpan.innerHTML = newTax.toLocaleString();
    totalPriceSpan.innerHTML = (newSubtotalPrice + newTax).toLocaleString();

    updateCart(liPlus.dataset.cartId, currentQuantity);
  });
});

function updateCart(cartID, newQuantity) {
  axios.put(origin + '/carts/' + cartID, {
    newQuantity,
  }).then(res => {
    console.log("============RES============");
    console.log(res);
    console.log("============RES============");
    console.log("============RES DATA============");
    console.log(res.data);
    console.log("============RES DATA============");
  }).catch(err => console.log(err));
}