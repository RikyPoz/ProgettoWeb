<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="row">
            <?php foreach($templateParams["prodotti"] as $prodotto): ?>
                <div class="col-md-3 d-flex flex-column align-items-center border p-3">
                    <img src="<?php echo htmlspecialchars($prodotto["img"]); ?>" alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>" class="img-fluid"> 
                    <p class="fw-bold"><?php echo htmlspecialchars($prodotto["nome"]); ?></p>
                    <p class="text-muted"><?php echo htmlspecialchars($prodotto["prezzo"]); ?> €</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
