<div class="container mt-4" style="height: 70vh">
    <!-- Titolo -->
    <div class="col-12 my-4">
        <h1 class="fw-bold" style="color: #000070" id="cartTitle"></h1>
    </div>
    <div class="row">
        <!-- Riepilogo in alto per dispositivi mobili -->
        <div class="col-12 d-md-none mb-3" id="recapTableMobile"></div>

        <!-- Prodotti nel carrello -->
        <div class="col-md-8 mb-5 " style="overflow-y: auto; max-height: 55vh;" id="productsContainer"></div>

        <!-- Riepilogo fisso per desktop -->
        <div class="col-md-4 d-none d-md-block" id="recapTable"></div>
    </div>
</div>
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Acquista i tuoi prodotti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="checkoutForm">
                    <!-- Riepilogo prodotti -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6>Riepilogo prodotti</h6>
                            <ul id="productSummary" class="list-group"></ul>
                        </div>
                    </div>

                    <!-- Scelta tipo spedizione -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6>Tipo di spedizione</h6>
                            <select class="form-control" id="shippingType" required onchange="aggiornaSpedizione()">
                                <option value="standard">Standard (5,00 €)</option>
                                <option value="express">Express (10,00 €)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Prezzo totale e consegna stimata -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Prezzo totale</h6>
                            <p id="totModal" class="fw-bold">0,00 €</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Arrivo previsto</h6>
                            <p id="estimatedDelivery" class="fw-bold">--</p>
                        </div>
                    </div>

                    <!-- Indirizzo -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="address" class="form-label">Indirizzo di consegna</label>
                            <input type="text" class="form-control" id="address" placeholder="Inserisci il tuo indirizzo" required>
                        </div>
                    </div>

                    <!-- Dettagli carta -->
                    <div class="row">
                        <!-- Tipo carta -->
                        <div class="col-md-6 mb-3">
                            <label for="cardType" class="form-label">Tipo carta</label>
                            <select class="form-control" id="cardType" required>
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

            <div class="modal-footer">
                <button type="button" class="btn border-dark" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn" style="background-color:#000060;color:#FFFFFF"onclick="validaDati()">Acquista</button>
            </div>
        </div>
    </div>
</div>
<!-- Modale: Ordine effettuato con successo -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderSuccessModalLabel">Ordine effettuato con successo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Grazie per il tuo ordine! Puoi tornare alla home o visualizzare i tuoi ordini.</p>
                <p id="successDeliveryDate" class="fw-bold">Arrivo previsto: --</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='homePage.php'">Torna alla Home</button>
                <button type="button" class="btn btn-primary" onclick="window.location.href='orderList.php'">Visualizza Ordini</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale: Qualcosa è andato storto -->
<div class="modal fade" id="orderErrorModal" tabindex="-1" aria-labelledby="orderErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderErrorModalLabel">Errore nell'ordine</h5>
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