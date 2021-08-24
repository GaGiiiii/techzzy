let selectSort = document.querySelector(`select[name=sortBy]`);
let priceRange = document.querySelector(`input[name=price-range]`);
let categories = document.querySelectorAll('input[name=category]');
let selectedCategories = [];

selectSort.addEventListener('change', () => {
  sendFilters();
});

priceRange.addEventListener('change', () => {
  sendFilters();
});

categories.forEach(category => {
  category.addEventListener('change', () => {
    if (category.checked) {
      selectedCategories.push(category.value);
    }else{
      selectedCategories.splice(selectedCategories.indexOf(category.value), 1);
    }
    sendFilters();
  });
});


function sendFilters() {
  let data = {
    selectSort: selectSort.value,
    priceRange: priceRange.value,
    categories: selectedCategories,
  }

  console.log(JSON.stringify(data));
}