const setupSelect = (selectId) => {
  var select = document.getElementById(selectId);
  select.addEventListener("click", function () {
    var arrowIcon = document.getElementById("base-select-arrow-" + selectId);
    arrowIcon.classList.toggle("rotate");
  });
  select.addEventListener("blur", function () {
    var arrowIcon = document.getElementById("base-select-arrow-" + selectId);
    if (arrowIcon.classList.contains("rotate")) {
      arrowIcon.classList.remove("rotate");
    }
  });
};
