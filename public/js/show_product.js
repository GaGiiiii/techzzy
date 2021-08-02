let liMinus = document.querySelector('.li-minus');
let liCurrent = document.querySelector('.li-current');
let liPlus = document.querySelector('.li-plus');
let changingQuantitySpan = document.querySelector('.changing-quantity-span');
let originalPriceSpan = document.querySelector('.original-price-span');

liMinus.addEventListener('click', () => {
  let currentQuantity = parseInt(liCurrent.innerHTML);

  if (currentQuantity == 1) {
    return;
  }

  liCurrent.innerHTML = --currentQuantity;

  if (currentQuantity == 1) {
    changingQuantitySpan.innerHTML = "";

    return;
  }

  let originalPrice = parseFloat(originalPriceSpan.innerHTML);
  changingQuantitySpan.innerHTML = `x${currentQuantity} = ${Math.round((originalPrice * currentQuantity) * 100) / 100} RSD`;
});

liPlus.addEventListener('click', () => {
  let currentQuantity = parseInt(liCurrent.innerHTML);

  if (currentQuantity >= 30) {
    return;
  }

  liCurrent.innerHTML = ++currentQuantity;

  let originalPrice = parseFloat(originalPriceSpan.innerHTML);
  changingQuantitySpan.innerHTML = `x${currentQuantity} = ${Math.round((originalPrice * currentQuantity) * 100) / 100} RSD`;
});