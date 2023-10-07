const submitLoginForm = async (e) => {
  e.preventDefault();

  // Urutan reverse dari atas ke bawah agar focus() dapat ke atas duluan
  const passwordValid = handleInputValidation(
    "password",
    "Please enter your password."
  );

  const usernameValid = handleInputValidation(
    "username",
    "Please enter your Podcastify username."
  );

  if (!usernameValid || !passwordValid) {
    return;
  }
  
  try {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/login", true);

    const formData = new FormData(document.querySelector(".login-form"));

    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);

      if (xhr.status === 200) {
        if (response.success) {
          showNotificationSuccess(response.status_message);

          setTimeout(() => {
            location.replace(response.redirect_url);
          }, 3000);
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

document.querySelector(".login-form").onsubmit = submitLoginForm;