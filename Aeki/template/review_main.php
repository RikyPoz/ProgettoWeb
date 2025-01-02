
<?php $prodotto = $templateParams["prodotto"];?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-10 mt-4">
                <h1 class="text-center">Recensisci Prodotto</h1>
                <hr class = "my-4">
                <!-- Sezione prodotto -->
                <div class="d-flex flex-column flex-md-row align-items-center mb-2">
                    <div class="me-md-4">
                        <img src="<?php echo $prodotto["PercorsoImg"]?>" alt="Immagine Prodotto" class="img-fluid rounded" style="max-width: 150px;">
                    </div>
                    <div>
                        <h2 class="fs-4 fw-semibold"><?php echo $prodotto["Nome"]?></h2>
                        <p class="text-muted"><?php echo htmlspecialchars($prodotto["Prezzo"]); ?>€</p>
                    </div>
                </div>

                <!-- Form per recensione -->
                <form id="review-form">
                    <input type="hidden" name="productId" value="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>">

                    <!-- Valutazione -->
                    <div id="rating" class="d-inline-flex">
                        <i class="bi bi-star-fill text-warning fs-3" data-value="1"></i>
                        <i class="bi bi-star-fill text-secondary fs-3" data-value="2"></i>
                        <i class="bi bi-star-fill text-secondary fs-3" data-value="3"></i>
                        <i class="bi bi-star-fill text-secondary fs-3" data-value="4"></i>
                        <i class="bi bi-star-fill text-secondary fs-3" data-value="5"></i>
                    </div>
                    <p id="rating-value" class="mt-2">Valutazione: 1</p>
                    <input type="hidden" id="rating-value-input" name="rating" value="1">

                    <!-- Commento -->
                    <div class="mb-4">
                        <label for="comment" class="form-label">Commento:</label>
                        <textarea id="comment" name="comment" class="form-control" rows="5" placeholder="Scrivi qui il tuo commento..." required></textarea>
                    </div>

                    <!-- Pulsanti -->
                    <div class="d-flex justify-content-end">
                        <a href="orderList.php" class="btn btn-secondary me-2">Annulla</a>
                        <button type="submit" class="btn btn-primary">Invia Recensione</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    


</html>