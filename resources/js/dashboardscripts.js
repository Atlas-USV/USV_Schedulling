document.addEventListener("DOMContentLoaded", () => {
    const addTaskButton = document.querySelector("[data-modal-target='addTaskModal']");
    const newTaskTitleInput = document.getElementById("newTaskTitle");
    const modalTaskTitleInput = document.getElementById("modalTaskTitle");
    const subjectSelect = document.getElementById("subject");
    const deadlineInput = document.getElementById("deadline");
    const descriptionInput = document.getElementById("description");
    const modal = document.getElementById("addTaskModal");

    if (addTaskButton && newTaskTitleInput && modalTaskTitleInput && subjectSelect && deadlineInput && descriptionInput && modal) {
        // Validare înainte de a deschide modalul
        addTaskButton.addEventListener("click", (event) => {
            const taskTitle = newTaskTitleInput.value.trim();

            // Dacă titlul lipsește, afișează eroarea și blochează accesul
            if (!taskTitle) {
                event.preventDefault(); // Previne comportamentul implicit de deschidere a modalului
                newTaskTitleInput.classList.add("border-red-500"); // Adaugă clasa pentru border roșu
                createToast("Please insert a title", "error"); // Afișează toastr-ul de eroare
                return; // Oprește execuția ulterioară
            }

            // Elimină clasa de eroare dacă există titlu
            newTaskTitleInput.classList.remove("border-red-500");

            // Setează titlul în input-ul modalului
            modalTaskTitleInput.value = taskTitle;

            // Manual, afișează modalul
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        // Validare în interiorul modalului
        const saveTaskButton = document.querySelector("[type='submit']");
        if (saveTaskButton) {
            saveTaskButton.addEventListener("click", (event) => {
                const selectedSubject = subjectSelect.value;
                const deadlineValue = deadlineInput.value;
                const descriptionValue = descriptionInput.value.trim();

                let isValid = true;

                // Validare pentru descriere
                if (!descriptionValue) {
                    isValid = false;
                    descriptionInput.classList.add("border-red-500");
                    createToast("Please provide a description", "error");
                } else {
                    descriptionInput.classList.remove("border-red-500");
                }

                // Validare pentru subiect
                if (!selectedSubject || selectedSubject === "") {
                    isValid = false;
                    createToast("Please select a subject", "error");
                }

                // Validare pentru deadline
                if (!deadlineValue) {
                    isValid = false;
                    createToast("Please set a deadline", "error");
                }

                // Dacă validarea eșuează, blochează submit-ul
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }

        // Închide modalul pe butonul de close
        const closeModalButtons = document.querySelectorAll("[data-modal-toggle]");
        closeModalButtons.forEach((closeButton) => {
            closeButton.addEventListener("click", () => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
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
                            ? 'd="M6 18L18 6M6 6l12 12"/>' // X icon for error
                            : 'd="M5 13l4 4L19 7"/>' // Check icon pentru success
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

    //Delete modal

    const deleteButtons = document.querySelectorAll("[data-modal-target='deleteTaskModal']");
    const deleteTaskForm = document.getElementById("deleteTaskForm");

    if (deleteButtons && deleteTaskForm) {
        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const taskId = button.getAttribute("data-task-id");
                const deleteUrl = `/tasks/${taskId}`;
                deleteTaskForm.setAttribute("action", deleteUrl);
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
