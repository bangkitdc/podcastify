const EPISODE_BASE_URL = "/episode/";

const getEpisode = (url) => {
  let xhr = new XMLHttpRequest();

  xhr.open('GET', EPISODE_BASE_URL + url, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();

  return xhr;
}

// const showEpisode = (episodeId) => {
//   const url = "/episode/" + episodeId;
//   let xhr = getEpisode(url);

//   location.replace(url);

//   xhr.onload = () => {
//     document.getElementById("main-content").innerHTML = xhr.responseText;
//   };
// }

const showEditEpisode = (episodeId) => {
  const url = episodeId + "?edit=true";
  let xhr = getEpisode(url);

  xhr.onload = () => {
    document.getElementById("main-content").innerHTML = xhr.responseText;
  };
}