const PODCAST_BASE_URL = "/podcast";

const getPodcast = (url, async = true) => {
  let xhr = new XMLHttpRequest();

  xhr.open("GET", PODCAST_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Manually set the X-Requested-With header
  xhr.send();
  return xhr;
};

const updateWindowUrl = (additionalUrl) => {
  // Update the URL
  let newUrl =
    window.location.protocol +
    "//" +
    window.location.host +
    window.location.pathname +
    additionalUrl;
  window.history.pushState({ path: newUrl }, "", newUrl);
};

const addScript = (src) => {
  if (!document.querySelector(`script[src="${src}"]`)) {
    let script = document.createElement("script");
    script.src = src;
    document.body.appendChild(script);
  }
};

/**
 * Podcast Page
 */
const toggleVisibility = (selector, visibility) => {
  if (document.querySelector(selector))
    document.querySelector(selector).style.visibility = visibility;
};

const showPodcast = (podcastId) => {
  window.location.href = "/podcast/show/" + podcastId;
};

const editPodcast = (podcastId, event) => {
  // stop propagating click event to parent component
  event.stopPropagation();
  window.location.href = "/podcast/edit/" + podcastId;
};

/**
 * Podcast Page
 */
let currPageNum = 1;

const loadPodcastList = (
  fromSearchBar = false,
  next = true,
  toEnd = false,
  toStart = false
) => {
  if (document.getElementById("pod-list-page-num").textContent != currPageNum) {
    currPageNum = document.getElementById("pod-list-page-num").textContent;
  }
  let totalPodPages = parseInt(
    document.getElementById("pod-list-total-pages").textContent
  );
  if (next) {
    if (currPageNum >= totalPodPages) return;
    currPageNum++;
  } else if (toEnd) {
    if (currPageNum >= totalPodPages) return;
    currPageNum = totalPodPages;
  } else if (toStart) {
    if (currPageNum <= 1) return;
    currPageNum = 1;
  } else {
    if (currPageNum <= 1) return;
    currPageNum--;
  }

  document.getElementById("pod-list-page-num").textContent = currPageNum;

  // Load podcasts list from the server
  const URL = "/podcasts?page=" + currPageNum;
  toggleVisibility(".podcast-box-area", "hidden");
  toggleVisibility(".podcast-nav-box", "hidden");
  toggleVisibility(".podcast-box-skeleton", "visible");

  if (fromSearchBar) {
    searchPodcast(currPageNum);
  } else {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/podcast" + URL);
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
        document.getElementById("pod-list-page-num").textContent = currPageNum;
      } else {
        const response = JSON.parse(xhr.responseText);
        console.error(response.error_message);
      }
    };
  }
};
