document.getElementById('loginButton').addEventListener('click', function () {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validazione semplice
    if (!email || !password) {
        document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Inserisci tutti i campi.</div>';
        return;
    }

    // Invio dati al server tramite AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Ajax/api-login.php', true);
    console.log('Invio richiesta a:', '/api-login.php');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                document.getElementById('loginMessage').innerHTML = '<div class="alert alert-success">Login effettuato con successo. Reindirizzamento...</div>';
                setTimeout(() => {
                    window.location.href = './profile.php'; // Reindirizza dopo il login
                }, 2000);
            } else {
                document.getElementById('loginMessage').innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
            }
        } else {
            document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Errore del server. Riprova più tardi.</div>';
        }
    };

    xhr.send(JSON.stringify({ email: email, password: password }));
});
