const BASE_PATH_TO_IMG = "/src/storage/podcast/";

const goToPodcast = (podcastId) => {
  window.location.href = "/podcast/show/" + podcastId;
};

window.onload = () => {
  var xhrPodcast = new XMLHttpRequest();
  xhrPodcast.open("GET", "/podcast/random/8", true);

  xhrPodcast.onload = () => {
    if (xhrPodcast.status >= 200 && xhrPodcast.status < 300) {
      var response = JSON.parse(xhrPodcast.responseText);
      if (response.success) {
        var data = response.data;
        var cardsContainer = document.querySelector(
          ".podcast-list .cards-container"
        );
        cardsContainer.innerHTML = "";

        if (data.length > 0) {
          data.forEach((podcast) => {
            let card = document.createElement("div");
            card.className = "card";
            card.onclick = function () {
              goToPodcast(podcast.podcast_id);
            };

            let imgPlaceholder = document.createElement("div");
            imgPlaceholder.className = "card-img-placeholder";
            let img = document.createElement("img");
            img.src =
              podcast.image_url == "" || podcast.image_url == null
                ? "/src/public/assets/images/podcast-template.png"
                : BASE_PATH_TO_IMG + podcast.image_url;
            img.alt = "podcastImage";
            img.className = "card-img";
            imgPlaceholder.appendChild(img);
            card.appendChild(imgPlaceholder);

            let name = document.createElement("p");
            let podcastTitle = podcast.title
              .toLowerCase()
              .split(" ")
              .map((word) => {
                return word.charAt(0).toUpperCase() + word.slice(1);
              })
              .join(" ");
            name.textContent = podcastTitle;
            name.className = "card-name";
            card.appendChild(name);

            let description = document.createElement("p");
            description.textContent = podcast.description;
            description.className = "card-description";
            card.appendChild(description);

            cardsContainer.appendChild(card);
          });
        } else {
          let message = document.createElement("h1");
          message.textContent = "No Podcast Available!";
          cardsContainer.appendChild(message);
        }
      } else {
        showNotificationDanger(response.error_message);
      }
    } else {
      const response = JSON.parse(xhrPodcast.responseText);
      showNotificationDanger(response.error_message);
    }
  };

  xhrPodcast.onerror = function () {
    showNotificationDanger("Request failed.");
  };

  xhrPodcast.send();
};
