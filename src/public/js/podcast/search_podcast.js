let searchBar = document.getElementById("search-bar");

const searchPodcast = (page = 1) => {
  const currentPageNumber = page;
  toggleVisibility(".podcast-box-area", "hidden");
  toggleVisibility(".podcast-nav-box", "hidden");
  toggleVisibility(".podcast-box-skeleton", "visible");
  let q = searchBar.value;
  let sortSelection = document.getElementById("podcast-search-sort-selection");

  let sortMethod = "";
  let sortKey = "created_at";
  if (sortSelection.value == "Oldest") {
    sortMethod = "asc";
  }
  if (sortSelection.value == "Recent") {
    sortMethod = "desc";
  }
  let params = new URLSearchParams();

  params.append("q", q);
  params.append("sort", sortMethod);
  params.append("key", sortKey);
  params.append("page", page);

  let filterNames = getCheckboxesValue("podcast-search-creator-selection");
  let filterCategories = getCheckboxesValue(
    "podcast-search-category-selection"
  );

  filterNames.forEach((value) => {
    if (value == "All") return;
    params.append("filter_name[]", value);
  });
  filterCategories.forEach((value) => {
    if (value == "All") return;
    params.append("filter_category[]", value);
  });
  let url = "/podcast/search?" + params.toString();
  let xhr = new XMLHttpRequest();
  xhr.open("GET", url);
  xhr.send();
  xhr.onload = () => {
    toggleVisibility(".podcast-box-skeleton", "hidden");
    toggleVisibility(".podcast-box-area", "visible");
    toggleVisibility(".podcast-nav-box", "visible");
    document.getElementById("podcast-container").outerHTML = xhr.responseText;
    document.getElementById("pod-list-page-num").textContent =
      currentPageNumber;
  };
};

// This is to catch keyboard event passed down from debounce
const searchPodcastWrapper = (event) => {
  searchPodcast(1);
};

if (document.getElementById("podcast-search-category-selection")) {
  setupCheckboxes("podcast-search-category-selection");
  setupCheckboxes("podcast-search-creator-selection");
  setupSelect("podcast-search-sort-selection");
}

searchBar.addEventListener("keyup", debounce(searchPodcastWrapper, 500));
