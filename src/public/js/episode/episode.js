const EPISODE_BASE_URL = "/episode";

const getEpisode = (url, async = true) => {
  let xhr = new XMLHttpRequest();

  xhr.open('GET', EPISODE_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();

  return xhr;
}

const showEpisode = (episodeId) => {
  const url = "/episode/" + episodeId;
  let xhr = getEpisode(url);

  location.replace(url);

  xhr.onload = () => {
    document.getElementById("main-content").innerHTML = xhr.responseText;
  };
}

// const showEditEpisode = (e) => {
//   e.stopPropagation();
//   window.location.href = "/episode/edit/?=true";
// }