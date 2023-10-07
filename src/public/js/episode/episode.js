const EPISODE_BASE_URL = "/episode/";

const getEpisode = (url) => {
  let xhr = new XMLHttpRequest();

  xhr.open("GET", EPISODE_BASE_URL + url, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();

  return xhr;
};

const addScript = (src) => {
  let existingScript = document.querySelector(`script[src="${src}"]`);
  if (existingScript) {
    existingScript.remove();
  }
  let script = document.createElement("script");
  script.src = src;
  document.body.appendChild(script);
};

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
  try {
    let xhr = getEpisode(url);
  
    xhr.onload = () => {
      if (xhr.status === 200) {
        document.getElementById("content-middle").innerHTML = xhr.responseText;
        addScript("/src/public/js/components/inputText.js");
        addScript("/src/public/js/components/modal.js");
        addScript("/src/public/js/episode/handle_upload_edit.js");
      } else {
        console.error("Request failed with status:", xhr.status);
      }
    };
  } catch (error) {
    console.error("An error occurred:", error);
  }
  
};
