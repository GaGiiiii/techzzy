let liMinus = document.querySelector('.li-minus');
let liCurrent = document.querySelector('.li-current');
let liPlus = document.querySelector('.li-plus');
let changingQuantitySpan = document.querySelector('.changing-quantity-span');
let originalPriceSpan = document.querySelector('.original-price-span');
let originalStockSpan = document.querySelector('.original-stock-span');

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
  let inStock = parseInt(originalStockSpan.innerHTML);

  if (currentQuantity >= inStock) {
    return;
  }

  liCurrent.innerHTML = ++currentQuantity;

  let originalPrice = parseFloat(originalPriceSpan.innerHTML);
  changingQuantitySpan.innerHTML = `x${currentQuantity} = ${Math.round((originalPrice * currentQuantity) * 100) / 100} RSD`;
});


// RATING

let rateStars = document.querySelectorAll('.rate-star');
let ratingInput = document.querySelector(`input[name="rating"]`);
let originalUsersRating = ratingInput.value;

initStars();

rateStars.forEach((rateStar, index) => {
  rateStar.addEventListener('mouseover', () => {
    removeYellowColorFromStars();
    for (let i = 0; i < index + 1; i++) {
      rateStars[i].style.color = "rgb(209, 203, 19)";
    }
    ratingInput.value = index + 1;
  });

  rateStar.addEventListener('mouseout', () => {
    removeYellowColorFromStars();
    initStars();
    ratingInput.value = originalUsersRating;
  });
});

function removeYellowColorFromStars() {
  rateStars.forEach((rateStar) => {
    rateStar.style.color = "#3e3f3a";
  });
}

function initStars() {
  for (let i = 0; i < originalUsersRating; i++) {
    rateStars[i].style.color = "rgb(209, 203, 19)";
  }
}