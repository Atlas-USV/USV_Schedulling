document.addEventListener('DOMContentLoaded', function () {
    const themeSwitch = document.getElementById('theme-switch');
    const currentTheme = localStorage.getItem('theme');

    // Verifică tema curentă și setează tema la încărcarea paginii
    if (currentTheme === 'dark') {
        document.body.classList.add('dark');
        themeSwitch.checked = true;
    }

    // Când switch-ul este schimbat
    themeSwitch.addEventListener('change', function () {
        if (themeSwitch.checked) {
            document.body.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    });
});
