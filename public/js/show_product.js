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
let lastEditP = null; // Last editing paragraph
let lastEditBtn = null; // Last edit button clicked

editBtns.forEach(editBtn => {
  editBtn.addEventListener('click', () => {
    let commentID = editBtn.dataset.commentId;
    let commentBodyP = document.querySelector('.comment-body-p-' + commentID);

    lastEditP = currentEditP;
    currentEditP = commentBodyP;

    lastEditBtn = editBtn;

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
window.addEventListener('click', (e) => {
  if (currentEditP) {
    if (!currentEditP.contains(e.target)) { // We clicked outside !!!!!!!!!!!!!!!!!!!
      if (!e.target.classList.contains('edit-comment-btn')) { // We clicked on something that isn't edit button
        if (lastEditBtn.innerHTML == "SAVE") {
          updateComment(currentEditP.dataset.commentId, currentEditP.innerHTML, lastEditBtn, currentEditP);
          currentEditP = null;
        }
      } else {
        // USER CLICKED ON SOME EDIT BUTTON WE NEED TO CHECK WHICH ONE
        let editButtonID = e.target.dataset.commentId;

        if (lastEditP) {
          let lastEditPID = lastEditP.dataset.commentId;

          if (lastEditPID != editButtonID) { // Kliknuo sam edit pa odmah posle toga drugi edit
            lastEditP.contentEditable = false;
            updateComment(lastEditPID, lastEditP.innerHTML, document.querySelector(`button[data-comment-id="${lastEditPID}"]`), lastEditP);
          }
        }
      }
    }
  }
});

function updateComment(commentID, data, commentBtn, commentP) {
  if(data.trim().length < 20){
    alert("Please enter at least 20 characters.");
    commentBtn.innerHTML = "EDIT";
    commentP.contentEditable = false;

    return;
  }

  commentBtn.innerHTML = "EDIT";
  commentP.contentEditable = false;

  axios.put(`${origin}/comments/${commentID}`, {
    data,
  }).then(res => {
    document.querySelector(`div[data-comment-id="${commentID}"]`).style.display = 'block';
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
