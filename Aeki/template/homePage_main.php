<!DOCTYPE html>
<html lang="it">
<head>
    <!-- DA ELIMINARE QUANDO SI USA BASE.PHP -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <!-- Icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Stili CSS -->
    <style>
        #categoriesSlider img {
            width: 300px; /* Imposta una larghezza fissa per le immagini nella sezione categorie */
            height: 200px; /* Imposta un'altezza fissa per le immagini nella sezione categorie */
            object-fit: contain; /* Mostra l'intera immagine all'interno delle dimensioni */
        }

        #ambientSlider img {
            width: 300px; /* Imposta una larghezza fissa per le immagini nella sezione ambienti */
            height: 200px; /* Imposta un'altezza fissa per le immagini nella sezione ambienti */
            object-fit: cover; /* Mantiene le proporzioni dell'immagine riempiendo interamente il contenitore */
        }

        #categoriesSlider,
        #ambientSlider {
            transition: transform 0.4s ease-in-out;
        }

        /* Regola i pulsanti di scorrimento */
        .slider-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        #categoriesLeft {
            left: -40px; /* Sposta il pulsante sinistro all'esterno */
        }

        #categoriesRight {
            right: -40px; /* Sposta il pulsante destro all'esterno */
        }

        #ambientLeft {
            left: -40px; /* Sposta il pulsante sinistro all'esterno */
        }

        #ambientRight {
            right: -40px; /* Sposta il pulsante destro all'esterno */
        }
    </style>
</head>

<body>
    <!-- Sezione principale -->
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6 d-flex">
                <div class="p-4 bg-light border w-100">
                    <h2><strong>Benvenuto su Aeki!</strong></h2>
                    <h3><em>Arredamento per la tua casa</em></h3>
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
                <img src="../upload/homePage/presentazione.png" alt="" class="img-fluid">
            </div>
        </div>

        <!-- Sezione Categorie -->
        <h3 class="mt-5">Categorie </h3>
        <div class="position-relative">
            <?php if (!empty($templateParams["categorie"])): ?>    
                
                <!-- Freccia sinistra -->
                <button class="btn btn-outline-secondary btn-sm slider-button" id="categoriesLeft">
                    <span class="bi bi-arrow-left"></span>
                </button>
                
                <!-- Contenitore slider -->
                <div class="overflow-hidden">
                    <div class="d-flex flex-nowrap gap-3" id="categoriesSlider">
                        <?php foreach ($templateParams["categoria"] as $categoria): ?>
                            <div class="text-center">
                                <?php $immagineCategoria = $categoria['PercorsoImmagine'];?>
                                <a href="filteredProducts?category=<?php echo $categoria['NomeCategoria']; ?>" class="btn p-0">
                                    <img src="<?php echo $immagineCategoria; ?>" alt="Categoria <?php echo $categoria['NomeCategoria']; ?>">
                                    <p class="mt-3 fw-semibold"><?php echo $categoria['NomeCategoria']; ?></p>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Freccia destra -->
                <button class="btn btn-outline-secondary btn-sm slider-button" id="categoriesRight">
                    <span class="bi bi-arrow-right"></span>
                </button>
            <?php else: ?>
                <p>Nessuna categoria disponibile.</p>
            <?php endif; ?>
        </div>

        <!-- Sezione Ambienti -->
        <h3 class="mt-5">Ambienti</h3>
        <div class="position-relative">
             <?php if (!empty($templateParams["ambienti"])): ?>
                <!-- Freccia sinistra -->
                <button class="btn btn-outline-secondary btn-sm slider-button" id="ambientLeft">
                    <span class="bi bi-arrow-left"></span>
                </button>
                
                <!-- Contenitore slider -->
                <div class="overflow-hidden">
                    <div class="d-flex flex-nowrap gap-3" id="ambientSlider">
                        <?php foreach ($templateParams["ambienti"] as $ambiente): ?>
                            <div class="text-center">
                                <a href="filteredProducts?ambient=<?php echo$ambiente['NomeAmbiente']; ?>" class="btn p-0">
                                    <img src="<?php echo $ambiente['PercorsoImmagine']; ?>" class="rounded" alt="Ambiente <?php echo htmlspecialchars($ambiente['NomeAmbiente']); ?>">
                                    <p class="mt-3 fw-semibold"><?php echo $ambiente['NomeAmbiente']; ?></p>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Freccia destra -->
                <button class="btn btn-outline-secondary btn-sm slider-button" id="ambientRight">
                    <span class="bi bi-arrow-right"></span>
                </button>
            <?php else: ?>
                <p>Nessun ambiente disponibile.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Link al file JavaScript -->
    <script src="path/to/your/script.js"></script>

</body>
</html>
