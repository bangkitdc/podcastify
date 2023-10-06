const EPISODE_BASE_URL = "/episode/";

const uploadEpsFile = (url, async = true, data = null) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", EPISODE_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(data);
  return xhr;
};

const createEpisode = (formData) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", EPISODE_BASE_URL + "add", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(formData);

  return xhr;
};

const updateEpisode = (json, episodeId) => {
  let xhr = new XMLHttpRequest();
  console.log(EPISODE_BASE_URL + episodeId + "?edit=true");
  xhr.open("PATCH", EPISODE_BASE_URL + "/" + episodeId + "?edit=true", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
  return xhr;
};

const deleteEpisode = (episodeId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", EPISODE_BASE_URL + episodeId);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();
  return xhr;
};

const handleFormSubmit = (formId, callback) => {
  let formElement = document.getElementById(formId);
  if (formElement) {
    formElement.addEventListener("submit", function (e) {
      e.preventDefault();
      callback(this);
    });
  }
};

document
  .getElementById("poster-file-upload")
  .addEventListener("change", function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById("preview-poster").src = e.target.result;
        document.getElementById("preview-poster").style.display = "block";
        document.getElementById("filename-poster-file-upload").innerText =
          document.getElementById("poster-file-upload").files[0].name;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

document
  .getElementById("audio-file-upload")
  .addEventListener("change", function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById("filename-audio-file-upload").innerText =
          document.getElementById("audio-file-upload").files[0].name;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

let addEpisodeModal = document.getElementById("add-episode-confirm-modal");
let addEpisodeAudioModal = document.getElementById("add-episode-audio-modal");
setupModal("add-episode-confirm-modal", "add-episode-modal-cancel", "add-episode-modal-ok")
setupModal("add-episode-audio-modal", "add-episode-audio-modal-ok");

handleFormSubmit("add-episode-form", function () {
  let titleValidation = false;
  let descriptionValidation = false;

  titleValidation = handleInputValidation(
    "episode-title-input",
    "Please enter a episode title"
  );

  descriptionValidation = handleInputValidation(
    "episode-description-input",
    "Please enter episode description"
  );

  if (!titleValidation || !descriptionValidation) return;

  let audioFile = document.getElementById("audio-file-upload");
  if(!audioFile.files.length) {
    addEpisodeAudioModal.style.display = "flex";
    return;
  }
  addEpisodeModal.style.display = "flex";
  addEpisodeModal.addEventListener("okayClicked", () => {
    let form = document.getElementById("add-episode-form");
    let formData = new FormData(form);

    formData.append(
      "episode-title-input",
      document.getElementById("episode-title-input").value
    );

    formData.append(
      "episode-description-input",
      document.getElementById("episode-description-input").value
    );

    // upload image to server
    let imgUrl = "/upload?type=image";
    let fileField = document.getElementById("poster-file-upload");
    let imgFormData = new FormData();
    imgFormData.append("filename", fileField.files[0].name);
    imgFormData.append("data", fileField.files[0]);

    let xhrImg = uploadEpsFile(imgUrl, true, imgFormData);
    xhrImg.onload = () => {
      formData.append("preview-poster-filename", xhrImg.responseText);

      // upload audio to server
      let audioUrl = "/upload?type=audio";
      let audioFileField = document.getElementById("audio-file-upload");
      let audioFormData = new FormData();
      audioFormData.append("filename", audioFileField.files[0].name);
      audioFormData.append("data", audioFileField.files[0]);

      let xhrAudio = uploadEpsFile(audioUrl, true, audioFormData);
      xhrAudio.onload = () => {
        formData.append("audio-filename", xhrAudio.responseText);
        console.log(xhrAudio.responseText);

        let xhr = createEpisode(formData);

        xhr.onload = () => {
          window.location.href = "/episode";
        };
      };
    };
  })
});

handleFormSubmit("delete-episode-form", function () {
  let form = document.getElementById("delete-episode-form");
  let formData = new FormData(form);

  let episodeId = 0;
  for (let [key, value] of formData.entries()) {
    if (key == "episode_id") {
      episodeId = value;
    }
  }

  let xhr = deleteEpisode(episodeId);

  xhr.onload = () => {
    console.log(xhr.responseText);
    window.location.href = "/episode";
  };
});
