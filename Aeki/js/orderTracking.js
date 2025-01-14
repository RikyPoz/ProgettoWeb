document.addEventListener("DOMContentLoaded", () => {
    const trackButtons = document.querySelectorAll("button[id^='traccia-']");

    trackButtons.forEach(button => {
        button.addEventListener("click", () => {
            const orderId = button.getAttribute("data-idordine");
            const orderDate = new Date(button.getAttribute("data-dataordine"));
            const products = JSON.parse(button.getAttribute("data-prodotti"));

            const today = new Date();
            let orderState = 0;

            if (products.every(product => product.ProdottoSpedito === 'Y')) {
                orderState = 1;
                if (orderDate <= today) {
                    orderState = 2;
                }
            }

            showOrderPopup(orderId, orderState);
        });
    });

    function showOrderPopup(orderId, orderState) {
        const popupHTML = `
        <div class="modal fade" id="orderPopup" tabindex="-1" aria-labelledby="orderPopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderPopupLabel">Stato dell'Ordine #${orderId}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- 1 -->
                                <div>
                                    <img src="upload/in_preparazione.png" alt="In preparazione" class="img-fluid mb-2" style="width: 100px;">
                                    <p class = "fw-semibold">In preparazione</p>
                                </div>
                                <!-- 2 -->
                                <div>
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
                                     style="width: ${orderState * 50}%;background-color: ${orderState >= 0 ? '#000060' : '#000060'};">
                                </div>
                            </div>
                            
                            <!-- Phase Markers -->
                            <div class="position-absolute top-50 start-0 translate-middle" style="width: 20px; height: 20px; background-color: #000060; display:${orderState === 0 ? 'inline-block' : 'none'};border-radius: 50%;"></div>
                            <div class="position-absolute top-50 start-50 translate-middle" style="width: 20px; height: 20px; background-color: #000060; display:${orderState === 1 ? 'inline-block' : 'none'};border-radius: 50%;"></div>
                            <div class="position-absolute top-50 start-100 translate-middle" style="width: 20px; height: 20px; background-color: #000060; display:${orderState === 2 ? 'inline-block' : 'none'};border-radius: 50%;"></div>
                        </div>
                        <div class = "mt-4">
                        <span class = "fw-semibold">${orderState === 0 ? 'Il tuo pacco è in fase di preparazione!' : ''}</span>
                        <span class = "fw-semibold">${orderState === 1 ? 'Il tuo pacco è stato spedito!' : ''}</span>
                        <span class = "fw-semibold">${orderState === 2 ? 'Il tuo pacco è stato consegnato!' : ''}</span>
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
