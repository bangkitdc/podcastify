const submitUpdateForm = async (e, elementForm, modalId) => {
  e.preventDefault();

  try {
    const xhr = new XMLHttpRequest();
  
    const formData = new FormData(document.querySelector(elementForm));
    const formDataObject = {};
    formData.forEach((value, key) => {
      formDataObject[key] = value;
    });

    xhr.open("PATCH", `/user/status/${formData.get("user_id")}`, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    // Convert JavaScript object to JSON string
    const jsonData = JSON.stringify(formDataObject);

    // Set the Content-Type header to indicate JSON data
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
      const response = JSON.parse(xhr.responseText);
      if (xhr.status === 200) {
        if (response.success) {
          closeModal(modalId, true);
          updateStatusUser(formData.get("user_id"), formData.get("status"));
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

const showModalEditStatusUser = (userId, modalId) => {
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
          document.querySelector(`#${modalId} .modal-image`).src =
            user.avatar_url
              ? `src/storage/user/${user.avatar_url}`
              : "/src/public/assets/images/avatar-template.png";
          document.querySelector(`#${modalId} [name='user_id']`).value =
            user.user_id;
          document.querySelector(`#${modalId} [name='status']`).value =
            parseInt(user.status);

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

    xhr.send();
  } catch (error) {
    showNotificationDanger("Error during XMLHttpRequest: " + error);
  }
}

const updateStatusUser = (userId, val) => {
  const statusText = val == 0 ? "Inactive" : "Active";

  document.querySelector(`#status_user_${userId}`).innerHTML = statusText;
}