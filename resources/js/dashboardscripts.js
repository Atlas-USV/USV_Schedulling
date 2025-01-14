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
               
            } else {
                deadlineInput.classList.remove("border-red-500");
            }

                if (!descriptionValue) {
                    isValid = false;
                    descriptionInput.classList.add("border-red-500");
                    
                }

                if (!selectedSubject || selectedSubject === "") {
                    isValid = false;
                    
                }

                if (!deadlineValue) {
                    isValid = false;
                    
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
                        
                        c
                        
                        // Reload the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    } else {
                        const errorData = await response.json();
                       
                    }
                } catch (error) {
                    console.error('Error:', error);
                    
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
