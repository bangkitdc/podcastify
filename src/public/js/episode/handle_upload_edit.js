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
  xhr.open("PATCH", EPISODE_EDIT_BASE_URL + episodeId + "?edit=true", true);
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
      console.log("ADADADADADA");
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

          let url = "/upload?type=image";
          let fileField = document.getElementById("edit-poster-file-upload");
          let formData = new FormData();
          formData.append("filename", fileField.files[0].name);
          formData.append("data", fileField.files[0]);

          let xhr = uploadEditedEpsFile(url, true, formData);
          xhr.onload = () => {
            console.log(xhr.responseText);
            document.getElementById("edit-preview-poster-filename").value =
              xhr.responseText;
          };
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

          let url = "/upload?type=audio";
          let fileField = document.getElementById("edit-audio-file-upload");
          let formData = new FormData();
          formData.append("filename", fileField.files[0].name);
          formData.append("data", fileField.files[0]);

          let xhr = uploadEditedEpsFile(url, true, formData);
          xhr.onload = () => {
            console.log(xhr.responseText);
            document.getElementById("edit-audio-filename").value =
              xhr.responseText;
          };
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

    let data = {};
    let episodeId = 0;
    for (let [key, value] of formData.entries()) {
      data[key] = value;
      if (key == "episode_id") {
        episodeId = value;
      }
    }

    let json = JSON.stringify(data);

    let xhr = updateEpisode(json, episodeId);

    xhr.onload = () => {
      console.log(xhr.responseText);
      // window.location.href = "/episode";
    };
  });
});

if(document.getElementById("delete-episode")){
  document.getElementById("delete-episode").addEventListener("click", () => {
    deleteEpisodeModal.style.display = "flex";

    deleteEpisodeModal.addEventListener("okayClicked", () => {
      let id = document.getElementById("episode_id").value;
      let xhr = deleteEpisode(id);
      xhr.onload = () => {
        // window.location.href = "/episode";
      };
    });
  });
}

if (document.getElementById("cancel-change")) {
  document.getElementById("cancel-change").addEventListener("click", () => {
    window.location.href = "/episode";
  });
}