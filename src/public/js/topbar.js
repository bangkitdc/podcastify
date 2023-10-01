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
  document.querySelector(".arrow-icon").classList.toggle("up");
});