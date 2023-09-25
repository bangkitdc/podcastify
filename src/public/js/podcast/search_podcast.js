const toggleVisibility = (selector, visibility) => {
  document.querySelector(selector).style.visibility = visibility;
};

const searchPodcast = () => {
  let input = document.getElementById("search-bar");
  let filter = input.value.toUpperCase();

  toggleVisibility(".podcast-box-area", "hidden");
  toggleVisibility(".no-podcast-info", "hidden");
  toggleVisibility(".podcast-box-skeleton", "visible");

  let xhttp = new XMLHttpRequest();

  xhttp.onload = () => {
    document.getElementById("content").innerHTML = xhttp.responseText;
    toggleVisibility(".podcast-box-skeleton", "hidden");
    toggleVisibility(".podcast-box-area", "visible");
  };

  xhttp.open("GET", "/podcast?podcast_id=" + filter, true);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Manually set the X-Requested-With header
  xhttp.send();
};
