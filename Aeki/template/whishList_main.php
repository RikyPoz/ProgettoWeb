<div class="row justify-content-center">
    <div class="col-9">
        <div class = "d-flex justify-content-center justify-content-md-start">
            <h1>Preferiti</h1>
        </div>
        <!--Prodotti-->
        <div class="row d-flex align-items-stretch">
            <?php foreach($templateParams["prodotti"] as $prodotto): ?>
                <div class = "col-md-4 col-6 p-2">
                    <div class="border rounded bg-light d-flex flex-column p-3 h-100">
                        <div class = "d-flex justify-content-center">
                            <img src="<?php echo htmlspecialchars($prodotto["PercorsoImg"]); ?>" alt="<?php echo htmlspecialchars($prodotto["Nome"]); ?>" class=" img-fluid"> 
                        </div>
                        <div class = "d-flex flex-column align-items-center mt-auto">
                            <span class="fw-bold fs-4 mt-2"><?php echo htmlspecialchars($prodotto["Nome"]); ?></span>
                            <span class="text-muted fs-5"><?php echo htmlspecialchars($prodotto["Prezzo"]); ?> €</span>
                            <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                            <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                            <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"] ?>" class="btn border rounded border-dark btn-sm mt-2">Visualizza articolo</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
