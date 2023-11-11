// Slider Function
const sliderEls = document.querySelectorAll("#range");
const sliderVolumeEl = document.querySelector("#volume-slider");

sliderEls.forEach((sliderEl) => {
  function updateSliderBackground(value) {
    const progress = (value / sliderEl.max) * 100;
    sliderEl.style.background = `linear-gradient(to right, #1bd760 ${progress}%, #a7a7a7 ${progress}%)`;
  }

  function updateVolumeSlider(value) {
    const progress = (value / sliderVolumeEl.max) * 100;
    sliderVolumeEl.style.background = `linear-gradient(to right, #f9f9f9 ${progress}%, #808080 ${progress}%)`;
  }

  sliderEl.addEventListener("input", (event) => {
    const tempSliderValue = event.target.value;

    requestAnimationFrame(() => {
      updateSliderBackground(tempSliderValue);
    });
  });
  // Initial update
  updateSliderBackground(sliderEl.value);
  audioPlayer.addEventListener("timeupdate", function () {
    updateSliderBackground(sliderSmall.value);
    updateSliderBackground(sliderBig.value);
  });
});

sliderVolumeEl.addEventListener("input", (event) => {
  const tempSliderValue = event.target.value;
  requestAnimationFrame(() => {
    updateVolumeSlider(tempSliderValue);
  });
});

// Poll for new notification
const SUBSCRIPTION_NOTIFICATION_BASE_PATH = "/subscription";
const SELF_BASE_PATH = "/user/self";

const getUserID = async () => {
  return new Promise((resolve, reject) => {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", SELF_BASE_PATH, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        console.log(data.data);
        resolve(data.data);
      } else {
        resolve(-1);
      }
    };
    xhr.send();
  });
};

const subscriptionNotificationText = (creatorName, fail = false) => {
  return `Your subscription request to ${creatorName} has been ${
    fail ? "rejected" : "accepted"
  }`;
};

const fetchNewNotification = async () => {
  var xhr = new XMLHttpRequest();

  let userID = await getUserID();
  xhr.open(
    "GET",
    SUBSCRIPTION_NOTIFICATION_BASE_PATH + "?user_id=" + userID,
    true
  );
  xhr.onload = async () => {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      const data = response.data;

      const delay = (ms) => new Promise((res) => setTimeout(res, ms));

      if (data.length > 0 && userID !== -1) {
        for (let status of data) {
          if (status.status === "ACCEPTED") {
            showNotificationSuccess(
              subscriptionNotificationText(status.creator_name)
            );
          } else if (status.status === "REJECTED") {
            showNotificationDanger(
              subscriptionNotificationText(status.creator_name, true)
            );
          }
          // add a delay before showing the next notification
          if (data.length > 1) {
            await delay(2500);
          }
        }
      }
    }
    // Poll again after a delay (5 - 7 seconds)
    var delay = Math.random() * 2000 + 5000;
    setTimeout(fetchNewNotification, delay);
  };
  xhr.send();
};

fetchNewNotification();
