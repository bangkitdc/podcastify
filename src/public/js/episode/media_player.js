const audioPlayer = document.getElementById("audio-player");
const progressSlider = document.getElementById("range");
const audioPlayerButton = document.getElementById("play-btn");
const mediaCover = document.getElementById("media-cover");
const currentTimeDisplay = document.getElementById("slider-current-time");
const totalTimeDisplay = document.getElementById("slider-total-time");
const volumeSlider = document.getElementById("volume-slider");
const muteButton = document.getElementById("mute-button");
const muteButtonImg = document.getElementById("mute-button-img");

let storedTime = 0;
audioPlayer.volume = 1;
let isCover = false;

const addCover = (divElmt) => {
  let poster = document.getElementById("episode-detail-head-image");
  let title = document.getElementById("episode-detail-head-title");
  let creator = document.getElementById("episode-detail-foot-creator-name");
  let creator_id = document.getElementById("creator_id").value;

  let audioImg = document.createElement("img");
  audioImg.classList.add("player-poster");
  audioImg.src = poster.src;

  let audioDesc = document.createElement("div");
  audioDesc.classList.add("player-desc");

  let audioTitle = document.createElement("p");
  audioTitle.classList.add("player-title");
  audioTitle.textContent = title.textContent;

  let audioCreator = document.createElement("p");
  audioCreator.classList.add("player-creator");
  audioCreator.textContent = creator.textContent;
  audioCreator.onclick = function () {
    window.location.href = "/podcast/show/" + creator_id;
  };

  if (!mediaCover.classList.contains("media-cover-active")) {
    audioDesc.appendChild(audioTitle);
    audioDesc.appendChild(audioCreator);

    divElmt.appendChild(audioImg, audioTitle, audioCreator);
    divElmt.appendChild(audioDesc);
    mediaCover.classList.add("media-cover-active");
  }
};

const playAudio = () => {
  let audioPlayer = document.getElementById("audio-player");
  let buttonImage = document.getElementById("button-image");

  let playButton = document.getElementById("play-button-image");
  let audioFile = document.getElementById("audio-file").value;

  audioPlayer.src = audioFile;

  if (!localStorage.getItem("totalPlayed")) {
    localStorage.setItem("totalPlayed", 0);
  }

  var totalPlayed = parseInt(localStorage.getItem("totalPlayed"));
  console.log(totalPlayed);

  if (totalPlayed >= 3) {
    showNotificationDanger("Please login to listen more");

    setTimeout(() => {
      location.replace("/login");
    }, 3000);
    return;
  } else {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/episode/validate/" + totalPlayed);
    xhr.send();

    xhr.onload(() => {
      const response = JSON.parse(xhr.responseText);
      if (!response.success) {
        showNotificationDanger("Please login to listen more");

        setTimeout(() => {
          location.replace("/login");
        }, 3000);
        return;
      }
    });
  }

  if (playButton.classList.contains("audio-active")) {
    localStorage.setItem("totalPlayed", totalPlayed + 1);
    playButton.classList.remove("audio-active");
    audioPlayer.play();
    audioPlayer.currentTime = storedTime;
    buttonImage.src = ICONS_DIR + "pause.svg";
    playButton.src = ICONS_DIR + "pause.svg";
    buttonImage.classList.add("audio-active");
  } else {
    playButton.classList.add("audio-active");
    audioPlayer.pause();
    audioPlayer.currentTime = storedTime;
    buttonImage.src = ICONS_DIR + "play.svg";
    playButton.src = ICONS_DIR + "play.svg";
    buttonImage.classList.remove("audio-active");
  }

  if (storedTime == audioPlayer.duration) {
    audioPlayer.currentTime = 0;
  }
  audioPlayerButton.addEventListener("click", playAudio);
  if (!isCover) {
    addCover(mediaCover);
  }
};

audioPlayer.addEventListener("timeupdate", function () {
  const currentTime = audioPlayer.currentTime;
  const duration = audioPlayer.duration;

  let currentTimeFormatted = formatTime(currentTime);
  let totalTimeFormatted = formatTime(duration);

  currentTimeDisplay.textContent = currentTimeFormatted;

  if (!isNaN(duration)) {
    const progress = (currentTime / duration) * 100;
    progressSlider.value = progress;
    totalTimeDisplay.textContent = totalTimeFormatted;
  }
  storedTime = currentTime;

  if (duration == storedTime) {
    audioPlayer.currentTime = 0;

    let buttonImage = document.getElementById("button-image");
    let playButton = document.getElementById("play-button-image");
    buttonImage.src = ICONS_DIR + "play.svg";
    playButton.src = ICONS_DIR + "play.svg";
    playButton.classList.add("audio-active");
    // mediaCover.classList.remove("media-cover-active");
  }
});

audioPlayer.addEventListener("error", function (e) {
  console.error("Error loading audio:", e.message);
  showNotificationDanger("No Audio File Found.");
});

progressSlider.addEventListener("input", function () {
  const seekTime = (progressSlider.value / 100) * audioPlayer.duration;
  audioPlayer.currentTime = seekTime;
});

function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds < 10 ? "0" : ""}${remainingSeconds}`;
}

const updateVolume = () => {
  audioPlayer.volume = volumeSlider.value;
};

const toggleMute = () => {
  if (audioPlayer.muted) {
    audioPlayer.muted = false;
    muteButtonImg.src = ICONS_DIR + "volume.svg";
  } else {
    audioPlayer.muted = true;
    muteButtonImg.src = ICONS_DIR + "volume-mute.svg";
  }
};

// Event listener for volume slider
volumeSlider.addEventListener("input", updateVolume);

// Event listener for mute button
muteButton.addEventListener("click", toggleMute);
