// SEARCH =============================================================================================================
let origin = window.location.origin;   // Returns base URL (https://example.com)

let searchInput = document.querySelector('#search input');
let searchResultsDiv = document.querySelector('#search-results');

searchInput.addEventListener('keyup', () => {
  let enteredText = searchInput.value;

  if (enteredText == "") {
    searchResultsDiv.style.display = "none";

    return;
  }

  let data = {
    enteredText,
  }

  axios.post(origin + "/products/search", {
    data,
  }).then(res => {
    let foundProducts = res.data;
    let html = "";

    console.log(foundProducts);

    foundProducts.forEach(foundProduct => {
      html += `<a href="${origin}/products/${foundProduct.product_id}">
          <div class="search-result-item">
              <div class="search-result-item-img">
                  <img src="${foundProduct.img}" alt="">
              </div>
              <div class="search-result-item-info">
                  <p>${foundProduct.product_name} | ${foundProduct.name}</p>
                  <p>${(Math.round(foundProduct.RATING * 100) / 100)} / 10</p>
                  <p>${(Math.round(foundProduct.price * 100) / 100).toLocaleString()} RSD</p>
              </div>
          </div>
      </a>`;
    });

    searchResultsDiv.innerHTML = html;
    searchResultsDiv.style.display = "block";
  }).catch(error => {
    console.log(error.response.data);
    console.log(error.response.status);
    console.log(error.response.headers);
  });
});