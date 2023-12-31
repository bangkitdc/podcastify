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
setupModal(
  "add-episode-confirm-modal",
  "add-episode-modal-cancel",
  "add-episode-modal-ok"
);
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
  if (!audioFile.files.length) {
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
    if (fileField.files[0]) {
      imgFormData.append("filename", fileField.files[0].name);
      imgFormData.append("data", fileField.files[0]);
    } else {
      imgFormData = null;
    }

    try {
      let xhrImg = uploadEpsFile(imgUrl, true, imgFormData);
      xhrImg.onload = () => {
        
        if (xhrImg.status === 200) {
          formData.append("preview-poster-filename", xhrImg.responseText);

          try {
            // upload audio to server
            let audioUrl = "/upload?type=audio";
            let audioFileField = document.getElementById("audio-file-upload");
            let audioFormData = new FormData();
            audioFormData.append("filename", audioFileField.files[0].name);
            audioFormData.append("data", audioFileField.files[0]);

            let xhrAudio = uploadEpsFile(audioUrl, true, audioFormData);
            xhrAudio.onload = () => {

              if (xhrAudio.status === 200) {
                formData.append("audio-filename", xhrAudio.responseText);

                try {
                  let xhr = createEpisode(formData);
                  xhr.onload = () => {
                    const response = JSON.parse(xhr.responseText);

                    if (xhr.status === 200) {
                      if (response.success) {
                        showNotificationSuccess(response.status_message);
                        setTimeout(() => {
                          location.replace(response.redirect_url);
                        }, 3000);
                      } else {
                        showNotificationDanger(response.error_message);
                      }
                    } else {
                      console.error("Request failed with status:", xhr.status);
                    }
                  };

                  xhr.onerror = function () {
                    console.error("Error during XMLHttpRequest");
                  };
                } catch (error) {
                  console.error("Error creating episode:", error);
                }
              } else {
                const response = JSON.parse(xhrAudio.responseText);
                showNotificationDanger(response.error_message);
              }
            };
          } catch (error) {
            console.error("Error uploading audio:", error);
          }
        } else {
          const response = JSON.parse(xhrImg.responseText);
          showNotificationDanger(response.error_message);
        }
      };
    } catch (error) {
      console.error("Error uploading image:", error);
    }
  });
});
