const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const usernameRegex = /^\w{5,}$/;
const nameRegex = /^[a-zA-Z]+(?: [a-zA-Z]+)*$/;
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

const emailValidation = { value: true }; // Initial state
debounceInputValidation(
  "email",
  emailRegex,
  "Invalid email format.",
  emailValidation
);

const usernameValidation = { value: true }; // Initial state
debounceInputValidation(
  "username",
  usernameRegex,
  "Username must consist of a minimum of 5 characters, can be letters, numbers, or underscores.",
  usernameValidation
);

const firstNameValidation = { value: true }; // Initial state
debounceInputValidation(
  "first_name",
  nameRegex, 
  "First name must consist of letters only.",
  firstNameValidation
);

const lastNameValidation = { value: true }; // Initial state
debounceInputValidation(
  "last_name",
  nameRegex,
  "Last name must consist of letters only.",
  lastNameValidation
);

// Customize
const passwordValidation = { value: true }; // Initial state
const inputPassword = document.querySelector('#password');
const alertPassword = document.querySelector('#password-alert');

const inputConfirmPassword = document.querySelector("#confirm_password");
const alertConfirmPassword = document.querySelector("#confirm_password-alert");

inputPassword &&
  inputPassword.addEventListener(
    "keyup",
    debounce(() => {
      const password = inputPassword.value;
      const confirmPassword = inputConfirmPassword.value;

      const paragraphPassword = alertPassword.querySelector("p");
      const paragraphConfirmPassword = alertConfirmPassword.querySelector("p");

      if (!passwordRegex.test(password)) {
        paragraphPassword.innerText = "Password must consist of a minimum of 8 characters, at least one letter, one number, and one special character.";

        alertPassword.className = "alert-show";
        inputPassword.className = "alert-show";
        passwordValidation.value = false;
      } else {
        paragraphPassword.innerText = "";

        alertPassword.className = "alert-hide";
        inputPassword.classList.remove("alert-show");
        passwordValidation.value = true;
      }

      if (confirmPassword) {
        if (password !== confirmPassword) {
          paragraphConfirmPassword.innerText = "Your passwords doesn't match.";

          alertConfirmPassword.className = "alert-show";
          inputConfirmPassword.className = "alert-show";
          confirmPasswordValidation.value = false;
        } else {
          paragraphConfirmPassword.innerText = "";

          alertConfirmPassword.className = "alert-hide";
          inputConfirmPassword.classList.remove("alert-show");
          confirmPasswordValidation.value = true;
        }
      }
    }, 500)
  );

const confirmPasswordValidation = { value: true }; // Initial state
debounceInputValidationExact(
  "confirm_password",
  "password",
  "Your passwords doesn't match.",
  confirmPasswordValidation
);


const submitRegisterForm = async (e) => {
  e.preventDefault();

  let confirmPasswordValid = false;
  let passwordValid = false;
  let lastNameValid = false;
  let firstNameValid = false;
  let usernameValid = false;
  let emailValid = false;

  // Urutan reverse dari atas ke bawah agar focus() dapat ke atas duluan
  if (confirmPasswordValidation.value) {
    confirmPasswordValid = handleInputValidation(
      "confirm_password",
      "Your passwords doesn't match."
    ); 
  }

  if (passwordValidation.value) {
    passwordValid = handleInputValidation(
      "password",
      "Please enter your password."
    );
  }

  if (lastNameValidation.value) {
    lastNameValid = handleInputValidation(
      "last_name",
      "Please enter your last name."
    );
  }

  if (firstNameValidation.value) {
    firstNameValid = handleInputValidation(
      "first_name",
      "Please enter your first name."
    );
  }

  if (usernameValidation.value) {
    usernameValid = handleInputValidation(
      "username",
      "Please enter your Podcastify username."
    );
  } 

  if (emailValidation.value) {
    emailValid = handleInputValidation(
      "email",
      "Please enter your email."
    );
  }

  if (
    !emailValid ||
    !usernameValid ||
    !firstNameValid ||
    !lastNameValid ||
    !passwordValid ||
    !confirmPasswordValid
  ) {
    return;
  }

  try {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/register", true);

    const formData = new FormData(document.querySelector(".register-form"));
    formData.delete("confirm_password");

    xhr.onload = function () {
      if (xhr.status === 201) {
        try {
          const response = JSON.parse(xhr.responseText);

          // TODO: notification
          if (response.success) {
            location.replace(response.redirect_url);
          } else {
            console.error(response.error_message);
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      } else {
        console.error("Request failed with status:", xhr.status);
      }
    };

    xhr.onerror = function () {
      console.error("Error during XMLHttpRequest");
    };

    xhr.send(formData);
  } catch (error) {
    console.error("Error during XMLHttpRequest:", error);
  }
};

document.querySelector(".register-form").onsubmit = submitRegisterForm;