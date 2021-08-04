let origin = window.location.origin;   // Returns base URL (https://example.com)

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

// COMMENT EDIT ====================================================================================================================================

let editBtns = document.querySelectorAll('.edit-comment-btn');
let currentEditP = null; // Currently editing paragraph
let currentEditBtn = null; // Currently editing paragraph

editBtns.forEach(editBtn => {
  editBtn.addEventListener('click', () => {
    let commentID = editBtn.dataset.commentId;
    let commentBodyP = document.querySelector('.comment-body-p-' + commentID);

    currentEditP = commentBodyP;
    currentEditBtn = editBtn;

    if (editBtn.innerHTML == "SAVE") {
      updateComment(commentID, commentBodyP.innerHTML, editBtn, currentEditP);

      return;
    }

    commentBodyP.contentEditable = true;
    commentBodyP.focus();
    editBtn.innerHTML = "SAVE";
  });
});

// WE NEED TO CHECK IF USER CLICKED OUTSIDE THE EDITING PARAGRAPH
// window.addEventListener('click', (e) => {
//   if (currentEditP) {
//     console.log(e.target);
//     if (!currentEditP.contains(e.target)) { // We clicked outside !!!!!!!!!!!!!!!!!!!
//       // We clicked on something outside, if that something doesn't have commentId close it
//       // Or if it has and its different than this, close it.
//       let hasId = e.target.dataset.commentId;
//       let hasIdButItsDifferent = e.target.dataset.commentId && e.target.dataset.commentId != currentEditP.dataset.commentId;
//       console.log(hasId);
//       console.log(hasIdButItsDifferent)
//       if (!hasId || hasIdButItsDifferent) {
//         currentEditBtn.innerHTML = "EDIT";
//         currentEditP.contentEditable = false;
//         console.log(currentEditBtn);
//         console.log(currentEditP)
//       } else {
//         // && e.target.dataset.commentId == currentEditP.dataset.commentId
//         // currentEditBtn.innerHTML = "EDIT";
//         // currentEditP.contentEditable = false;
//       }
//     }
//   }
// });

function updateComment(commentID, data, commentBtn, commentP) {
  commentBtn.innerHTML = "EDIT";
  commentP.contentEditable = false;

  if (data.trim().length < 20) {
    alert("Please enter at least 20 characters.");

    return;
  }

  axios.put(`${origin}/comments/${commentID}`, {
    data,
  }).then(res => {
    let divAlert = document.createElement('div');
    divAlert.classList.add('alert', 'alert-success', 'alert-dismissible', 'fade', 'show', 'comment-alert');
    divAlert.innerHTML = `Comment updated successfully. :)
    <button type="button" class="btn-close" data-bs-dismiss="alert"
        aria-label="Close"></button>`;
    divAlert.setAttribute("role", "alert");
    document.querySelector(`div[data-comment-id="${commentID}"].comment-body`).prepend(divAlert);
  }).catch(err => console.log(err));
}


// RATING ============================================================================================================================

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

// ADDING TO CART ============================================================================================================================

let addToCartBtn = document.querySelector('.add-to-cart-btn');
let cartBasket = document.querySelector('.cart-basket');
let crtid = document.querySelector('.crtid');

addToCartBtn.addEventListener('click', () => {
  let status = addToCartBtn.dataset.status; // If attr is data-index-here-comes in JS it will return dataset.indexHereComes
  let currentQuantity = parseInt(liCurrent.innerHTML);
  let currentItemsInCart = parseInt(cartBasket.innerHTML);

  let url = window.location.href;     // Returns full URL (https://example.com/path/example.html)
  let product_id = url.substring(url.lastIndexOf('/') + 1);

  switch (status) {
    case "add":
      cartBasket.innerHTML = ++currentItemsInCart;
      addToCartBtn.innerHTML = "REMOVE FROM CART";
      addToCartBtn.dataset.status = "remove";

      let data = {
        currentQuantity,
        product_id,
      }

      axios.post(origin + "/cart", {
        data,
      }).then(res => {
        crtid.dataset.crt = res.data.id;
      }).catch(err => console.log(err));

      break;
    case "remove":
      cartBasket.innerHTML = --currentItemsInCart;
      addToCartBtn.innerHTML = "ADD TO CART";
      addToCartBtn.dataset.status = "add";

      axios.delete(origin + "/cart/" + crtid.dataset.crt).then(res => {
      }).catch(err => console.log(err));

      break;
  }

});
