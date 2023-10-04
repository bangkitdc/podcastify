const PODCAST_MANAGE_BASE_URL = "/podcast";

const uploadPodcastImage = (url, async = true, data = null) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", PODCAST_MANAGE_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(data);
  return xhr;
};

const createPodcast = (formData) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", PODCAST_MANAGE_BASE_URL + "/add", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(formData);
  return xhr;
};

const updatePodcast = (json, podcastId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("PATCH", PODCAST_MANAGE_BASE_URL + "/edit/" + podcastId, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
  return xhr;
};

const deletePodcast = (podcastId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", PODCAST_MANAGE_BASE_URL + "/edit/" + podcastId, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();
  return xhr;
};

document.getElementById("file-upload").addEventListener("change", function () {
  if (this.files && this.files[0]) {
    var reader = new FileReader();
    reader.onload = (e) => {
      document.getElementById("preview-image").src = e.target.result;
      document.getElementById("preview-image").style.display = "block";
      document.getElementById("filename-file-upload").innerText =
        document.getElementById("file-upload").files[0].name;

      let url = "/upload";
      let fileField = document.getElementById("file-upload");
      let formData = new FormData();
      formData.append("filename", fileField.files[0].name);
      formData.append("data", fileField.files[0]);

      let xhr = uploadPodcastImage(url, true, formData);
      xhr.onload = () => {
        document.getElementById("preview-image-filename").value =
          xhr.responseText;
      };
    };
    reader.readAsDataURL(this.files[0]);
  }
});

if (document.getElementById("manage-modal-file")) {
  var fileInfoModal = document.getElementById("manage-modal-file");
  setupModal("manage-modal-file", "manage-modal-ok");
}

let deleteModal = document.getElementById("manage-modal-delete");
let saveChangesModal = document.getElementById("manage-modal-save");
let createModal = document.getElementById("manage-modal-create");
setupModal("manage-modal-create", "create-modal-cancel", "create-modal-ok");
setupModal("manage-modal-save", "save-modal-cancel", "save-modal-ok");
setupModal("manage-modal-delete", "delete-modal-cancel", "delete-modal-ok");

if (document.getElementById("podcast-category-selection")) {
  setupSelect("podcast-category-selection");
}

const handleFormSubmit = (formId, callback) => {
  let formElement = document.getElementById(formId);
  if (formElement) {
    formElement.addEventListener("submit", function (event) {
      event.preventDefault();
      callback(this);
    });
  }
};

handleFormSubmit("create-podcast", function () {
  let podcastNameValid = false;
  let creatorNameValid = false;
  let descriptionValid = false;

  podcastNameValid = handleInputValidation(
    "podcast-name-input",
    "Please enter a podcast name"
  );

  creatorNameValid = handleInputValidation(
    "podcast-creator-input",
    "Please enter a creator name"
  );

  descriptionValid = handleInputValidation(
    "podcast-desc-input",
    "Please enter a description"
  );

  if (!podcastNameValid || !creatorNameValid || !descriptionValid) return;

  let fileInput = document.getElementById("file-upload");
  if (!fileInput.files.length) {
    fileInfoModal.style.display = "flex";
    return;
  }

  // trigger modal confirmation
  createModal.style.display = "flex";

  // Send form when okay button is clicked
  createModal.addEventListener("okayClicked", () => {
    let form = document.getElementById("create-podcast");
    let formData = new FormData(form);

    // reappend values
    formData.append(
      "podcast-name-input",
      document.getElementById("podcast-name-input").value
    );
    formData.append(
      "podcast-creator-input",
      document.getElementById("podcast-creator-input").value
    );
    formData.append(
      "podcast-desc-input",
      document.getElementById("podcast-desc-input").value
    );
    formData.append(
      "podcast-category-selection",
      document.getElementById("podcast-category-selection").value
    );

    let xhr = createPodcast(formData);
    xhr.onload = () => {
      window.location.href = "/podcast";
    };
  });
});

handleFormSubmit("update-form", function () {
  // trigger modal confirmation
  saveChangesModal.style.display = "flex";

  // Send form when okay button is clicked
  saveChangesModal.addEventListener("okayClicked", () => {
    let form = document.getElementById("update-form");
    let formData = new FormData(form);
    // reappend values
    formData.append(
      "podcast-name-input",
      document.getElementById("podcast-name-input").value
    );
    formData.append(
      "podcast-creator-input",
      document.getElementById("podcast-creator-input").value
    );
    formData.append(
      "podcast-desc-input",
      document.getElementById("podcast-desc-input").value
    );
    formData.append(
      "podcast-category-selection",
      document.getElementById("podcast-category-selection").value
    );

    let data = {};
    let podcastId = 0;
    for (let [key, value] of formData.entries()) {
      data[key] = value;
      if (key == "podcast-id") {
        podcastId = value;
      }
    }
    let json = JSON.stringify(data);

    let xhr = updatePodcast(json, podcastId);
    xhr.onload = () => {
      window.location.href = "/podcast";
    };
  });
});

if (document.getElementById("delete-podcast")) {
  document.getElementById("delete-podcast").addEventListener("click", () => {
    deleteModal.style.display = "flex";

    deleteModal.addEventListener("okayClicked", () => {
      let podcastId = document.getElementById("podcast-id").value;
      let xhr = deletePodcast(podcastId);
      xhr.onload = () => {
        window.location.href = "/podcast";
      };
    });
  });
}

if (document.getElementById("cancel-change")) {
  document.getElementById("cancel-change").addEventListener("click", () => {
    window.location.href = "/podcast";
  });
}
