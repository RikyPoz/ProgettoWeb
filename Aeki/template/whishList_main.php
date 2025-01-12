<div class="row justify-content-center">
    <div class="col-md-10 col-12 mt-4">
        <div class="d-flex justify-content-center justify-content-md-start">
            <h1>Preferiti</h1>
        </div>
        <!--Prodotti-->
        <?php if (!empty($templateParams["prodotti"])): ?>
            <div class="row d-flex align-items-stretch">
                <?php foreach($templateParams["prodotti"] as $prodotto): ?>
                    <div class="col-md-4 col-6 p-2">
                        <div class="border rounded bg-light d-flex flex-column p-3 h-100">
                            <div class="d-flex justify-content-center">
                                <img src="<?php echo htmlspecialchars($prodotto["PercorsoImg"]); ?>" alt="<?php echo htmlspecialchars($prodotto["Nome"]); ?>" class="img-fluid"> 
                            </div>
                            <div class="d-flex flex-column align-items-center mt-auto">
                                <span class="fw-bold fs-4 mt-2"><?php echo htmlspecialchars($prodotto["Nome"]); ?></span>
                                <span class="text-muted fs-5"><?php echo htmlspecialchars($prodotto["Prezzo"]); ?>€</span>
                                <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                                <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                                <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"] ?>" class="btn border border-dark btn-sm mt-2 rounded-pill me-1"><i class="bi bi-eye me-2"></i>Visualizza </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
                <div class="text-center">
                    <img src="upload/noLike.png" alt="nessun mi piace" class="img-fluid">
                    <h3 class="text-muted mt-4">Nessun Mi Piace</h3>
                    <p>Non hai nessun prodotto nei preferiti</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
