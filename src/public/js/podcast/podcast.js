// API request
const PODCAST_BASE_URL = "/podcast";

const get = (url, async = true) => {
  let xhttp = new XMLHttpRequest();

  xhttp.open("GET", PODCAST_BASE_URL + url, async);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Manually set the X-Requested-With header
  xhttp.send();
  return xhttp;
};

const post = (url, async = true) => {
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", PODCAST_BASE_URL + url, async);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.send();
  return xhttp;
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
  let xhttp = get(url);

  xhttp.onload = () => {
    document.getElementById("main-content").innerHTML = xhttp.responseText;
    if (!all) {
      toggleVisibility(".podcast-box-skeleton", "hidden");
      toggleVisibility(".podcast-box-area", "visible");
    }
  };
};

const showPodcast = (podcastId) => {
  const URL = "/podcast/" + podcastId;
  let xhttp = get(URL);

  xhttp.onload = () => {
    document.getElementById("main-content").innerHTML = xhttp.responseText;
    // updateWindowUrl("?podcast_id" + podcast_id);
    let script = document.createElement("script");
    script.src = "/src/public/js/podcast/pagination.js";
    document.body.appendChild(script);
  };
};

const editPodcast = (podcastId, event) => {
  // stop propagating click event to parent component
  event.stopPropagation();

  const URL = "/edit/" + podcastId;
  let xhttp = get(URL);

  xhttp.onload = () => {
    document.getElementById("main-content").innerHTML = xhttp.responseText;
  };
};
