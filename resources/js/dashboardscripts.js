document.addEventListener("DOMContentLoaded", () => {
    const addTaskButton = document.querySelector("[data-modal-target='addTaskModal']");
    const modal = document.getElementById("addTaskModal");
    const taskForm = document.querySelector('#addTaskModal form');
    const subjectSelect = document.getElementById("subject");
    const deadlineInput = document.getElementById("deadline");
    const descriptionInput = document.getElementById("description");

    if (addTaskButton && modal) {
        // Open modal on button click
        addTaskButton.addEventListener("click", () => {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        // Close modal
        const closeModalButtons = document.querySelectorAll("[data-modal-toggle]");
        closeModalButtons.forEach((closeButton) => {
            closeButton.addEventListener("click", () => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                if (taskForm) {
                    taskForm.reset(); // Reset form when modal is closed
                }
            });
        });

        // Handle form submission
        if (taskForm) {
            taskForm.addEventListener('submit', (e) => {
                const selectedSubject = subjectSelect?.value || '';
                const deadlineValue = deadlineInput?.value || '';
                const descriptionValue = descriptionInput?.value.trim() || '';
            
                let isValid = true;
            
                // Client-side validation
                if (!selectedSubject) {
                    isValid = false;
                    subjectSelect.classList.add("border-red-500");
                } else {
                    subjectSelect.classList.remove("border-red-500");
                }
            
                if (!descriptionValue) {
                    isValid = false;
                    descriptionInput.classList.add("border-red-500");
                } else {
                    descriptionInput.classList.remove("border-red-500");
                }
            
                const selectedDate = new Date(deadlineValue);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
            
                if (!deadlineValue || selectedDate < today) {
                    isValid = false;
                    deadlineInput.classList.add("border-red-500");
                } else {
                    deadlineInput.classList.remove("border-red-500");
                }
            
               
            });
        }
        
        // Keep the existing toast auto-hide functionality
        document.addEventListener("DOMContentLoaded", () => {
            const successToast = document.getElementById("toast-success");
            const errorToast = document.getElementById("toast-error");
        
            if (successToast || errorToast) {
                setTimeout(() => {
                    successToast?.classList.add("hidden");
                    errorToast?.classList.add("hidden");
                }, 3000);
            }
        });
    }

    

    // Gestionare modal Delete Task
    const deleteButtons = document.querySelectorAll("[data-modal-target='deleteTaskModal']");
const deleteTaskForm = document.getElementById("deleteTaskForm");

if (deleteButtons && deleteTaskForm) {
    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const taskId = button.getAttribute("data-task-id");
            const deleteUrl = `/tasks/${taskId}`; // Actualizează cu ruta ta de ștergere
            deleteTaskForm.setAttribute("action", deleteUrl);

            // Afișează modalul
            const modal = document.getElementById("deleteTaskModal");
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
        });
    });

    // Închide modalul când se apasă pe butonul "No, cancel"
    const closeModalButtons = document.querySelectorAll("[data-modal-hide='deleteTaskModal']");
    closeModalButtons.forEach(button => {
        button.addEventListener("click", () => {
            const modal = document.getElementById("deleteTaskModal");
            if (modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }
        });
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
