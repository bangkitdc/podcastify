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
  console.log(EPISODE_BASE_URL + episodeId + "?edit=true");
  xhr.open("PATCH", EPISODE_BASE_URL + "/" + episodeId + "?edit=true", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
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

handleFormSubmit("edit-episode-form", function () {
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
    window.location.href = "/episode";
  };
});
