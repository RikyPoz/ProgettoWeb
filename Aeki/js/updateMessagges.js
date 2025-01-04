// Variabile per tracciare l'ultima data di aggiornamento
let ultimaData = '2000-01-01 00:00:00';

// Funzione per aggiornare i messaggi
function aggiornaMessaggi() {
    fetch(`getMessaggi.php?ultimaData=${encodeURIComponent(ultimaData)}`)
        .then(response => response.json())
        .then(data => {
            const messaggiContainer = document.querySelector('.list-group');

            if (data.length > 0) {
                data.forEach(messaggio => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                    listItem.innerHTML = `
                        ${messaggio.contenuto}
                        <span class="text-muted">${messaggio.dataMessaggio}</span>
                    `;
                    messaggiContainer.prepend(listItem); // Aggiunge i nuovi messaggi in cima
                });
                // Aggiorna la data dell'ultimo messaggio ricevuto
                ultimaData = data[0].dataMessaggio;
            }
        })
        .catch(error => console.error('Errore:', error));
}

// Esegui la funzione ogni 5 secondi
setInterval(aggiornaMessaggi, 5000);

// Carica i messaggi iniziali
aggiornaMessaggi();
