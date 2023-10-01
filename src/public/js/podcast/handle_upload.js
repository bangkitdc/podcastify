UPLOAD_BASE_URL = "/podcast";

const uploadPodcastImage = (url, async = true, data = null) => {
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", UPLOAD_BASE_URL + url, async);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.setRequestHeader("Content-Type", "application/json");
  xhttp.send(data);
  return xhttp;
};

const createPodcast = (formData) => {
  let xhttp = new XMLHttpRequest();
  xhttp.open("POST", UPLOAD_BASE_URL + "/create", true);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.send(formData);
  return xhttp;
};

const updatePodcast = (json, podcastId) => {
  let xhttp = new XMLHttpRequest();
  xhttp.open("PATCH", UPLOAD_BASE_URL + "/edit/" + podcastId, true);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.send(json);
  return xhttp;
};

const deletePodcast = (podcastId) => {
  let xhttp = new XMLHttpRequest();
  xhttp.open("DELETE", UPLOAD_BASE_URL + "/edit/" + podcastId, true);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  return xhttp;
};

document.getElementById("file-upload").addEventListener("change", function () {
  console.log("Woii");
  if (this.files && this.files[0]) {
    console.log("inside");
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
