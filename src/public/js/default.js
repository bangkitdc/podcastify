// Slider Function
const sliderEls = document.querySelectorAll("#range");
const sliderVolumeEl = document.querySelector("#volume-slider");

sliderEls.forEach(sliderEl => {
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
  // Initial update
  updateSliderBackground(sliderEl.value);
  audioPlayer.addEventListener("timeupdate", function () {
  updateSliderBackground(sliderSmall.value);
  updateSliderBackground(sliderBig.value);
})
})


sliderVolumeEl.addEventListener("input", (event)=> {
  const tempSliderValue = event.target.value;
  requestAnimationFrame(() => {
    updateVolumeSlider(tempSliderValue);
  });
})

