const setupModal = (modalId, cancelId, okayId = "") => {
  let modal = document.getElementById(modalId);
  let okayBtn = document.getElementById(okayId);
  let closeBtn = document.getElementById(cancelId);

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  if (okayBtn) {
    okayBtn.addEventListener("click", () => {
      console.log("OKAAAY");
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
