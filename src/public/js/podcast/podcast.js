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
  document.querySelector(selector).style.visibility = visibility;
};

const searchPodcast = (all = false) => {
  let input = document.getElementById("search-bar");
  let filter = input.value.toUpperCase();

  let url = "";
  if (!all) {
    toggleVisibility(".podcast-box-area", "hidden");
    toggleVisibility(".no-podcast-info", "hidden");
    toggleVisibility(".podcast-box-skeleton", "visible");
    url += "/search?key=" + filter;
  }
  let xhr = getPodcast(url);

  xhr.onload = () => {
    toggleVisibility(".podcast-box-skeleton", "hidden");
    toggleVisibility(".podcast-box-area", "visible");
  };
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

const loadPodcastList = (next = true, toEnd = false, toStart = false) => {
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

  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/podcast" + URL);
  xhr.send();

  xhr.onload = () => {
    toggleVisibility(".podcast-box-skeleton", "hidden");
    toggleVisibility(".podcast-box-area", "visible");
    toggleVisibility(".podcast-nav-box", "visible");
    document.getElementById("podcast-container").outerHTML = xhr.responseText;
    document.getElementById("pod-list-page-num").textContent = currPageNum;
  };
};
