const PODCAST_MANAGE_BASE_URL = "/podcast";

let isSubmittingForm = false;

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
      if (!isSubmittingForm) {
        callback(this);
      }
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
    if (isSubmittingForm) return;
    isSubmittingForm = true;

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

    // upload image to server
    let uploadUrl = "/upload";
    let fileField = document.getElementById("file-upload");
    let imgFormData = new FormData();
    imgFormData.append("filename", fileField.files[0].name);
    imgFormData.append("data", fileField.files[0]);

    let xhrImg = uploadPodcastImage(uploadUrl, true, imgFormData);
    xhrImg.onload = () => {
      if (xhrImg.status >= 200 && xhrImg.status < 300) {
        formData.append("preview-image-filename", xhrImg.responseText);

        let xhr = createPodcast(formData);

        xhr.onload = () => {
          if (xhr.status >= 200 && xhr.status < 300) {
            showNotificationSuccess("Successfully created a podcast!");

            setTimeout(() => {
              window.location.href = "/podcast";
            }, 3000);
          } else {
            const response = JSON.parse(xhr.responseText);

            showNotificationDanger(response.error_message);
          }
        };
      } else {
        const response = JSON.parse(xhr.responseText);

        showNotificationDanger(response.error_message);
      }
      isSubmittingForm = false;
    };
  });
});

handleFormSubmit("update-form", function () {
  // trigger modal confirmation
  saveChangesModal.style.display = "flex";

  // Send form when okay button is clicked
  saveChangesModal.addEventListener("okayClicked", () => {
    if (isSubmittingForm) return;
    isSubmittingForm = true;

    const sendPodcastEditPayload = (payloadForm) => {
      let data = {};
      let podcastId = 0;
      for (let [key, value] of payloadForm.entries()) {
        data[key] = value;
        if (key == "podcast-id") {
          podcastId = value;
        }
      }
      let json = JSON.stringify(data);
      let xhr = updatePodcast(json, podcastId);

      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          showNotificationSuccess("Successfully updated a podcast!");

          setTimeout(() => {
            window.location.href = "/podcast";
          }, 3000);
        } else {
          const response = JSON.parse(xhr.responseText);

          showNotificationDanger(response.error_message);
        }
        isSubmittingForm = false;
      };
    };

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

    // upload image to server
    let uploadUrl = "/upload";
    let fileField = document.getElementById("file-upload");
    let imgFormData = new FormData();
    if (fileField.files[0]) {
      imgFormData.append("filename", fileField.files[0].name);
      imgFormData.append("data", fileField.files[0]);

      let xhrImg = uploadPodcastImage(uploadUrl, true, imgFormData);

      xhrImg.onload = () => {
        if (xhrImg.status >= 200 && xhrImg.status < 300) {
          formData.append("preview-image-filename", xhrImg.responseText);

          sendPodcastEditPayload(formData);
        } else {
          const response = JSON.parse(xhr.responseText);

          showNotificationDanger(response.error_message);
        }
      };
    } else {
      sendPodcastEditPayload(formData);
    }
  });
});

if (document.getElementById("delete-podcast")) {
  document.getElementById("delete-podcast").addEventListener("click", () => {
    deleteModal.style.display = "flex";

    deleteModal.addEventListener("okayClicked", () => {
      let podcastId = document.getElementById("podcast-id").value;
      let xhr = deletePodcast(podcastId);

      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          showNotificationSuccess("Successfully deleted a podcast!");

          setTimeout(() => {
            window.location.href = "/podcast";
          }, 3000);
        } else {
          const response = JSON.parse(xhr.responseText);

          showNotificationDanger(response.error_message);
        }
      };
    });
  });
}

if (document.getElementById("cancel-change")) {
  document.getElementById("cancel-change").addEventListener("click", () => {
    window.location.href = "/podcast";
  });
}
