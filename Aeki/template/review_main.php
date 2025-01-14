<?php $prodotto = $templateParams["prodotto"]; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 mt-4">
            <h1 class="text-center">Recensisci il Prodotto</h1>
            <hr class="my-4">

            <!-- Sezione prodotto -->
            <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                <div class="me-md-5 mb-3 mb-md-0">
                    <img src="<?php echo $prodotto["PercorsoImg"]?>" alt="Immagine Prodotto" class="img-fluid" style="max-width: 150px;">
                </div>
                <div>
                    <h2><?php echo $prodotto["Nome"]?></h2>
                    <p class="text-muted fs-4"><?php echo htmlspecialchars($prodotto["Prezzo"]); ?>€</p>
                </div>
            </div>

            <!-- Form per recensione -->
            <form id="review-form">
                <input type="hidden" name="productId" value="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>">

                <!-- Valutazione -->
                <div id="rating" class="d-inline-flex mb-3">
                    <span class="bi bi-star-fill fs-2 star-rating text-warning" data-value="1"></span>
                    <span class="bi bi-star-fill fs-2 star-rating text-secondary" data-value="2"></span>
                    <span class="bi bi-star-fill fs-2 star-rating text-secondary" data-value="3"></span>
                    <span class="bi bi-star-fill fs-2 star-rating text-secondary" data-value="4"></span>
                    <span class="bi bi-star-fill fs-2 star-rating text-secondary" data-value="5"></span>
                </div>
                <p class = "mt-2 fs-4">Valutazione: <span id="rating-value" class="fw-semibold fs-4">1</span></p>
                <input type="hidden" id="rating-value-input" name="rating" value="1">

                <!-- Commento -->
                <div class="mb-4">
                    <label for="comment" class="form-label fs-5 text-dark">Commento:</label>
                    <textarea id="comment" name="comment" class="form-control shadow-sm" rows="5" placeholder="Scrivi qui il tuo commento..." required></textarea>
                </div>

                <!-- Pulsanti -->
                <div class="d-flex justify-content-center justify-content-md-end">
                    <a href="orderList.php" class="btn btn-outline-secondary me-2 px-4 py-2 rounded-pill shadow-sm hover-shadow" role="button">
                        <span class="bi bi-x-circle me-2"></span>Annulla
                    </a>
                    <button type="submit" class="btn px-4 py-2 rounded-pill shadow-sm hover-shadow" style = "background-color:#000060;color:#FFFFFF"role="button">
                        <span class="bi bi-send me-2"></span>Invia Recensione
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


