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

const submitUpdateForm = async (e, elementForm, modalId) => {
  e.preventDefault();

  let lastNameValid = false;
  let firstNameValid = false;
  let usernameValid = false;
  let emailValid = false;

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
    emailValid = handleInputValidation("email", "Please enter your email.");
  }

  if (!emailValid || !usernameValid || !firstNameValid || !lastNameValid) {
    return;
  }

  try {
    const xhr = new XMLHttpRequest();
    const formData = new FormData(document.querySelector(elementForm));
    xhr.open("POST", `/user/${formData.get("user_id")}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    // Handle Image
    const fileInput = document.getElementById("edit-avatar-file-upload");

    if (fileInput.files && fileInput.files[0]) {
      formData.append("filename", fileInput.files[0].name);
      formData.append("data", fileInput.files[0]);
    }

    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          closeModal(modalId, true);
          updateProfileUser(formData);
          showNotificationSuccess(response.status_message);
        }
      } else {
        showNotificationDanger(response.error_message);
      }
    };

    xhr.send(formData);
  } catch (error) {
    showNotificationDanger("Error during XMLHttpRequest: " + error);
  }
};

document
  .getElementById("edit-preview-avatar")
  .addEventListener("click", function () {
    // Trigger the click event on the file input
    document.getElementById("edit-avatar-file-upload").click();
  });

document
  .getElementById("edit-avatar-file-upload")
  .addEventListener("change", function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById("edit-preview-avatar").src = e.target.result;
      };
      reader.readAsDataURL(this.files[0]);

      this.value = "";
    }
  });

const showModalEditUser = (userId, modalId) => {
  try {
    const xhr = new XMLHttpRequest();

    xhr.open("GET", `/user/${userId}`, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Define the callback for when the request completes
    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          const user = response.data;

          // Update modal with user data
          document.querySelector(`#${modalId} .avatar`).src = user.avatar_url
            ? `src/storage/user/${user.avatar_url}`
            : "/src/public/assets/images/avatar-template.png";
          document.querySelector(`#${modalId} [name='user_id']`).value =
            user.user_id;
          document.querySelector(`#${modalId} [name='email']`).value =
            user.email;
          document.querySelector(`#${modalId} [name='username']`).value =
            user.username;
          document.querySelector(`#${modalId} [name='first_name']`).value =
            user.first_name;
          document.querySelector(`#${modalId} [name='last_name']`).value =
            user.last_name;

          // Update alert
          validateInput(
            "email",
            emailRegex,
            "Invalid email format.",
            emailValidation
          );

          validateInput(
            "username",
            usernameRegex,
            "Username must consist of a minimum of 6 characters, can be letters, numbers, or underscores.",
            usernameValidation
          );

          validateInput(
            "first_name",
            nameRegex,
            "First name must consist of letters only.",
            firstNameValidation
          );

          validateInput(
            "last_name",
            nameRegex,
            "Last name must consist of letters only.",
            lastNameValidation
          );

          // Open the modal
          openModal(modalId);

          // Set up form submission
          const elementForm = `#${modalId}-form`;
          document.querySelector(elementForm).onsubmit = (e) =>
            submitUpdateForm(e, elementForm, modalId);
        }
      } else {
        showNotificationDanger(response.error_message);
      }
    };

    // Send the request
    xhr.send();
  } catch (error) {
    showNotificationDanger("Error during XMLHttpRequest: " + error);
  }
};

const updateProfileUser = (formData) => {
  // Access values directly from the FormData object
  const username = formData.get("username");
  const firstName = formData.get("first_name");
  const lastName = formData.get("last_name");
  const email = formData.get("email");
  const fileInput = formData.get("edit-avatar-file-upload");

  // Update HTML elements with the retrieved values
  document.querySelector("#profile-username").innerHTML = username;
  document.querySelector(
    "#profile-fullname"
  ).innerHTML = `${firstName} ${lastName}`;
  document.querySelector("#profile-email").innerHTML = email;
  
  // Check if a file is selected
  if (fileInput instanceof File && fileInput.name.trim() !== "") {
    // Create a URL for the file
    const fileURL = URL.createObjectURL(fileInput);
    // Set the src attribute of the image element
    document.querySelector("#profile-image").src = fileURL;
  }
};


/* Change Password Modal */
const showModalChangePass = (modalIdBefore, modalId, userId) => {
  // Close modal before
  closeModal(modalIdBefore, false);

  document.querySelector(`#${modalId} [name='user_id']`).value = userId;

  document.querySelector("#current_password").value = "";
  document.querySelector("#password").value = "";
  document.querySelector("#confirm_password").value = "";

  // Open the modal
  openModal(modalId);

  // Set up form submission
  const elementForm = `#${modalId}-form`;
  document.querySelector(elementForm).onsubmit = (e) =>
    submitChangePasswordForm(e, elementForm, modalId);
};

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

const submitChangePasswordForm = async (e, elementForm, modalId) => {
  e.preventDefault();

   let confirmPasswordValid = false;
   let passwordValid = false;

  if (confirmPasswordValidation.value) {
    confirmPasswordValid = handleInputValidation(
      "confirm_password",
      "Your passwords doesn't match."
    );
  }

  if (passwordValidation.value) {
    passwordValid = handleInputValidation(
      "password",
      "Please enter your new password."
    );
  }

  const currentPasswordValid = handleInputValidation(
    "current_password",
    "Please enter your current password."
  );

  if (
    !currentPasswordValid ||
    !passwordValid ||
    !confirmPasswordValid
  ) {
    return;
  }

  try {
    const formData = new FormData(document.querySelector(elementForm));

    const xhr = new XMLHttpRequest();
    xhr.open("PATCH", `/user/changepassword/${formData.get("user_id")}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    const formDataObject = {};
    formData.forEach((value, key) => {
      formDataObject[key] = value;
    });

    // Convert JavaScript object to JSON string
    const jsonData = JSON.stringify(formDataObject);

    // Set the Content-Type header to indicate JSON data
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          closeModal(modalId, true);
          showNotificationSuccess(response.status_message);
        }
      } else {
        showNotificationDanger(response.error_message);
      }
    };

    xhr.send(jsonData);
  } catch (error) {
    showNotificationDanger("Error during XMLHttpRequest: " + error);
  }
};
