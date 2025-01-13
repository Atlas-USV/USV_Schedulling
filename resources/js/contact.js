document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('static-modal');
    const closeModalButtons = document.querySelectorAll('[data-modal-hide]');

    // Ascunde modalul când utilizatorul apasă pe "X" sau "OK"
    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Dacă e nevoie, adaugă și alte comportamente pentru afișarea modalului
    if (modal) {
        modal.style.display = 'flex'; // Pentru a-l face vizibil dacă apare mesajul de succes
    }
});
