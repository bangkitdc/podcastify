let currPageNum = 1;

const loadUserList = (
  start = false,
  prev = false,
  next = false,
  end = false,
  totalPages,
  currentPage = 1
) => {
  let pageNumber = currentPage;
  if (next && currentPage < totalPages) {
    pageNumber++;
  } else if (prev && currentPage > 1) {
    pageNumber--;
  } else if (start) {
    pageNumber = 1;
  } else if (end) {
    pageNumber = totalPages;
  }

  document.getElementById("user-list-page-num").textContent = pageNumber;

  let xhr = new XMLHttpRequest();
  const url = "user/list?page=" + pageNumber;
  xhr.open("GET", url, true);

  xhr.onload = () => {
    document.getElementById("user-table").innerHTML = xhr.responseText;
  };

  xhr.send();
};