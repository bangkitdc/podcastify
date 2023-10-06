const EPISODE_BASE_URL = "/episode";

function loadEpisodeList(
  start = false,
  prev = false,
  next = false,
  end = false,
  totalPages,
  currentPage = 1
) {
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

  try {
    let xhr = new XMLHttpRequest();
    const url = EPISODE_BASE_URL + "?page=" + pageNumber;
    xhr.open("GET", url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.send();

    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log(xhr.responseText);
        document.getElementById("content-middle").innerHTML = xhr.responseText;
      } else {
        console.error("Request failed with status:", xhr.status);
      }
    };

    xhr.onerror = function () {
      console.error("Error during XMLHttpRequest");
    };
  } catch (error) {
    console.error("Error during XMLHttpRequest:", error);
  }
}
