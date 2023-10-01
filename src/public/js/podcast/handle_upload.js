const uploadPodcastImage = (url, async = true, data = null) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", PODCAST_BASE_URL + url, async);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.send(data);
  return xhr;
};

const createPodcast = (formData) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", PODCAST_BASE_URL + "/create", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(formData);
  return xhr;
};

const updatePodcast = (json, podcastId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("PATCH", PODCAST_BASE_URL + "/edit/" + podcastId, true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
  return xhr;
};

const deletePodcast = (podcastId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", PODCAST_BASE_URL + "/edit/" + podcastId, true);
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
      document.getElementById("preview-image-filename").value =
        document.getElementById("file-upload").files[0].name;
      var base64String = e.target.result.replace(/^data:(.*;base64,)?/, "");

      let url = "/upload?type=image";

      let data = JSON.stringify({
        filename: document.getElementById("file-upload").files[0].name,
        data: base64String,
      });
      uploadPodcastImage(url, true, data);
    };
    reader.readAsDataURL(this.files[0]);
  }
});

const handleFormSubmit = (formId, callback) => {
  let formElement = document.getElementById(formId);
  if (formElement) {
    formElement.addEventListener("submit", function (event) {
      event.preventDefault();
      callback(this);
    });
  }
};

handleFormSubmit("create-podcast", function (form) {
  let fileInput = document.getElementById("file-upload");
  if (!fileInput.files.length) {
    // TODO: replace this with appropriate modal
    alert("Please choose a file!");
    return;
  }

  let formData = new FormData(form);

  let xhr = createPodcast(formData);
  xhr.onload = () => {
    console.log(xhr.responseText);
    alert("Success!");
  };
});

handleFormSubmit("update-form", function (form) {
  let formData = new FormData(form);

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
    console.log(xhr.responseText);
    alert("Success!");
  };
});

if (document.getElementById("delete-podcast")) {
  document.getElementById("delete-podcast").addEventListener("click", () => {
    let podcastId = document.getElementById("podcast-id").value;
    let xhr = deletePodcast(podcastId);
    xhr.onload = () => {
      console.log(xhr.responseText);
      alert("Success!");
    };
  });
}

if (document.getElementById("cancel-change")) {
  document.getElementById("cancel-change").addEventListener("click", () => {
    window.location.href = "/podcast";
  });
}
