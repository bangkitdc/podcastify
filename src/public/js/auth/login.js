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
      if (xhr.status === 200) {
        try {
          const data = JSON.parse(xhr.responseText);

          // TODO: notifications
          if (data.success) {
            location.replace(data.redirect_url);
          } else {
            console.error(data.error_message);
          }
        } catch (parseError) {
          console.error("Error parsing JSON response:", parseError);
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

document.querySelector(".login-form").onsubmit = submitLoginForm;