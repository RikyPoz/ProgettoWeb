function updateNotificationCount() {
    fetch('Ajax/api-getUnreadMessages.php')
        .then(response => response.json())
        .then(data => {
            const unreadCount = data.unread_count;
            const badgeElement = document.getElementById('unreadCount');
            
            if (unreadCount > 0) {
                if (badgeElement) {
                    badgeElement.textContent = unreadCount;
                } else {
                    const newBadge = document.createElement('span');
                    newBadge.classList.add('badge', 'bg-danger');
                    newBadge.id = 'unreadCount';
                    newBadge.style.position = 'absolute';
                    newBadge.style.top = '-5px';
                    newBadge.style.right = '-5px';
                    newBadge.style.fontSize = '0.8rem';
                    newBadge.textContent = unreadCount;
                    document.querySelector('#profileDropdown').appendChild(newBadge);
                }
            } else {
                if (badgeElement) {
                    badgeElement.remove();
                }
            }
        })
        .catch(error => console.error('Errore nell\'aggiornamento delle notifiche:', error));
}

// Aggiorna le notifiche ogni 2 secondi 
setInterval(updateNotificationCount, 2000);
window.onload = updateNotificationCount;