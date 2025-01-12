<?php $venditore = $templateParams["venditore"];?>
<div class="container-fluid">
    <div class="row">
        <!-- Colonna laterale -->
        <div class="col-md-3 p-4 border-end">
            <h2 style="color:#000070">Profilo Venditore</h2>
            <div class="my-4">
                <div class = "d-flex justify-content-center">
                    <img src="<?php echo $venditore["Icona"]?>" class="img-fluid rounded-circle" alt="Immagine Profilo">
                </div>
                <div>
                    <h5 class="mt-2"><?php echo $venditore["Nome"] ; echo " "; echo $venditore["Cognome"]?></h5>
                    <p><strong>Username:</strong> <?php echo $venditore["Username"]?></p>
                    <p><strong>Email:</strong> <?php echo $venditore["Email"]?></p>
                    <p><strong>Contatto:</strong> <?php echo $venditore["Telefono"]?></p>
                    <p><strong>P_IVA:</strong> <?php echo $venditore["PartitaIVA"]?></p>
                </div>
            </div>

            <div class="btn-group-vertical w-100">
                <button class="btn mb-1" id="viewProductsBtn" style="background-color: #000060; color: #FFFFFF">Visualizza i Prodotti</button>
                <button class="btn mb-1" id="viewOrdersBtn" style="background-color: #000060; color: #FFFFFF">Visualizza Ordini</button>
                <button class="btn mb-1" id="viewStatsBtn" style="background-color: #000060; color: #FFFFFF">Visualizza Statistiche</button>
                <button class="btn " id="viewReviewsBtn" style="background-color: #000060; color: #FFFFFF">Visualizza Recensioni</button>
            </div>
        </div>

        <!-- Colonna centrale -->
        <div class="col-md-9 p-4" id="content-area">
            <h1 id="contentTitle" data-type=" " style="color:#000070"></h1>
            <div id="contentBody"></div>
        </div>
    </div>
</div>
