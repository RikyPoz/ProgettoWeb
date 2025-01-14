<div class="row justify-content-center my-5" style="min-height: 70vh">
    <div class="col-md-10 col-12 rounded shadow bg-light p-4">
        <div class="d-flex justify-content-center justify-content-md-start mb-4">
            <h1 class="fw-bold " style = "color:#000070">I miei Preferiti</h1>
        </div>
        <!--Prodotti-->
        <?php if (!empty($templateParams["prodotti"])): ?>
            <div class="row d-flex align-items-stretch">
                <?php foreach($templateParams["prodotti"] as $prodotto): ?>
                    <div class="col-md-3 col-6 p-2">
                        <div class="border rounded-3 shadow bg-white d-flex flex-column h-100">
                            <!-- Immagine -->
                            <div class="d-flex justify-content-center p-3">
                                <img src="<?php echo htmlspecialchars($prodotto["PercorsoImg"]); ?>" 
                                    alt="<?php echo htmlspecialchars($prodotto["Nome"]); ?>" 
                                    class="img-fluid" 
                                    style="max-height: 200px; object-fit: contain;" 
                                    onerror="this.onerror=null; this.src='upload/not-found-image.png'">
                            </div>
                            <!-- Informazioni -->
                            <div class="d-flex flex-column align-items-center rounded-3 shadow-sm mt-auto py-2" style="height: auto;">
                                <!-- Nome -->
                                <div class="text-center">
                                    <span class="fw-bold fs-4 d-block">
                                        <?php echo htmlspecialchars($prodotto["Nome"]); ?>
                                    </span>
                                </div>

                                <!-- altre info -->
                                <div class="d-flex flex-column align-items-center mt-4">
                                    <span class="text-muted fs-5 mb-2">
                                        <?php echo number_format($prodotto["Prezzo"], 2, ',', ''); ?>€
                                    </span>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-heart-fill fs-2 me-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="color:#B00000; display:inline-block;"></span>
                                        <span class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></span>
                                    </div>
                                    <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"]; ?>" 
                                    class="btn btn-sm mt-2 rounded-pill border-dark">
                                        <span class="bi bi-eye me-2"></span>Visualizza
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
                    <h2 class="text-muted mt-4">Nessun Mi Piace</h2>
                    <p>Non hai nessun prodotto nei preferiti</p>
                </div>
            </div>
        <?php endif; ?>
        <div id="userType" data-user-type="Cliente" style="display: none;"></div>
    </div>
</div>
