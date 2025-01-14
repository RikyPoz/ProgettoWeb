<div class="container mt-4" style="min-height: 70vh">
    <!-- Titolo -->
    <div class="col-12 my-4">
        <h1 class="fw-bold" style="color: #000070" id="cartTitle">Carrello</h1>
    </div>
    <div class="row">
        <!-- Riepilogo in alto per dispositivi mobili -->
        <div class="col-12 d-md-none mb-3" id="recapTableMobile"></div>

        <!-- Prodotti nel carrello -->
        <div class="col-md-8 mb-5 " style="overflow-y: auto; max-height: 55vh;" id="productsContainer"></div>

        <!-- Riepilogo per desktop -->
        <div class="col-md-4 d-none d-md-block" id="recapTable"></div>
    </div>
</div>

<!-- Modale checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header text-white" style="background-color:#000060;color:#FFFFFF">
                <h2 class="modal-title" id="checkoutModalLabel">Acquista i tuoi prodotti</h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="checkoutForm">
                    <!-- Riepilogo prodotti -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 style="color:#000060">Riepilogo prodotti</h2>
                            <ul id="productSummary" class="list-group shadow-sm"></ul>
                        </div>
                    </div>

                    <!-- Scelta tipo spedizione -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label" style="color:#000060" for="shippingType">Tipo di spedizione</label>
                            <select class="form-select" id="shippingType" required onchange="aggiornaSpedizione()">
                                <option value="" disabled selected>Seleziona un'opzione</option>
                                <option value="standard">Standard (5,00 €)</option>
                                <option value="express">Express (10,00 €)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Prezzo totale e consegna stimata -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h2 style="color:#000060">Prezzo totale</h2>
                            <p id="totModal" class="fw-bold text-dark">0,00 €</p>
                        </div>
                        <div class="col-md-6">
                            <h2 style="color:#000060">Arrivo previsto</h2>
                            <p id="estimatedDelivery" class="fw-bold text-dark">--</p>
                        </div>
                    </div>

                    <!-- Indirizzo -->
                    <div class="row mb-4">
                        <label class="form-label">Indirizzo di spedizione</label>
                        <div class="col-md-1 mt-1">
                            <label class="form-label" for="via">Via</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="via" value="dell'Università" readonly>
                        </div>
                        <div class="col-md-1 mt-1">
                            <label class="form-label" for="numero-civico">Numero</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="numero-civico" value="18" readonly>
                        </div>
                    </div>

                    <!-- Dettagli carta -->
                    <div class="row">
                        <!-- Tipo carta -->
                        <div class="col-md-6 mb-3">
                            <label for="cardType" class="form-label">Tipo carta</label>
                            <select class="form-select" id="cardType" required>
                                <option value="" disabled selected>Seleziona un'opzione</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                            </select>
                        </div>

                        <!-- Numero carta -->
                        <div class="col-md-6 mb-3">
                            <label for="cardNumber" class="form-label">Numero carta</label>
                            <input type="text" class="form-control" id="cardNumber" pattern="\d{16}" placeholder="Inserisci 16 cifre" required>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color:#000060;color:#FFFFFF" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn" style="background-color:#000060;color:#FFFFFF" onclick="validaDati()">Acquista</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale successo -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="orderSuccessModalLabel">Ordine effettuato con successo</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Grazie per il tuo ordine! Puoi tornare alla home o visualizzare i tuoi ordini.</p>
                <p id="successDeliveryDate" class="fw-bold">Arrivo previsto: --</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color:#000060;color:#FFFFFF" onclick="window.location.href='homePage.php'">Torna alla Home</button>
                <button type="button" class="btn" style="background-color:#000060;color:#FFFFFF" onclick="window.location.href='orderList.php'">Visualizza Ordini</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale errore -->
<div class="modal fade" id="orderErrorModal" tabindex="-1" aria-labelledby="orderErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="orderErrorModalLabel">Errore nell'ordine</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Qualcosa è andato storto durante il processo di acquisto. Ti preghiamo di riprovare.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>