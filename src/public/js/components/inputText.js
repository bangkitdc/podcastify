const debounceInputValidation = (
  inputIdentifier,
  regex,
  errorMessage,
  validationState
) => {
  const inputElement = document.querySelector(`#${inputIdentifier}`);

  inputElement.addEventListener(
    "keyup",
    debounce(
      () =>
        validateInput(inputIdentifier, regex, errorMessage, validationState),
      500
    )
  );
};

const validateInput = (
  inputIdentifier,
  regex,
  errorMessage,
  validationState
) => {
  const inputElement = document.querySelector(`#${inputIdentifier}`);
  const alertElement = document.querySelector(`#${inputIdentifier}-alert`);

  const inputValue = inputElement.value;
  const paragraphElement = alertElement.querySelector("p");

  if (!regex.test(inputValue)) {
    paragraphElement.innerText = errorMessage;

    alertElement.className = "alert-show";
    inputElement.classList.add("alert-show");
    validationState.value = false;
  } else {
    paragraphElement.innerText = "";

    alertElement.className = "alert-hide";
    inputElement.classList.remove("alert-show");
    validationState.value = true;
  }
};

const debounceInputValidationExact = (
  inputIdentifier,
  inputTarget,
  errorMessage,
  validationState
) => {
  const inputElement = document.querySelector(`#${inputIdentifier}`);
  const alertElement = document.querySelector(`#${inputIdentifier}-alert`);

  const inputElementTarget = document.querySelector(`#${inputTarget}`);

  const validateInput = () => {
    const inputValue = inputElement.value;
    const inputValueTarget = inputElementTarget.value;

    const paragraphElement = alertElement.querySelector("p");

    if (inputValue !== inputValueTarget) {
      paragraphElement.innerText = errorMessage;

      alertElement.className = "alert-show";
      inputElement.classList.add("alert-show");
      validationState.value = false;
    } else {
      paragraphElement.innerText = "";

      alertElement.className = "alert-hide";
      inputElement.classList.remove("alert-show");
      validationState.value = true;
    }
  };

  inputElement.addEventListener("keyup", debounce(validateInput, 500));
};

const handleInputValidation = (inputIdentifier, errorMessage) => {
  const inputElement = document.querySelector(`#${inputIdentifier}`);
  const alertElement = document.querySelector(`#${inputIdentifier}-alert`);

  const inputValue = inputElement.value;
  const paragraphElement = alertElement.querySelector("p");

  if (!inputValue) {
    paragraphElement.innerText = errorMessage;

    alertElement.className = "alert-show";
    inputElement.classList.add("alert-show");
    inputElement.focus();
    return false; // Indicates validation failure
  } else {
    paragraphElement.innerText = "";

    alertElement.className = "alert-hide";
    inputElement.classList.remove("alert-show");
    return true; // Indicates validation success
  }
};

document.querySelectorAll(".btn-eye").forEach(function (button) {
  button.addEventListener("click", function (event) {
    event.preventDefault();

    const parent = button.closest(".form-group");
    const passwordInput = parent.querySelector(".password-input");
    const eyeIcon = button.querySelector(".eye-icon");

    // Toggle visibility
    passwordInput.type = passwordInput.type == "password" ? "text" : "password";

    // Toggle 'visible' class on eyeIcon
    eyeIcon.classList.toggle("visible");
  });
});
