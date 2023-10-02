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
    const response = await fetch("/login", {
      method: "POST",
      body: new FormData(document.querySelector(".login-form")),
    });

    if (response.ok) {
      const data = await response.json();

      // TODO: notifications
      if (data.success) {
        location.replace(data.redirect_url);
      } else {
        console.error(data.error_message);
      }
    } else {
      console.error("Request failed with status:", response.status);
    }
  } catch (error) {
    console.error("Error during fetch:", error);
  }
};

document.querySelector(".login-form").onsubmit = submitLoginForm;