const audioPlayer = document.getElementById("audio-player");
const progressSlider = document.getElementById("range");
const audioPlayerButton = document.getElementById("play-btn");
let storedTime = 0;

const playAudio = () => {
  let audioPlayer = document.getElementById("audio-player");
  let buttonImage = document.getElementById("button-image");

  let playButton = document.getElementById("play-button-image");
  let audioFile = document.getElementById("audio-file").value;

  audioPlayer.src = audioFile;
  
  if (playButton.classList.contains("audio-active")) {
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

  if(storedTime == audioPlayer.duration){
    audioPlayer.currentTime = 0;
  }
  audioPlayerButton.addEventListener('click', playAudio);
}

audioPlayer.addEventListener("timeupdate", function () {
  const currentTime = audioPlayer.currentTime;
  const duration = audioPlayer.duration;

  if (!isNaN(duration)) {
      const progress = (currentTime / duration) * 100;
      progressSlider.value = progress;
  }
  storedTime = currentTime;

  if(duration == storedTime){
    audioPlayer.currentTime = 0;

    let buttonImage = document.getElementById("button-image");
    let playButton = document.getElementById("play-button-image");
    buttonImage.src = ICONS_DIR + "play.svg";
    playButton.src = ICONS_DIR + "play.svg";
    playButton.classList.add("audio-active");
  }
})

progressSlider.addEventListener("input", function () {
  const seekTime = (progressSlider.value / 100) * audioPlayer.duration;
  audioPlayer.currentTime = seekTime;
})