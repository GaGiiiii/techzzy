let selectSort = document.querySelector(`select[name=sortBy]`);
let priceRange = document.querySelector(`input[name=price-range]`);
let categories = document.querySelectorAll('input[name=category]');
let selectedCategories = [];
let priceRangeSpan = document.querySelector('.price-range-span');

initSelectedCategories();

selectSort.addEventListener('change', () => {
  sendFilters();
});

priceRange.addEventListener('change', () => {
  priceRangeSpan.innerHTML = `0 - ${priceRange.value} RSD`;
  sendFilters();
});

categories.forEach(category => {
  category.addEventListener('change', () => {
    if (category.checked) {
      selectedCategories.push(category.value);
    } else {
      selectedCategories.splice(selectedCategories.indexOf(category.value), 1);
    }
    sendFilters();
  });
});


function sendFilters() {
  const data = {
    selectSort: selectSort.value,
    priceRange: priceRange.value,
    categories: selectedCategories,
  }

  const params = new URLSearchParams(window.location.search);
  // const page = params.has('page') ? params.get('page') : 1;

  let url = `${origin}/products?page=1&sort=${selectSort.value}&price=${priceRange.value}`;

  console.log(selectedCategories);

  for (let [index, category] of selectedCategories.entries()) {
    console.log(index);
    if (index === 0) {
      url += `&categories=${category}`;
    } else {
      if (index === selectedCategories.length - 1) { // Ako je poslednji
        url += `,${category}`
      } else { // Nije poslednji
        url += `,${category}`
      }
    }
  };

  window.location.href = url;
}

function initSelectedCategories() {
  categories.forEach(category => {
    if (category.checked) {
      selectedCategories.push(category.value);
      console.log(selectedCategories);
    } else {
      let index = selectedCategories.indexOf(category.value);

      if (index != -1) {
        selectedCategories.splice(selectedCategories.indexOf(category.value), 1);
      }
    }
  });
  console.log(selectedCategories);
}

// Disable checkboxes so user can't spam
window.onload = () => {
  categories.forEach(category => {
    category.disabled = false;
  });
}