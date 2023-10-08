const showNotificationSuccess = (responseMessage) => {
  const notification = document.querySelector("#notification");
  notification.classList.remove("danger");
  notification.classList.add("success");

  const notificationText = document.querySelector("#notification-text");
  notificationText.innerHTML = responseMessage;

  setTimeout(() => {
    hideNotification(notification);
  }, 4000);
};

const showNotificationDanger = (responseMessage) => {
  const notification = document.querySelector("#notification");
  notification.classList.remove("success");
  notification.classList.add("danger");

  const notificationText = document.querySelector("#notification-text");
  notificationText.innerHTML = responseMessage;

  setTimeout(() => {
    hideNotification(notification);
  }, 4000);
}

const hideNotification = (notification) => {
  notification.classList.remove("success");
  notification.classList.remove("danger");
};

document.querySelector("#notification").addEventListener("click", () => {
  const notification = document.querySelector("#notification");
  const notificationText = document.querySelector("#notification-text");
  hideNotification(notification, notificationText);
});
