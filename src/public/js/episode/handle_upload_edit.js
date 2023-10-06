const EPISODE_EDIT_BASE_URL = "/episode/";

const uploadEditedEpsFile = (url, async = true, data = null) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", EPISODE_EDIT_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(data);
  return xhr;
};

const updateEpisode = (json, episodeId) => {
  let xhr = new XMLHttpRequest();
  console.log(EPISODE_EDIT_BASE_URL + episodeId + "?edit=true");
  xhr.open(
    "PATCH",
    EPISODE_EDIT_BASE_URL + "/" + episodeId + "?edit=true",
    true
  );
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
  return xhr;
};

const deleteEpisode = (episodeId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", EPISODE_EDIT_BASE_URL + episodeId);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();
  return xhr
}

const handleFormSubmit = (formId, callback) => {
  let formElement = document.getElementById(formId);
  if (formElement) {
    formElement.addEventListener("submit", function (e) {
      e.preventDefault();
      callback(this);
    });
  }
};

document.getElementById("edit-poster-file-upload") &&
  document
    .getElementById("edit-poster-file-upload")
    .addEventListener("change", function () {
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = (e) => {
          document.getElementById("edit-preview-poster").src = e.target.result;
          document.getElementById("edit-preview-poster").style.display =
            "block";
          document.getElementById(
            "filename-edit-poster-file-upload"
          ).innerText = document.getElementById(
            "edit-poster-file-upload"
          ).files[0].name;
        };
        reader.readAsDataURL(this.files[0]);
      }
    });

document.getElementById("edit-audio-file-upload") &&
  document
    .getElementById("edit-audio-file-upload")
    .addEventListener("change", function () {
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = (e) => {
          document.getElementById("filename-edit-audio-file-upload").innerText =
            document.getElementById("edit-audio-file-upload").files[0].name;
        };
        reader.readAsDataURL(this.files[0]);
      }
    });

let editEpisodeModal = document.getElementById("edit-episode-confirm-modal");
let deleteEpisodeModal = document.getElementById("delete-episode-confirm-modal");
setupModal("edit-episode-confirm-modal", "edit-episode-modal-cancel", "edit-episode-modal-ok");
setupModal("delete-episode-confirm-modal", "delete-episode-modal-cancel", "delete-episode-modal-ok");

handleFormSubmit("edit-episode-form", function () {
  editEpisodeModal.style.display = "flex";
  const sendEpsEditPayload = (payloadForm) => {
    let data = {};
    let episodeId = 0;
    for (let [key, value] of payloadForm.entries()) {
      data[key] = value;
      if (key == "episode_id") {
        episodeId = value;
      }
    }
    let json = JSON.stringify(data);
    let xhr = updateEpisode(json, episodeId);

    xhr.onload = () => {
      window.location.href = "/episode";
    };
  };

  editEpisodeModal.addEventListener("okayClicked", function () {
    let form = document.getElementById("edit-episode-form");
    let formData = new FormData(form);

      formData.append(
        "episode-title-input",
        document.getElementById("episode-title-input").value
      );

      formData.append(
        "episode-description-input",
        document.getElementById("episode-description-input").value
      );

    let imgUrl = "/upload?type=image";
    let fileField = document.getElementById("edit-poster-file-upload");
    let imgFormData = new FormData();

    let imgUploadPromise = Promise.resolve();

    if (fileField.files[0]) {
      imgFormData.append("filename", fileField.files[0].name);
      imgFormData.append("data", fileField.files[0]);

      imgUploadPromise = new Promise((resolve, reject) => {
        let xhrImg = uploadEditedEpsFile(imgUrl, true, imgFormData);
        xhrImg.onload = () => {
          formData.append("edit-preview-poster-filename", xhrImg.responseText);
          resolve();
        };
        xhrImg.onerror = reject;
      });
    }

    let audioUrl = "/upload?type=audio";
    let audioFileField = document.getElementById("edit-audio-file-upload");
    let audioFormData = new FormData();

    let audioUploadPromise = Promise.resolve();

    if (audioFileField.files[0]) {
      audioFormData.append("filename", audioFileField.files[0].name);
      audioFormData.append("data", audioFileField.files[0]);

      audioUploadPromise = new Promise((resolve, reject) => {
        let xhrAudio = uploadEditedEpsFile(audioUrl, true, audioFormData);
        xhrAudio.onload = () => {
          formData.append("edit-audio-filename", xhrAudio.responseText);
          resolve();
        };
        xhrAudio.onerror = reject;
      });
    }

    Promise.all([imgUploadPromise, audioUploadPromise])
      .then(() => sendEpsEditPayload(formData))
      .catch((error) =>
        console.error("An error occurred while uploading files:", error)
      );
  })
});

if(document.getElementById("delete-episode")){
  document.getElementById("delete-episode").addEventListener("click", () => {
    deleteEpisodeModal.style.display = "flex";

    deleteEpisodeModal.addEventListener("okayClicked", () => {
      let id = document.getElementById("episode_id").value;
      let xhr = deleteEpisode(id);
      xhr.onload = () => {
        window.location.href = "/episode";
      };
    });
  });
}

if (document.getElementById("cancel-change")) {
  document.getElementById("cancel-change").addEventListener("click", () => {
    window.location.href = "/episode";
  });
}