/**
 * Podcast Detail Page
 */
let pageNum = 1;

const loadEpsList = (
  podcastId,
  next = true,
  toEnd = false,
  toStart = false
) => {
  var totalPages = document.getElementById("eps-list-total-pages").textContent;
  if (next) {
    if (pageNum >= totalPages) return;
    pageNum++;
  } else if (toEnd) {
    if (pageNum >= totalPages) return;
    pageNum = totalPages;
  } else if (toStart) {
    if (pageNum <= 1) return;
    pageNum = 1;
  } else {
    if (pageNum <= 1) return;
    pageNum--;
  }

  document.getElementById("eps-list-page-num").textContent = pageNum;

  // Load eps list from the server
  const URL = "/episodes/" + podcastId + "?page=" + pageNum;
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/podcast" + URL);
  xhr.send();
  xhr.onload = () => {
    document.getElementById("podcast-eps-list-container").innerHTML =
      xhr.responseText;
  };
};
