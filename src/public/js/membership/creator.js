const showCreator = (creatorId) => {
  window.location.href = "membership/creator/" + creatorId;
};

if (document.getElementById("subscribe")) {
  document.getElementById("subscribe").addEventListener("click", async () => {
    const { user_id, username } = await getSelf();
    const creator_id = document.getElementById("creator-id").value;
    const creator_name = document.getElementById("creator-name").value;

    const request = {
      creator_id: creator_id,
      creator_name: creator_name,
      subscriber_id: user_id,
      subscriber_name: username,
    };

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "/membership/subscribe", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = () => {
      const response = JSON.parse(xhr.responseText);

      if (xhr.status === 200) {
        if (response.success) {
          showNotificationSuccess(response.message);

          setTimeout(() => {
            location.replace("/membership/creator/" + creator_id);
          }, 3000);
        } else {
            showNotificationDanger(response.message);
        }
      } else {
        showNotificationDanger(response.message);
      }
    };

    xhr.send(JSON.stringify(request));
  });
}
