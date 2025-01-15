

document.addEventListener("DOMContentLoaded", () => {
    const trackButtons = document.querySelectorAll("button[id^='traccia-']");

    trackButtons.forEach(button => {
        button.addEventListener("click", () => {
            const orderId = button.getAttribute("data-idOrdine");
            let stateCode = button.getAttribute("data-codiceStato");
            const shippingDay = button.getAttribute("data-giorniSpedizione");
            const today = new Date().toISOString().slice(0, 10);
            if (today >= shippingDay && stateCode == 1) {
                stateCode = 2;
            }
            showOrderPopup(orderId, stateCode, shippingDay);
        });
    });

    function showOrderPopup(orderId, stateCode, shippingDay) {
        const popupHTML = `
        <div class="modal fade" id="orderPopup" tabindex="-1" aria-labelledby="orderPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderPopupLabel">Stato dell'Ordine #${orderId}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="d-flex justify-content-between">
                                <!-- 1 -->
                                <div>
                                    <img src="upload/in_preparazione.png" alt="In preparazione" class="img-fluid mb-2" style="width: 100px;">
                                    <p class = "fw-semibold">In preparazione</p>
                                </div>
                                <!-- 2 -->
                                <div class = "mt-auto">
                                    <img src="upload/spedito.png" alt="Spedito" class="img-fluid mb-2" style="width: 100px;">
                                    <p class = "fw-semibold">Spedito</p>
                                </div>
                                <!-- 3 -->
                                <div>
                                    <img src="upload/consegnato.png" alt="Consegnato" class="img-fluid mb-2" style="width: 100px;">
                                    <p class = "fw-semibold">Consegnato</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="position-relative">
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar " role="progressbar" 
                                     style="width: ${stateCode * 50}%;background-color: ${stateCode >= 0 ? '#000060' : '#000060'};">
                                </div>
                            </div>
                            
                            <!-- Phase Markers -->
                            <div class="position-absolute top-50 start-0 translate-middle" style="width: 16px; height: 16px; background-color:${stateCode >= 0 ? '#000060' : '#D2D2D2'};border-radius: 50%;"></div>
                            <div class="position-absolute top-50 start-50 translate-middle" style="width: 16px; height: 16px; background-color:${stateCode >= 1 ? '#000060' : '#D2D2D2'};border-radius: 50%;"></div>
                            <div class="position-absolute top-50 start-100 translate-middle" style="width: 16px; height: 16px; background-color:${stateCode >= 2 ? '#000060' : '#D2D2D2'};border-radius: 50%;"></div>
                        </div>
                        <div class = "mt-4">
                        <span class = "fw-semibold">${stateCode == 0 ? 'Il tuo pacco è in fase di preparazione!' : ''}</span>
                        <span class = "fw-semibold">${stateCode == 1 ? 'Il tuo pacco è stato spedito!' : ''}</span>
                        <span class = "fw-semibold">${stateCode == 2 ? 'Il tuo pacco è stato consegnato!' : ''}</span>
                        <p class="fw-semibold">${stateCode < 2 ? `La data stimata di consegna è: ${shippingDay}` : `Data di consegna: ${shippingDay}`}</p>

                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style = "background-color: #000060;color: #FFFFFF" class="btn" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>`;

        // Aggiungi il popup al DOM
        document.body.insertAdjacentHTML("beforeend", popupHTML);

        // Inizializza e mostra il modal Bootstrap
        const modalElement = document.getElementById('orderPopup');
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();

        // Rimuovi il popup dal DOM quando viene chiuso
        modalElement.addEventListener('hidden.bs.modal', () => {
            modalElement.remove();
        });
    }




});
