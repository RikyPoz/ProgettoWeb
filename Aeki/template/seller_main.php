<?php $venditore = $templateParams["venditore"];?>
<div class="container-fluid">
    <div class="row">
        <!-- Colonna laterale -->
        <div class="col-md-3 p-4 border-end">
            <h4>Profilo Venditore</h4>
            <div class="mb-4">
                <img src="<?php echo $venditore["Icona"]?>" class="img-fluid rounded-circle" alt="Immagine Profilo">
                <h5 class="mt-2"><?php echo $venditore["Nome"] ; echo " "; echo $venditore["Cognome"]?></h5>
                <p><strong>Username:</strong> <?php echo $venditore["Username"]?></p>
                <p><strong>Email:</strong> <?php echo $venditore["Email"]?></p>
                <p><strong>Contatto:</strong> <?php echo $venditore["Telefono"]?></p>
                <p><strong>P_IVA:</strong> <?php echo $venditore["PartitaIVA"]?></p>
            </div>

            <div class="btn-group-vertical w-100">
                <button class="btn btn-primary mb-1" id="viewProductsBtn">Visualizza i Prodotti</button>
                <button class="btn btn-primary mb-1" id="viewOrdersBtn">Visualizza Ordini</button>
                <button class="btn btn-primary mb-1" id="viewStatsBtn">Visualizza Statistiche</button>
                <button class="btn btn-primary" id="viewReviewsBtn">Visualizza Recensioni</button>
            </div>
        </div>

        <!-- Colonna centrale -->
        <div class="col-md-9 p-4" id="content-area">
            <h1 id="contentTitle"></h1>
            <div id="contentBody"></div>
        </div>
    </div>
</div>
