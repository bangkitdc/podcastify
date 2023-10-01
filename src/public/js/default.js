// Slider Function
const sliderEl = document.querySelector("#range");

function updateSliderBackground(value) {
  const progress = (value / sliderEl.max) * 100;
  sliderEl.style.background = `linear-gradient(to right, #1bd760 ${progress}%, #a7a7a7 ${progress}%)`;
}

sliderEl.addEventListener("input", (event) => {
  const tempSliderValue = event.target.value;

  requestAnimationFrame(() => {
    updateSliderBackground(tempSliderValue);
  });
});

// Initial update
updateSliderBackground(sliderEl.value);