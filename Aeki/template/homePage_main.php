<link rel="stylesheet" href="./css/homePage_style.css">

<div class="container my-4">
    <div class="row mb-4">
        <div class="col-md-6 d-flex">
            <div class="p-4 bg-light border w-100">
                <h2 class="fw-bold" style="color: #000070">Benvenuto su Aeki!</h2>
                <h3 style="color: #000070">Arredamento per la tua casa</h3>
                <p style="text-align: justify;">
                Scopri il design e la funzionalità che trasformano ogni spazio in un luogo unico. 
                Aeki è il tuo partner ideale per arredare con gusto e praticità, grazie a una vasta gamma di mobili e complementi d'arredo progettati per rispondere a ogni tua esigenza. 
                Dalla zona giorno alla camera da letto, passando per cucina e bagno, ti offriamo soluzioni su misura per ogni necessità. 
                Lasciati ispirare dalla nostra collezione e vivi l'emozione di trasformare i tuoi spazi in luoghi che raccontano la tua storia. 
                </p>
                <p style="text-align: center;">
                    Con Aeki arredare casa diventa un’esperienza unica e creativa!
                </p>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="upload/homePage/presentazione.png" alt="" class="img-fluid">
        </div>
    </div>

    <!-- Sezione Categorie -->
    <h3 class="mt-5" style="color: #000070">Categorie</h3>
    <div class="slider-container position-relative">
        <?php if (!empty($templateParams["categorie"])): ?>    

            <button class="btn btn-outline-secondary btn-sm slider-button slider-button-left">
                <span class="bi bi-arrow-left"></span>
            </button>

            <div class="overflow-hidden slider-wrapper categories-slider">
                <div class="d-flex flex-nowrap gap-3 slider-track">
                    <?php foreach ($templateParams["categorie"] as $categoria): ?>
                        <div class="text-center">
                            <a href="filteredProducts.php?categories=<?php echo urlencode($categoria['NomeCategoria']); ?>" class="btn p-0">
                                <img src="<?php echo $categoria['PercorsoImmagine']; ?>" class="rounded" alt="Categoria <?php echo $categoria['NomeCategoria']; ?>">
                                <p class="mt-3 fw-semibold"><?php echo $categoria['NomeCategoria']; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="btn btn-outline-secondary btn-sm slider-button slider-button-right">
                <span class="bi bi-arrow-right"></span>
            </button>
        <?php else: ?>
            <p>Nessuna categoria disponibile.</p>
        <?php endif; ?>
    </div>

    <!-- Sezione Ambienti -->
    <h3 class="mt-5" style="color: #000070">Ambienti</h3>
    <div class="slider-container position-relative">
        <?php if (!empty($templateParams["ambienti"])): ?>

            <button class="btn btn-outline-secondary btn-sm slider-button slider-button-left">
                <span class="bi bi-arrow-left"></span>
            </button>

            <div class="overflow-hidden slider-wrapper ambient-slider"> 
                <div class="d-flex flex-nowrap gap-3 slider-track">
                    <?php foreach ($templateParams["ambienti"] as $ambiente): ?>
                        <div class="text-center">
                            <a href="filteredProducts.php?ambient=<?php echo urlencode($ambiente['NomeAmbiente']); ?>" class="btn p-0">
                                <img src="<?php echo $ambiente['PercorsoImmagine']; ?>" class="rounded" alt="Ambiente <?php echo $ambiente['NomeAmbiente']; ?>">
                                <p class="mt-3 fw-semibold"><?php echo $ambiente['NomeAmbiente']; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="btn btn-outline-secondary btn-sm slider-button slider-button-right">
                <span class="bi bi-arrow-right"></span>
            </button>
        <?php else: ?>
            <p>Nessun ambiente disponibile.</p>
        <?php endif; ?>
    </div>
</div>
