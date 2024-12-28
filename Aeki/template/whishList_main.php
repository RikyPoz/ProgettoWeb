<div class="row justify-content-center">
    <div class="col-9">
        <div class = "d-flex justify-content-center justify-content-md-start">
            <h1>Preferiti</h1>
        </div>
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg border rounded bg-light my-4">
            <div class="container-fluid ">
                <a class="navbar-brand fs-4" href="#">Categorie</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <?php foreach($templateParams["categorie"] as $categoria):?>
                    <!-- if categoria attiva
                    <a class="nav-link active" aria-current="page" href="#">Divani</a> 
                    else -->
                    <a class="nav-link" href="#"> <?php echo $categoria["NomeCategoria"] ?> </a>
                    <?php endforeach; ?>
                </div>
                </div>
            </div>
        </nav>
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
                            <button class="btn">
                                <i class="bi bi-heart-fill text-danger fs-3"></i>
                            </button>
                            <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"] ?>" class="btn border rounded border-dark btn-sm mt-2">Visualizza articolo</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
