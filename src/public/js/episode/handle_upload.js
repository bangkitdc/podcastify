EPISODE_BASE_URL = '/episode/';

const createEpisode = (formData) => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", EPISODE_BASE_URL + "add", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(formData);

  return xhr;
}

const updateEpisode = (json, episodeId) => {
  let xhr = new XMLHttpRequest();
  console.log(EPISODE_BASE_URL + episodeId + "?edit=true");
  xhr.open("PATCH", EPISODE_BASE_URL + "/" + episodeId + "?edit=true", true);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send(json);
  return xhr;
}

const deleteEpisode = (episodeId) => {
  let xhr = new XMLHttpRequest();
  xhr.open("DELETE", EPISODE_BASE_URL + episodeId);
  xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhr.send();
  return xhr;
}

const handleFormSubmit = (formId, callback) => {
  let formElement = document.getElementById(formId);
  if (formElement) {
    formElement.addEventListener("submit", function(e) {
      e.preventDefault();
      callback(this);
    })
  };
}

handleFormSubmit("add-episode-form", function() {
  let titleValidation = false;
  let descriptionValidation = false;

  titleValidation = handleInputValidation(
    "episode-title-input",
    "Please enter a episode title"
  )

  descriptionValidation = handleInputValidation(
    "episode-description-input",
    "Please enter episode description"
  )

  if(!titleValidation || !descriptionValidation) return;

  let form = document.getElementById("add-episode-form");
  let formData = new FormData(form);

  formData.append(
    "episode-title-input",
    document.getElementById("episode-title-input").value
  )

  formData.append(
    "episode-description-input",
    document.getElementById("episode-description-input").value
  )

  let xhr = createEpisode(formData);
  console.log(xhr);
  xhr.onload = () => {
    console.log(xhr.responseText);
    // window.location.href = "/episode";
  }
})

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
  for(let [key, value] of formData.entries()){
    data[key] = value;
    if(key == 'episode_id'){
      episodeId = value;
    }
  }

  let json = JSON.stringify(data);

  let xhr = updateEpisode(json, episodeId);

  xhr.onload = () => {
    console.log(xhr.responseText);
    window.location.href = "/episode";
  };
})

handleFormSubmit("delete-episode-form", function () {
  let form = document.getElementById("delete-episode-form");
  let formData = new FormData(form);

  let episodeId = 0;
  for(let [key, value] of formData.entries()){
    if(key == 'episode_id'){
      episodeId = value;
    }
  }

  let xhr = deleteEpisode(episodeId);

  xhr.onload = () => {
    console.log(xhr.responseText);
    window.location.href = "/episode"
  }
})