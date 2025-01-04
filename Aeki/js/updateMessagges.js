// Variabile per tracciare l'ultima data di aggiornamento impostata inizialmente a data passata
let ultimaData = '2000-01-01 00:00:00';  

// Funzione per aggiornare i messaggi
function aggiornaMessaggi() {
    // Esegui una richiesta fetch al server per ottenere i messaggi più recenti
    fetch(`updateMessages.php?ultimaData=${encodeURIComponent(ultimaData)}`)
        .then(response => response.json())  // Converti la risposta in formato JSON
        .then(data => {
            const messaggiContainer = document.querySelector('#messaggi-container'); // Seleziona il contenitore dei messaggi
            if (!messaggiContainer) {
                console.error('Contenitore dei messaggi non trovato!');
            }
            if (data.length > 0) {
                // Se ci sono nuovi messaggi
                data.forEach(messaggio => {
                    const listItem = document.createElement('li');  // Crea un nuovo elemento di lista
                    listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                    listItem.innerHTML = `
                        ${messaggio.testo}  <!-- Mostra il contenuto del messaggio -->
                        <span class="text-muted">${messaggio.data}</span>  <!-- Mostra la data del messaggio -->
                    `;
                    messaggiContainer.prepend(listItem);  // Aggiungi il nuovo messaggio all'inizio della lista
                });

                // Aggiorna la variabile `ultimaData` con la data dell'ultimo messaggio ricevuto
                ultimaData = data[0].data;
            }
        })
        .catch(error => console.error('Errore:', error));  // Gestisci gli errori
}

// Esegui la funzione aggiornaMessaggi ogni 5 secondi (5000 millisecondi)
setInterval(aggiornaMessaggi, 5000);

// Carica i messaggi iniziali appena la pagina è pronta
aggiornaMessaggi();
