const setupSelect = (selectId) => {
  var select = document.getElementById(selectId);
  select.addEventListener("click", () => {
    var arrowIcon = document.getElementById("base-select-arrow-" + selectId);
    arrowIcon.classList.toggle("rotate");
  });
  select.addEventListener("blur", () => {
    var arrowIcon = document.getElementById("base-select-arrow-" + selectId);
    if (arrowIcon.classList.contains("rotate")) {
      arrowIcon.classList.remove("rotate");
    }
  });
};

const setupCheckboxes = (checkboxesId) => {
  var checkboxes = document.getElementById(checkboxesId);
  var arrowIcon = document.getElementById(
    "base-checkbox-arrow-" + checkboxesId
  );

  var opened = false;

  arrowIcon.addEventListener("click", () => {
    if (opened) {
      arrowIcon.classList.remove("rotate");
      checkboxes.classList.remove("open");
      opened = false;
    } else {
      arrowIcon.classList.toggle("rotate");
      checkboxes.classList.add("open");
      opened = true;
    }
  });

  var inputs = checkboxes.querySelectorAll('input[type="checkbox"]');

  inputs.forEach(function (input) {
    if (input.value == "All") {
      input.addEventListener("change", () => {
        if (!input.checked) {
          // Uncheck all checkboxes if "All" got unchecked
          inputs.forEach((input) => {
            input.checked = false;
          });
        }
      });
    }
    input.addEventListener("change", () => {
      var checked = checkboxes.querySelectorAll(
        'input[type="checkbox"]:checked'
      );
      checked.forEach((checkedBox) => {
        if (checkedBox.value == "All") {
          // Check all checkboxes if "All" got checked
          inputs.forEach((input) => {
            input.checked = true;
          });
        }
      });
    });
  });
};

const getCheckboxesValue = (checkboxesId) => {
  var checkboxes = document.getElementById(checkboxesId);
  var checked = checkboxes.querySelectorAll('input[type="checkbox"]:checked');
  let checkedValues = [];
  checked.forEach((checkedBox) => {
    checkedValues.push(checkedBox.value);
  });
  return checkedValues;
};
