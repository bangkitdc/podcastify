// Slider Function
const sliderEl = document.querySelector("#range");
const sliderVolumeEl = document.querySelector("#volume-slider");

function updateSliderBackground(value) {
  const progress = (value / sliderEl.max) * 100;
  sliderEl.style.background = `linear-gradient(to right, #1bd760 ${progress}%, #a7a7a7 ${progress}%)`;
}

function updateVolumeSlider(value) {
  const progress = (value / sliderVolumeEl.max) * 100;
  sliderVolumeEl.style.background = `linear-gradient(to right, #f9f9f9 ${progress}%, #808080 ${progress}%)`;
}

sliderEl.addEventListener("input", (event) => {
  const tempSliderValue = event.target.value;

  requestAnimationFrame(() => {
    updateSliderBackground(tempSliderValue);
  });
});

sliderVolumeEl.addEventListener("input", (event)=> {
  const tempSliderValue = event.target.value;
  requestAnimationFrame(() => {
    updateVolumeSlider(tempSliderValue);
  });
})

// Initial update
updateSliderBackground(sliderEl.value);
audioPlayer.addEventListener("timeupdate", function () {
  updateSliderBackground(progressSlider.value);
})