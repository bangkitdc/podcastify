// Sidebar
var currentPath = window.location.pathname;

var navItems = [
  {
    id: "home-nav",
    href: "/",
    imgActive: "/home-active.svg",
    imgInactive: "/home-inactive.svg",
  },
  {
    id: "search-nav",
    href: "/search",
    imgActive: "/search-active.svg",
    imgInactive: "/search-inactive.svg",
  },
  {
    id: "podcast-nav",
    href: "/podcast",
    imgActive: "/podcast.svg",
    imgInactive: "/podcast.svg",
  },
  {
    id: "episode-nav",
    href: "/episode",
    imgActive: "/episode.svg",
    imgInactive: "/episode.svg",
  },
  {
    id: "podcast-add-nav",
    href: "/podcast/add",
    imgActive: "/add-circle.svg",
    imgInactive: "/add-circle.svg",
  },
  {
    id: "episode-add-nav",
    href: "/episode/add",
    imgActive: "/add-circle.svg",
    imgInactive: "/add-circle.svg",
  },
  {
    id: "user-nav",
    href: "/user",
    imgActive: "/user.svg",
    imgInactive: "/user.svg",
  },
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

document.addEventListener("mouseup", function (e) {
  var dropdownBtn = document.getElementById("dropdown-btn");

  var nextNode = dropdownBtn.parentNode.nextElementSibling;

  // Check if the click is outside of the dropdown and the next node
  if (!dropdownBtn.contains(e.target) && !nextNode.contains(e.target)) {
    nextNode.classList.remove("active");
  }
});

document.getElementById("dropdown-btn").addEventListener("click", function () {
  document.querySelector(".dropdown-container").classList.toggle("active");
  // document.querySelector(".arrow").classList.toggle("down");
  // document.querySelector(".arrow").classList.toggle("up");
});