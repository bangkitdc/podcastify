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

        let url = "/upload?type=image";
        let fileField = document.getElementById("poster-file-upload");
        let formData = new FormData();
        formData.append("filename", fileField.files[0].name);
        formData.append("data", fileField.files[0]);

        let xhr = uploadEpsFile(url, true, formData);
        xhr.onload = () => {
          document.getElementById("preview-poster-filename").value =
            xhr.responseText;
        };
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

        let url = "/upload?type=audio";
        let fileField = document.getElementById("audio-file-upload");
        let formData = new FormData();
        formData.append("filename", fileField.files[0].name);
        formData.append("data", fileField.files[0]);

        let xhr = uploadEpsFile(url, true, formData);
        xhr.onload = () => {
          document.getElementById("audio-filename").value = xhr.responseText;
        };
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

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

  let xhr = createEpisode(formData);

  xhr.onload = () => {
    console.log(xhr.responseText);
    window.location.href = "/episode";
  };
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
