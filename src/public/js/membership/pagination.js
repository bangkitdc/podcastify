const loadCreatorList = (
  start = false,
  prev = false,
  next = false,
  end = false,
  totalPages
) => {
  let currentPage = document.getElementById("creator-list-page-num").innerText;

  let pageNumber = currentPage;
  if (next) {
    if (pageNumber >= totalPages) return;
    pageNumber++;
  } else if (end) {
    if (pageNumber >= totalPages) return;
    pageNumber = totalPages;
  } else if (start) {
    if (pageNumber <= 1) return;
    pageNumber = 1;
  } else if (prev) {
    if (pageNumber <= 1) return;
    pageNumber--;
  } else {
    return;
  }

  document.getElementById("creator-list-page-num").textContent = pageNumber;

  let xhr = new XMLHttpRequest();
  const url = "membership?page=" + pageNumber;
  xhr.open("GET", url, true);

  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      document.getElementById("creator-cards").innerHTML =
        xhr.responseText;
    } else {
      const response = JSON.parse(xhr.responseText);
      console.error(response.error_message);
    }
  };

  xhr.send();
};

const loadEpisodeList = (
  start = false,
  prev = false,
  next = false,
  end = false,
  totalPages
) => {
  let currentPage = document.getElementById(
    "episode-list-page-num"
  ).innerText;

  let pageNumber = currentPage;
  if (next) {
    if (pageNumber >= totalPages) return;
    pageNumber++;
  } else if (end) {
    if (pageNumber >= totalPages) return;
    pageNumber = totalPages;
  } else if (start) {
    if (pageNumber <= 1) return;
    pageNumber = 1;
  } else if (prev) {
    if (pageNumber <= 1) return;
    pageNumber--;
  } else {
    return;
  }

  document.getElementById("episode-list-page-num").textContent = pageNumber;

  const creator_id = document.getElementById("creator-id");

  let xhr = new XMLHttpRequest();
  const url = `/membership/creator/${2}?page=` + pageNumber;
  xhr.open("GET", url, true);

  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      document.getElementById("episodes-table").innerHTML = xhr.responseText;
    } else {
      const response = JSON.parse(xhr.responseText);
      console.error(response.error_message);
    }
  };

  xhr.send();
};
