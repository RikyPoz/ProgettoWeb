document.addEventListener("DOMContentLoaded", function () {
    let ultimaData = null; // Variabile per tracciare la data dell'ultimo messaggio ricevuto
    aggiornaMessaggi(ultimaData); // Carica i messaggi iniziali
    setInterval(() => aggiornaMessaggi(ultimaData), 5000); // Esegue l'aggiornamento ogni 5 secondi
});

async function aggiornaMessaggi(ultimaData) {
    // Prepara i dati
    const data = { 
        ultimaData 
    };

    try {
        const response = await fetch('Ajax/api-updateMessages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const json = await response.json();
        console.log("Risposta dal server:", json);

        if (json.success) {
            if (json.messages && json.messages.length > 0) {
                aggiornaMessaggiUI(json.messages); // Aggiorna la UI con i nuovi messaggi
                // Aggiorna ultimaData all'ultimo messaggio ricevuto
                ultimaData = json.messages[json.messages.length - 1].Data;
                console.log("Aggiornata ultimaData a:", ultimaData);
            } else {
                console.log("Nessun nuovo messaggio trovato.");
            }
        } else {
            console.error(`Errore ricevuto dal server: ${json.message}`);
        }
    } catch (error) {
        console.error(`Errore durante l'aggiornamento dei messaggi: ${error.message}`);
    }
}

function aggiornaMessaggiUI(messaggi) {
    const messaggiContainer = document.querySelector('#messaggi-container');
    if (!messaggiContainer) {
        console.error('Contenitore dei messaggi non trovato!');
        return;
    }

    console.log("Messaggi da aggiungere:", messaggi);

    messaggi.forEach(messaggio => {
        // Controlla se il messaggio esiste già nella UI
        const esiste = Array.from(messaggiContainer.children).some(
            item => item.querySelector('span.text-muted')?.textContent === messaggio.Data
        );
        if (esiste) {
            console.log(`Messaggio già presente: ${messaggio.Data}`);
            return; // Salta il messaggio già esistente
        }

        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        const testoSpan = document.createElement('span');
        testoSpan.textContent = messaggio.Testo;

        const dataSpan = document.createElement('span');
        dataSpan.classList.add('text-muted');
        dataSpan.textContent = messaggio.Data;

        listItem.appendChild(testoSpan);
        listItem.appendChild(dataSpan);

        messaggiContainer.prepend(listItem); // Aggiunge il nuovo messaggio all'inizio
    });
}
