document.addEventListener("DOMContentLoaded", function () {
    aggiornaMessaggi(); // Carica i messaggi iniziali
    setInterval(aggiornaMessaggi, 5000); // Esegue l'aggiornamento ogni 5 secondi
});

async function aggiornaMessaggi() {
    const data = { ultimaData }; // Prepara i dati con l'ultima data nota

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

        if (json.success) {
            aggiornaMessaggiUI(json.messages); // Aggiorna la UI con i nuovi messaggi
            ultimaData = json.messages[json.messages.length - 1].Data; // Aggiorna l'ultima data
        } else if (json.error) {
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

    // Log per vedere i messaggi che vengono passati alla funzione
    console.log("Messaggi da aggiungere:", messaggi);

    messaggi.forEach(messaggio => {
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
