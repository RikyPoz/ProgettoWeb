<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <!-- Icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Aggiungi gli stili CSS qui, nella sezione <head> -->
    <style>
        #categoriesSlider img,
        #ambientSlider img {
            width: 300px; /* Larghezza immagine */
            height: 200px; /* Altezza immagine */
            object-fit: contain; /* Mantiene il rapporto dell'immagine */
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
                <img src="../upload/homePage/presentazione.jpg" alt="" class="img-fluid">
            </div>
        </div>
    

        <!-- Sezione Categorie -->
        <h3 class="mt-5">Categorie</h3>
        <div class="position-relative">
            <!-- Freccia sinistra -->
            <button class="btn btn-outline-secondary btn-sm slider-button" id="categoriesLeft">
                <span class="bi bi-arrow-left"></span>
            </button>
            
            <!-- Contenitore slider -->
            <div class="overflow-hidden">
                <div class="d-flex flex-nowrap gap-3" id="categoriesSlider">
                    <!-- Immagini degli ambienti -->
                    <div class="text-center">
                        <a href="filteredProducts?category=divano" class="btn p-0">
                            <img src="../upload/homePage/cat_divano.png" class="rounded" alt="Pulsante per accedere alla categoria divani">
                            <p class="mt-3 fw-semibold">Divani</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=letto" class="btn p-0">
                            <img src="../upload/homePage/cat_letto.png" class="rounded" alt="Pulsante per accedere alla categoria letto">
                            <p class="mt-3 fw-semibold">Letti</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=armadio" class="btn p-0">
                            <img src="../upload/homePage/cat_armadio.png" class="rounded" alt="Pulsante per accedere alla categoria armadi">
                            <p class="mt-3 fw-semibold">Armadi</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=tavolo" class="btn p-0">
                            <img src="../upload/homePage/cat_tavolo.png" class="rounded" alt="Pulsante per accedere alla categoria tavoli">
                            <p class="mt-3 fw-semibold">Tavoli</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=sedia" class="btn p-0">
                            <img src="../upload/homePage/cat_sedia.png" class="rounded" alt="Pulsante per accedere alla categoria sedie">
                            <p class="mt-3 fw-semibold">Sedie</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=libreria" class="btn p-0">
                            <img src="../upload/homePage/cat_libreria.png" class="rounded" alt="Pulsante per accedere alla categoria librerie e scaffali">
                            <p class="mt-3 fw-semibold">Librerie e scaffali</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?category=cassettiera" class="btn p-0">
                            <img src="../upload/homePage/cat_cassettiera.png" class="rounded" alt="Pulsante per accedere alla categoria cassettiere">
                            <p class="mt-3 fw-semibold">Cassettiere</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Freccia destra -->
            <button class="btn btn-outline-secondary btn-sm slider-button" id="categoriesRight">
                <span class="bi bi-arrow-right"></span>
            </button>
        </div>


        <!-- Sezione Ambienti -->
        <h3 class="mt-5">Ambienti</h3>
        <div class="position-relative">
            <!-- Freccia sinistra -->
            <button class="btn btn-outline-secondary btn-sm slider-button" id="ambientLeft">
                <span class="bi bi-arrow-left"></span>
            </button>
            
            <!-- Contenitore slider -->
            <div class="overflow-hidden">
                <div class="d-flex flex-nowrap gap-3" id="ambientSlider">
                    <!-- Immagini degli ambienti -->
                    <div class="text-center">
                        <a href="filteredProducts?ambient=soggiorno" class="btn p-0">
                            <img src="../upload/homePage/amb_soggiorno.jpg" class="rounded" alt="Pulsante per accedere all'ambiente soggiorno">
                            <p class="mt-3 fw-semibold">Soggiorno</p>
                        </a>
                    </div>                    
                    <div class="text-center">
                        <a href="filteredProducts?ambient=cameradaletto" class="btn p-0">
                            <img src="../upload/homePage/amb_cameradaletto.jpg" class="rounded" alt="Pulsante per accedere all'ambiente camera da letto">
                            <p class="mt-3 fw-semibold">Camera da letto</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?cambient=saladapranzo" class="btn p-0">
                            <img src="../upload/homePage/amb_saladapranzo.jpg" class="rounded" alt="Pulsante per accedere all'ambiente sala da pranzo">
                            <p class="mt-3 fw-semibold">Sala da pranzo</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?ambient=cucina" class="btn p-0">
                            <img src="../upload/homePage/amb_cucina.jpg" class="rounded" alt="Pulsante per accedere all'ambiente cucina">
                            <p class="mt-3 fw-semibold">Cucina</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?ambient=bagno" class="btn p-0">
                            <img src="../upload/homePage/amb_bagno.jpg" class="rounded" alt="Pulsante per accedere all'ambiente bagno">
                            <p class="mt-3 fw-semibold">Bagno</p>
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="filteredProducts?ambient=studio" class="btn p-0">
                            <img src="../upload/homePage/amb_studio.jpg" class="rounded" alt="Pulsante per accedere all'ambiente studio">
                            <p class="mt-3 fw-semibold">Studio</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Freccia destra -->
            <button class="btn btn-outline-secondary btn-sm slider-button" id="ambientRight">
                <span class="bi bi-arrow-right"></span>
            </button>
        </div>
    </div>

      <script>
        document.addEventListener("DOMContentLoaded", function () {
        function enableHorizontalScroll(sliderId, leftButtonId, rightButtonId) {
            const slider = document.getElementById(sliderId);
            const leftButton = document.getElementById(leftButtonId);
            const rightButton = document.getElementById(rightButtonId);
            let currentScrollPosition = 0;
            const scrollAmount = 300; // Di quanto si scorrere ogni volta
            
            // Aggiornare lo stato dei pulsanti
            function updateButtonState() {
                // Calcolare la larghezza massima di scorrimento
                const maxScroll = slider.scrollWidth - slider.offsetWidth;

                // Disabilitare il pulsante sinistro se non si può più scorrere a sinistra
                leftButton.disabled = currentScrollPosition <= 0;

                // Disabilitare il pulsante destro se non si può più scorrere a destra
                rightButton.disabled = currentScrollPosition >= maxScroll;
            }

            // Inizializzare lo stato dei pulsanti
            updateButtonState();

            // Scorrimento a destra
            rightButton.addEventListener("click", function () {
                const maxScroll = slider.scrollWidth - slider.offsetWidth;
                if (currentScrollPosition < maxScroll) {
                    currentScrollPosition += scrollAmount;
                    if (currentScrollPosition > maxScroll) {
                        currentScrollPosition = maxScroll;
                    }
                    slider.style.transform = `translateX(-${currentScrollPosition}px)`;
                }
                updateButtonState();
            });

            // Scorrimento a sinistra
            leftButton.addEventListener("click", function () {
                if (currentScrollPosition > 0) {
                    currentScrollPosition -= scrollAmount;
                    if (currentScrollPosition < 0) {
                        currentScrollPosition = 0;
                    }
                    slider.style.transform = `translateX(-${currentScrollPosition}px)`;
                }
                updateButtonState();
            });
        }

        // Abilitare lo scorrimento per Categorie
        enableHorizontalScroll("categoriesSlider", "categoriesLeft", "categoriesRight");
        // Abilitare lo scorrimento per Ambienti
        enableHorizontalScroll("ambientSlider", "ambientLeft", "ambientRight");
    });
    </script>

</body>
</html>


