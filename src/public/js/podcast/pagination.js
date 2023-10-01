/**
 * Podcast Detail Page
 */
var pageNum = 1;

const loadEpsList = (
  podcastId,
  next = true,
  toEnd = false,
  toStart = false
) => {
  var totalPages = document.getElementById("eps-list-total-pages").textContent;
  if (next) {
    if (next && pageNum < totalPages) {
      pageNum++;
      document.getElementById("eps-list-page-num").textContent = pageNum;
    }
  } else {
    if (pageNum > 1) {
      pageNum--;
      document.getElementById("eps-list-page-num").textContent = pageNum;
    }
  }

  if (toEnd) {
    pageNum = totalPages;
  }
  if (toStart) {
    pageNum = 1;
  }
  document.getElementById("eps-list-page-num").textContent = pageNum;

  // Load eps list from the server
  const URL = "/episodes/" + podcastId + "?page=" + pageNum;
  let xhttp = getPodcast(URL);
  xhttp.onload = () => {
    document.getElementById("podcast-eps-list-container").innerHTML =
      xhttp.responseText;
  };
};
