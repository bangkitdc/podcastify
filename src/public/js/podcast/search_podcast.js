let searchBar = document.getElementById("search-bar");

let filterBtn = document.querySelector(".search-filter-btn");

filterBtn.addEventListener("mousedown", () => {
  let searchFunctionBox = document.querySelector(".search-function-box");

  if (searchFunctionBox.style.maxHeight !== "0px") {
    searchFunctionBox.style.maxHeight = "0px";
    searchFunctionBox.style.overflow = "hidden";
  } else {
    if (window.innerWidth < 800) {
      searchFunctionBox.style.maxHeight = "200px";
    } else {
      searchFunctionBox.style.maxHeight = "100px";
    }
    searchFunctionBox.style.overflow = "visible";
  }
});

searchBar.addEventListener("input", () => {
  if (searchBar.value != "") {
    document.querySelector(".clear-search-bar").style.display = "block";
  } else {
    document.querySelector(".clear-search-bar").style.display = "none";
  }
});

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
    if (xhr.status >= 200 && xhr.status < 300) {
      toggleVisibility(".podcast-box-skeleton", "hidden");
      toggleVisibility(".podcast-box-area", "visible");
      toggleVisibility(".podcast-nav-box", "visible");
      var parser = new DOMParser();
      var xhrDOM = parser.parseFromString(xhr.responseText, "text/html");
      var newPodcastContainer = xhrDOM.getElementById("podcast-container");

      var currPodcastContainer = document.getElementById("podcast-container");
      currPodcastContainer.parentNode.replaceChild(
        newPodcastContainer,
        currPodcastContainer
      );
      if (document.getElementById("pod-list-page-num"))
        document.getElementById("pod-list-page-num").textContent =
          currentPageNumber;
    } else {
      const response = JSON.parse(xhr.responseText);
      console.error(response.error_message);
    }
  };
};

// This is to catch keyboard event passed down from debounce
const searchPodcastWrapper = (event) => {
  searchPodcast(1);
};

const clearSearchBar = () => {
  searchBar.value = "";
  document.querySelector(".clear-search-bar").style.display = "none";
};

if (document.getElementById("podcast-search-category-selection")) {
  setupCheckboxes("podcast-search-category-selection");
  setupCheckboxes("podcast-search-creator-selection");
  setupSelect("podcast-search-sort-selection");
}

searchBar.addEventListener("keyup", debounce(searchPodcastWrapper, 500));
document
  .querySelectorAll('.base-checkbox input[type="checkbox"]')
  .forEach(function (checkbox) {
    checkbox.addEventListener("change", debounce(searchPodcastWrapper, 500));
  });

document
  .getElementById("podcast-search-sort-selection")
  .addEventListener("change", debounce(searchPodcastWrapper, 500));
