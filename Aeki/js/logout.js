document.querySelector('.logout-button').addEventListener('click', function (event) {
    event.preventDefault();
    console.log('Logout cliccato');

    // Crea il modale dinamicamente
    const modal = document.createElement('div');
    modal.style.position = 'fixed';
    modal.style.zIndex = '1';
    modal.style.left = '0';
    modal.style.top = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'flex-start';
    modal.style.opacity = '0';
    modal.style.transition = 'opacity 0.3s ease-in-out';

    // Contenuto del modale
    const modalContent = document.createElement('div');
    modalContent.style.backgroundColor = '#fff';
    modalContent.style.padding = '20px';
    modalContent.style.borderRadius = '10px';
    modalContent.style.textAlign = 'center';
    modalContent.style.width = '350px';
    modalContent.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
    modalContent.style.transform = 'scale(0.8)';
    modalContent.style.transition = 'transform 0.3s ease, opacity 0.3s ease';

    // Messaggio del modale
    const message = document.createElement('p');
    message.innerText = 'Sei sicuro di voler effettuare il logout?';
    message.style.fontSize = '16px';
    message.style.color = '#333';
    modalContent.appendChild(message);

    // Pulsante "Logout"
    const logoutButton = document.createElement('button');
    logoutButton.innerText = 'Logout';
    logoutButton.style.padding = '12px 24px';
    logoutButton.style.margin = '10px';
    logoutButton.style.border = 'none';
    logoutButton.style.backgroundColor = '#4CAF50';
    logoutButton.style.color = '#fff';
    logoutButton.style.cursor = 'pointer';
    logoutButton.style.fontSize = '16px';
    logoutButton.style.borderRadius = '5px';
    logoutButton.style.transition = 'background-color 0.3s ease';
    logoutButton.addEventListener('mouseenter', () => {
        logoutButton.style.backgroundColor = '#45a049';
    });
    logoutButton.addEventListener('mouseleave', () => {
        logoutButton.style.backgroundColor = '#4CAF50';
    });
    modalContent.appendChild(logoutButton);

    // Pulsante "Annulla"
    const cancelButton = document.createElement('button');
    cancelButton.innerText = 'Annulla';
    cancelButton.style.padding = '12px 24px';
    cancelButton.style.margin = '10px';
    cancelButton.style.border = 'none';
    cancelButton.style.backgroundColor = '#f44336';
    cancelButton.style.color = '#fff';
    cancelButton.style.cursor = 'pointer';
    cancelButton.style.fontSize = '16px';
    cancelButton.style.borderRadius = '5px';
    cancelButton.style.transition = 'background-color 0.3s ease';
    cancelButton.addEventListener('mouseenter', () => {
        cancelButton.style.backgroundColor = '#d32f2f';
    });
    cancelButton.addEventListener('mouseleave', () => {
        cancelButton.style.backgroundColor = '#f44336';
    });
    modalContent.appendChild(cancelButton);

    // Aggiunge il contenuto al modale
    modal.appendChild(modalContent);
    document.body.appendChild(modal);

    // Mostra il modale
    setTimeout(() => {
        modal.style.opacity = '1';
        modalContent.style.transform = 'scale(1)';
    }, 10);

    // Gestisce il click sul pulsante "Logout"
    logoutButton.addEventListener('click', function () {
        // Effettua la richiesta AJAX per il logout
        fetch('Ajax/login/api-logout.php', {
            method: 'GET',
        })
            .then(response => response.text())
            .then(data => {
                console.log('Risposta del server:', data);
                try {
                    const jsonData = JSON.parse(data);
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

        // Nasconde il modale dopo aver cliccato "Logout"
        modal.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(modal);
        }, 300);
    });

    // Gestisce il click sul pulsante "Annulla"
    cancelButton.addEventListener('click', function () {
        console.log('Logout annullato');
        modal.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(modal);  // Nasconde il modale
        }, 300);
    });
});
