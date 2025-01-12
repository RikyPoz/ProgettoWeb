<div class="row justify-content-center my-5" style="min-height: 70vh">
    <div class="col-md-10 col-12 rounded shadow bg-light p-4">
        <div class="d-flex justify-content-center justify-content-md-start mb-5">
            <h1 class="fw-bold "style = "color:#000070">I miei Preferiti</h1>
        </div>
        <!--Prodotti-->
        <?php if (!empty($templateParams["prodotti"])): ?>
            <div class="row d-flex align-items-stretch">
                <?php foreach($templateParams["prodotti"] as $prodotto): ?>
                    <div class="col-md-3 col-6 p-2">
                        <div class="border rounded-3 bg-white d-flex flex-column p-3 h-100">
                            <div class="d-flex justify-content-center p-2">
                                <img src="<?php echo htmlspecialchars($prodotto["PercorsoImg"]); ?>" alt="<?php echo htmlspecialchars($prodotto["Nome"]); ?>" class="img-fluid" onerror="this.onerror=null; this.src='upload/not-found-image.png'"> 
                            </div>
                            <div class="d-flex flex-column align-items-center border-top text-center" style="height: 100%;">
                                <span class="fw-bold fs-4 flex-grow-1 d-flex align-items-center justify-content-center mb-1">
                                    <?php echo htmlspecialchars($prodotto["Nome"]); ?>
                                </span>
                                <div class="d-flex flex-column align-items-center">
                                    <span class="text-muted fs-5"><?php echo htmlspecialchars($prodotto["Prezzo"]); ?>€</span>
                                    <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                                    <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                                    <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"]; ?>" class="btn border border-dark btn-sm mt-2 rounded-pill me-1">
                                        <i class="bi bi-eye me-2"></i>Visualizza
                                    </a>
                                </div>
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
        <div id="userType" data-user-type="Cliente" style="display: none;"></div>
    </div>
</div>
