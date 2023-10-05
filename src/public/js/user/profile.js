const submitUpdateForm = async (e, elementForm, modalId) => {
  e.preventDefault();

  try {
    const formData = new FormData(document.querySelector(elementForm));

    const xhr = new XMLHttpRequest();
    xhr.open("PATCH", `/user/${formData.get("user_id")}`, true);
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
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);

          // TODO: notification
          if (response.success) {
            closeModal(modalId, true);
            updateProfileUser(jsonData);
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

    xhr.send(jsonData);
  } catch (error) {
    console.error("Error during XMLHttpRequest:", error);
  }
};

const showModalEditUser = (userId, modalId) => {
  const xhr = new XMLHttpRequest();

  xhr.open("GET", `/user/${userId}`, true);
  xhr.setRequestHeader("Content-Type", "application/json");

  // Define the callback for when the request completes
  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const user = JSON.parse(xhr.responseText);

        // Update modal with user data
        document.querySelector(`#${modalId} .avatar`).src =
          user.avatar_url || "/src/public/assets/images/avatar-template.png";
        document.querySelector(`#${modalId} [name='user_id']`).value =
          user.user_id;
        document.querySelector(`#${modalId} [name='email']`).value = user.email;
        document.querySelector(`#${modalId} [name='username']`).value =
          user.username;
        document.querySelector(`#${modalId} [name='first_name']`).value =
          user.first_name;
        document.querySelector(`#${modalId} [name='last_name']`).value =
          user.last_name;

        // Open the modal
        openModal(modalId);

        // Set up form submission
        const elementForm = `#${modalId}-form`;
        document.querySelector(elementForm).onsubmit = (e) =>
          submitUpdateForm(e, elementForm, modalId);
      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }
    } else {
      console.error("Request failed with status:", xhr.status);
    }
  };

  // Define the callback for network errors
  xhr.onerror = function () {
    console.error("Error during XMLHttpRequest");
  };

  // Send the request
  xhr.send();
};

const updateProfileUser = (jsonString) => {
  var jsonData = JSON.parse(jsonString);

  document.querySelector('#profile-username').innerHTML = jsonData.username;
  document.querySelector("#profile-fullname").innerHTML = jsonData.first_name + " " + jsonData.last_name;
  document.querySelector("#profile-email").innerHTML = jsonData.email;
};

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
}

const submitChangePasswordForm = async (e, elementForm, modalId) => {
  e.preventDefault();

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
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);

          // TODO: notification
          if (response.success) {
            closeModal(modalId, true);
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

    xhr.send(jsonData);
  } catch (error) {
    console.error("Error during XMLHttpRequest:", error);
  }
};