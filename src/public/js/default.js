// Sidebar
var currentPath = window.location.pathname;

var navItems = [
  { id: 'home-nav', href: '/', imgActive: 'home-active.svg', imgInactive: 'home-inactive.svg' },
  { id: 'search-nav', href: '/search', imgActive: 'search-active.svg', imgInactive: 'search-inactive.svg' },
  { id: 'podcast-nav', href: '/podcast', imgActive: 'podcast.svg', imgInactive: 'podcast.svg' },
  { id: 'episode-nav', href: '/episode', imgActive: 'episode.svg', imgInactive: 'episode.svg' },
  { id: 'podcast-add-nav', href: '/podcast/add', imgActive: 'add-circle.svg', imgInactive: 'add-circle.svg' },
  { id: 'episode-add-nav', href: '/episode/add', imgActive: 'user.svg', imgInactive: 'user.svg' },
  { id: 'user-nav', href: '/user' }
];

for (var i = 0; i < navItems.length; i++) {
  var navItem = navItems[i];

  // Check if the currentPath matches the href of the current navItem
  if (currentPath === navItem.href) {
    // Add the 'active' class to the corresponding element by id
    document.getElementById(navItem.id).classList.add("active");

    // Change the image source to the active version
    document.getElementById(navItem.id).getElementsByTagName("img")[0].src = ICONS_DIR + navItem.imgActive;
  } else {
    // Change the image source to the inactive version for non-active items
    document.getElementById(navItem.id).getElementsByTagName("img")[0].src = ICONS_DIR + navItem.imgInactive;
  }
}

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
