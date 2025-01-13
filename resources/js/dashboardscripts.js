document.addEventListener("DOMContentLoaded", () => {
    const addTaskButton = document.querySelector("[data-modal-target='addTaskModal']");
    const newTaskTitleInput = document.getElementById("newTaskTitle");
    const modalTaskTitleInput = document.getElementById("modalTaskTitle");
    const subjectSelect = document.getElementById("subject");
    const deadlineInput = document.getElementById("deadline");
    const descriptionInput = document.getElementById("description");
    const modal = document.getElementById("addTaskModal");
    const taskForm = document.querySelector('#addTaskModal form');

    if (addTaskButton && newTaskTitleInput && modalTaskTitleInput && subjectSelect && deadlineInput && descriptionInput && modal) {
        // Modal opening logic
        addTaskButton.addEventListener("click", (event) => {
            const taskTitle = newTaskTitleInput.value.trim();

            if (!taskTitle) {
                event.preventDefault();
                newTaskTitleInput.classList.add("border-red-500");
                createToast("Please insert a title", "error");
                return;
            }

            newTaskTitleInput.classList.remove("border-red-500");
            modalTaskTitleInput.value = taskTitle;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        // Form submission handling
        if (taskForm) {
            taskForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const selectedSubject = subjectSelect.value;
                const deadlineValue = deadlineInput.value;
                const descriptionValue = descriptionInput.value.trim();

                let isValid = true;

                  // Check if deadline is today
            const selectedDate = new Date(deadlineValue);
            const today = new Date();

            // Reset both dates to midnight for date-only comparison
            selectedDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            if (selectedDate.getTime() === today.getTime()) {
                isValid = false;
                deadlineInput.classList.add("border-red-500");
                createToast("Tasks cannot be created for the current day", "error");
            } else {
                deadlineInput.classList.remove("border-red-500");
            }

                if (!descriptionValue) {
                    isValid = false;
                    descriptionInput.classList.add("border-red-500");
                    createToast("Please provide a description", "error");
                }

                if (!selectedSubject || selectedSubject === "") {
                    isValid = false;
                    createToast("Please select a subject", "error");
                }

                if (!deadlineValue) {
                    isValid = false;
                    createToast("Please set a deadline", "error");
                }

                if (!isValid) {
                    return;
                }

                try {
                    const formData = new FormData(taskForm);
                    
                    const response = await fetch(taskForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    if (response.ok) {
                        // Reset form and inputs
                        taskForm.reset();
                        newTaskTitleInput.value = '';
                        
                        // Close modal
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        
                        createToast('Task added successfully!', 'success');
                        
                        // Reload the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    } else {
                        const errorData = await response.json();
                        createToast(errorData.message || 'Failed to add task. Please try again.', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    createToast('An error occurred. Please try again.', 'error');
                }
            });
        }

        // Modal close button handling
        const closeModalButtons = document.querySelectorAll("[data-modal-toggle]");
        closeModalButtons.forEach((closeButton) => {
            closeButton.addEventListener("click", () => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                // Reset form on modal close
                if (taskForm) {
                    taskForm.reset();
                    newTaskTitleInput.value = '';
                }
            });
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
        toast.className = `flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 ${
            type === "error" ? "border-l-4 border-red-500" : "border-l-4 border-green-500"
        }`;

        // Updated toast HTML structure with single close button
        toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${
                type === "error" 
                ? "text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200" 
                : "text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
            }">
                ${type === "error" 
                    ? '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'
                    : '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
                }
            </div>
            <div class="ml-3 text-sm font-normal">${message}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-900 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        // Add the toast to the container
        toastContainer.appendChild(toast);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);

        // Add click handler for close button
        toast.querySelector("button").addEventListener("click", () => toast.remove());
    };

    // Gestionare modal Delete Task
    const deleteButtons = document.querySelectorAll("[data-modal-target='deleteTaskModal']");
    
    deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            const taskId = button.getAttribute("data-task-id");
            const deleteTaskForm = document.getElementById("deleteTaskForm");
            if (deleteTaskForm) {
                deleteTaskForm.setAttribute("action", `/tasks/${taskId}`);
            }
        });
    });

    // Initialize Flowbite modal
    const $modalElement = document.querySelector('#deleteTaskModal');
    
    if ($modalElement) {
        const modalOptions = {
            placement: 'center-center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            closable: true,
        }
        
        const modal = new Modal($modalElement, modalOptions);
        
        // Optional: Add event listeners for modal events
        $modalElement.addEventListener('show.modal.flowbite', () => {
            console.log('Modal is shown');
        });

        $modalElement.addEventListener('hide.modal.flowbite', () => {
            console.log('Modal is hidden');
        });
    }
    //Real Time Hour
    
    const timeDisplay = document.getElementById("time-display");

    if (timeDisplay) {
        const updateTime = () => {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, "0");
            const minutes = now.getMinutes().toString().padStart(2, "0");
            const seconds = now.getSeconds().toString().padStart(2, "0");
            timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
        };

        // Actualizează ora la fiecare secundă
        updateTime();
        setInterval(updateTime, 1000);
    }
    

    //Timer

      // Selectează elementele din DOM
      const timerDisplay = document.getElementById("timer-display");
const startButton = document.getElementById("start-timer");
const pauseButton = document.getElementById("pause-timer");
const resetButton = document.getElementById("reset-timer");

// Verifică dacă toate elementele timer-ului există
if (timerDisplay && startButton && pauseButton && resetButton) {
    // Variabile globale pentru timer
    let timerInterval = null;
    let remainingTime = 25 * 60; // 25 minute în secunde

    // Funcție pentru a formata timpul
    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes.toString().padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;
    };

    // Actualizează afișajul timer-ului
    const updateDisplay = () => {
        timerDisplay.textContent = formatTime(remainingTime);
    };

    // Funcție pentru a începe timer-ul
    const startTimer = () => {
        if (timerInterval) return; // Evită multiple intervale

        timerInterval = setInterval(() => {
            if (remainingTime > 0) {
                remainingTime--;
                updateDisplay();
            } else {
                clearInterval(timerInterval);
                timerInterval = null;
                alert("Time's up!");
            }
        }, 1000);

        // Actualizează butoanele
        startButton.classList.add("hidden");
        pauseButton.classList.remove("hidden");
        resetButton.classList.remove("hidden");
    };

    // Funcție pentru a pune pauză la timer
    const pauseTimer = () => {
        clearInterval(timerInterval);
        timerInterval = null;

        // Actualizează butoanele
        startButton.textContent = "Resume";
        startButton.classList.remove("hidden");
        pauseButton.classList.add("hidden");
    };

    // Funcție pentru a reseta timer-ul
    const resetTimer = () => {
        clearInterval(timerInterval);
        timerInterval = null;
        remainingTime = 25 * 60; // Resetează la 25 minute
        updateDisplay();

        // Actualizează butoanele
        startButton.textContent = "Start";
        startButton.classList.remove("hidden");
        pauseButton.classList.add("hidden");
        resetButton.classList.add("hidden");
    };

    // Evenimente pentru butoane
    startButton.addEventListener("click", startTimer);
    pauseButton.addEventListener("click", pauseTimer);
    resetButton.addEventListener("click", resetTimer);

    // Inițializează afișajul timer-ului
    updateDisplay();
} else {
    console.warn("Focus Timer elements are not available for this user role.");
}
});
