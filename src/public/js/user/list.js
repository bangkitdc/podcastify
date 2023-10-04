const submitUpdateForm = async (e, elementForm, modalId) => {
  e.preventDefault();

  try {
    const xhr = new XMLHttpRequest();
    xhr.open("PATCH", "/user/status", true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    const formData = new FormData(document.querySelector(elementForm));
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
            closeModal(modalId);
            updateStatusUser(formData.get("user_id"), formData.get("status"));
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

const showModalEditStatusUser = (userId, modalId) => {
  const xhr = new XMLHttpRequest();

  xhr.open("GET", `/user/edit/${userId}`, true);
  xhr.setRequestHeader("Content-Type", "application/json");

  // Define the callback for when the request completes
  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        const user = JSON.parse(xhr.responseText);

        // Update modal with user data
        document.querySelector(`#${modalId} .modal-image`).src =
          user.avatar_url || "/src/public/assets/images/avatar-template.png";
        document.querySelector(`#${modalId} [name='user_id']`).value =
          user.user_id;
        document.querySelector(`#${modalId} [name='status']`).value = parseInt(user.status);

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
}

const updateStatusUser = (userId, val) => {
  const statusText = val == 0 ? "Inactive" : "Active";

  document.querySelector(`#status_user_${userId}`).innerHTML = statusText;
}