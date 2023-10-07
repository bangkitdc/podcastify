const setupModal = (modalId, cancelId, okayId = "") => {
  let modal = document.getElementById(modalId);
  let okayBtn = document.getElementById(okayId);
  let closeBtn = document.getElementById(cancelId);

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  if (okayBtn) {
    okayBtn.addEventListener("click", () => {
      // Custom event for modal
      let event = new CustomEvent("okayClicked", {
        detail: { message: "Okay button clicked" },
        bubbles: true,
        cancelable: true,
      });

      modal.dispatchEvent(event);

      modal.style.display = "none";
    });
  }
};

const closeModal = (modalId, changeZ) => {
  var modal = document.getElementById(modalId);
  if (changeZ) {
    var topbar = document.querySelector(".topbar");
    topbar.style.zIndex = 2;
  }

  modal.style.display = "none";
}

const openModal = (modalId) => {
  var modal = document.getElementById(modalId);
  var topbar = document.querySelector(".topbar");
  topbar.style.zIndex = 1;
  
  modal.style.display = "block";
}