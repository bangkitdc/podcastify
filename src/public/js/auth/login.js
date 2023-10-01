const usernameInput = document.querySelector("#username");
const passwordInput = document.querySelector("#password");
const loginForm = document.querySelector(".login-form");
const usernameAlert = document.querySelector("#username-alert");
const passwordAlert = document.querySelector("#password-alert");

let usernameValid = false;
let passwordValid = false;

loginForm &&
  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const username = usernameInput.value;
    const password = passwordInput.value;

    const usernameParagraph = usernameAlert.querySelector("p");
    const passwordParagraph = passwordAlert.querySelector("p");

    if (!username) {
      if (usernameParagraph) {
        usernameParagraph.innerText = "Please enter your Podcastify username.";
      }
      usernameAlert.className = "alert-show";
      usernameValid = false;
    } else {
      if (usernameParagraph) {
        usernameParagraph.innerText = "";
      }
      usernameAlert.className = "alert-hide";
      usernameValid = true;
    }

    if (!password) {
      if (passwordParagraph) {
        passwordParagraph.innerText = "Please enter your password.";
      }
      passwordAlert.className = "alert-show";
      passwordValid = false;
    } else {
      if (passwordParagraph) {
        passwordParagraph.innerText = "";
      }
      passwordAlert.className = "alert-hide";
      passwordValid = true;
    }

    if (!usernameValid || !passwordValid) {
      return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/login", true);

    const formData = new FormData();
    formData.append("username", username);
    formData.append("password", password);

    xhr.send(formData);
    xhr.onload = function () {
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);

          // TODO: notification
          if (response.success) {
            window.location.href = response.redirect_url;
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
  });