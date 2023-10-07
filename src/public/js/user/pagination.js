const loadUserList = (
  start = false,
  prev = false,
  next = false,
  end = false,
  totalPages,
) => {
  let currentPage = document.getElementById('user-list-page-num').innerText;

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

  document.getElementById("user-list-page-num").textContent = pageNumber;

  let xhr = new XMLHttpRequest();
  const url = "user?page=" + pageNumber;
  xhr.open("GET", url, true);

  xhr.onload = () => {
    document.getElementById("user-table").innerHTML = xhr.responseText;
  };

  xhr.send();
};