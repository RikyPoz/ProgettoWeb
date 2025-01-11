// Gestisce la visualizzazione della password per 'Password Attuale'
document.getElementById('togglePasswordAttuale').addEventListener('click', function () {
    const passwordField = document.getElementById('passwordAttuale');
    const toggleIcon = document.getElementById('toggleIconAttuale');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
});

// Gestisce la visualizzazione della password per 'Nuova Password'
document.getElementById('togglePasswordNuova').addEventListener('click', function () {
    const passwordField = document.getElementById('nuovaPassword');
    const toggleIcon = document.getElementById('toggleIconNuova');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
});

// Gestisce la visualizzazione della password per 'Conferma Nuova Password'
document.getElementById('togglePasswordConferma').addEventListener('click', function () {
    const passwordField = document.getElementById('confermaNuovaPassword');
    const toggleIcon = document.getElementById('toggleIconConferma');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
});