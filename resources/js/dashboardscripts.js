document.addEventListener("DOMContentLoaded", () => {
  // Gestionarea modurilor (deschidere și închidere)
  const modals = document.querySelectorAll("[data-modal-target]");
  modals.forEach((modalToggle) => {
      modalToggle.addEventListener("click", (event) => {
          const targetModalId = modalToggle.getAttribute("data-modal-target");
          const modal = document.getElementById(targetModalId);

          if (modal) {
              modal.classList.remove("hidden");
              modal.classList.add("flex");
          }
      });
  });

  const closeModalButtons = document.querySelectorAll("[data-modal-toggle]");
  closeModalButtons.forEach((closeButton) => {
      closeButton.addEventListener("click", () => {
          const modalId = closeButton.getAttribute("data-modal-toggle");
          const modal = document.getElementById(modalId);

          if (modal) {
              modal.classList.add("hidden");
              modal.classList.remove("flex");
          }
      });
  });

  // Adăugarea task-urilor cu modal și titlu automat
  const addTaskButton = document.querySelector("[data-modal-target='addTaskModal']");
  const newTaskTitleInput = document.getElementById("newTaskTitle");
  const modalTaskTitleInput = document.getElementById("modalTaskTitle");

  if (addTaskButton && newTaskTitleInput && modalTaskTitleInput) {
      addTaskButton.addEventListener("click", (event) => {
          const taskTitle = newTaskTitleInput.value.trim();
          if (taskTitle) {
              modalTaskTitleInput.value = taskTitle;
          } else {
              // Previne deschiderea modalului dacă titlul lipsește
              event.stopImmediatePropagation();
              createToast("Please insert a title", "error");
          }
      });
  }

  // Funcție pentru afișarea toast-urilor
  const createToast = (message, type = "success") => {
      const toastContainer = document.getElementById("toast-container");

      if (!toastContainer) {
          console.error("Toast container is missing!");
          return;
      }

      const toast = document.createElement("div");
      toast.className = `flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 ${
          type === "error" ? "border-red-500" : "border-green-500"
      }`;
      toast.innerHTML = `
          <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${
              type === "error" ? "text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200" : "text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
          } rounded-lg">
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" ${
                      type === "error"
                          ? 'd="M6 18L18 6M6 6l12 12"/>'
                          : 'd="M5 13l4 4L19 7"/>'
                  }
              </svg>
          </div>
          <div class="ml-3 text-sm font-normal">${message}</div>
          <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
              <span class="sr-only">Close</span>
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
          </button>
      `;

      toastContainer.appendChild(toast);

      setTimeout(() => {
          toast.remove();
      }, 5000);

      toast.querySelector("button").addEventListener("click", () => toast.remove());
  };
});
