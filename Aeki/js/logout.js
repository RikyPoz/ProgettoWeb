document.querySelector('.logout-button').addEventListener('click', function(event) {
    event.preventDefault();
    console.log('Logout cliccato'); // Aggiungi questo log per il debug

    // Effettua la richiesta AJAX per il logout
    fetch('Ajax/api-logout.php', {
        method: 'GET',
    })
    .then(response => response.text())  // Usando .text() per visualizzare la risposta grezza
    .then(data => {
        console.log('Risposta del server:', data);  // Aggiungi un log per vedere cosa ricevi
        try {
            const jsonData = JSON.parse(data);  // Converti la risposta in JSON
            if (jsonData.status === 'success') {
                window.location.href = 'homePage.php';
            } else {
                console.error('Errore durante il logout');
            }
        } catch (e) {
            console.error('Errore nel parsing JSON:', e);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta AJAX:', error);
    });
});
