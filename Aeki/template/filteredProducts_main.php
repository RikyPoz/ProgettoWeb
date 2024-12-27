<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aeki | Lista Prodotti</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .range-bar {
      height: 10px;
      position: relative;
      background-color: #e9ecef;
      border-radius: 5px;
      overflow: hidden;
    }

    .range-bar .range-fill {
      height: 100%;
      background-color: #0d6efd;
      position: absolute;
    }

    .histogram-bar {
      height: 5px;
      background-color: #6c757d;
      margin-top: 4px;
    }
  </style>
</head>

<body>
  <main class="container my-5">
    <!-- Filtro -->
    <div class="row mb-4 justify-content-center">
      <div class="col-12 col-xl-10 p-4 bg-white rounded-3 shadow-sm">
        <div class="row g-4">
          <!-- Colore -->
          <div class="col-12 col-md-4">
            <h5 class="fw-semibold mb-3">Colore</h5>
            <div class="row row-cols-2">
              <?php
              $colors = ["rosso", "bianco", "marrone", "nero", "blu", "grigio", "verde"];
              foreach ($colors as $color) {
                echo "<div class='col'>
                        <div class='form-check'>
                          <input class='form-check-input' type='checkbox' id='$color'>
                          <label class='form-check-label' for='$color'>" . ucfirst($color) . "</label>
                        </div>
                      </div>";
              }
              ?>
            </div>
          </div>

          <!-- Prezzo -->
          <div class="col-12 col-md-4">
            <h5 class="fw-semibold mb-3">Prezzo</h5>
            <div class="mb-3">
              <!-- Doppio cursore -->
              <input type="range" class="form-range" id="minPrice" min="0" max="1000" step="10">
              <input type="range" class="form-range" id="maxPrice" min="0" max="1000" step="10">
              <div class="d-flex justify-content-between small">
                <span>€0</span>
                <span>€1000</span>
              </div>
            </div>
            <div class="range-bar mb-3">
              <div id="rangeFill" class="range-fill" style="left: 10%; width: 50%;"></div>
            </div>
            <div>
              <!-- Istogramma -->
              <div class="histogram-bar" style="width: 20%;"></div>
              <div class="histogram-bar" style="width: 40%;"></div>
              <div class="histogram-bar" style="width: 30%;"></div>
              <div class="histogram-bar" style="width: 10%;"></div>
            </div>
          </div>

          <!-- Recensioni -->
          <div class="col-12 col-md-4">
            <h5 class="fw-semibold mb-3">Recensioni</h5>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="fiveStars">
              <label class="form-check-label" for="fiveStars">5</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="fourStars">
              <label class="form-check-label" for="fourStars">4+</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="threeStars">
              <label class="form-check-label" for="threeStars">3+</label>
            </div>
          </div>
        </div>
        <div class="text-end mt-3">
          <button class="btn btn-success"><i class="bi bi-filter"></i> Filtra</button>
        </div>
      </div>
    </div>

    <!-- Lista Prodotti -->
    <div class="row g-4">
      <?php
      // Supponiamo che getProducts() restituisca un array di prodotti
      $products = [
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania Minimal",
            "price" => 199.99,
            "rating" => 4,
            "reviews" => 38,
        ],
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania Classica",
            "price" => 149.99,
            "rating" => 5,
            "reviews" => 12,
        ],
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania Moderna",
            "price" => 249.99,
            "rating" => 3,
            "reviews" => 54,
        ],
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania Compatta",
            "price" => 99.99,
            "rating" => 4,
            "reviews" => 22,
        ],
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania Elegante",
            "price" => 299.99,
            "rating" => 5,
            "reviews" => 44,
        ],
        [
            "image" => "https://via.placeholder.com/150",
            "name" => "Scrivania per Studio",
            "price" => 179.99,
            "rating" => 3,
            "reviews" => 19,
        ],
    ];
      foreach ($products as $product) {
        echo "<div class='col-6 col-md-4 col-lg-3'>
                <div class='card text-center shadow-sm border-0'>
                  <img src='{$product['image']}' class='card-img-top rounded-3' alt='Prodotto'>
                  <div class='card-body'>
                    <h6 class='card-title text-dark fw-semibold'>{$product['name']}</h6>
                    <p class='text-success fw-bold'>€" . number_format($product['price'], 2) . "</p>
                    <div class='d-flex justify-content-center align-items-center'>
                      <span class='text-warning fs-4'>" . str_repeat('&#9733;', $product['rating']) . str_repeat('&#9734;', 5 - $product['rating']) . "</span>
                      <span class='text-muted ms-1 small'>({$product['reviews']})</span>
                    </div>
                  </div>
                </div>
              </div>";
      }
      ?>
    </div>
  </main>

  <script>
    // JavaScript per aggiornare la barra riempita tra i due cursori
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const rangeFill = document.getElementById('rangeFill');

    function updateRange() {
      const min = parseInt(minPrice.value);
      const max = parseInt(maxPrice.value);
      const rangeMin = parseInt(minPrice.min);
      const rangeMax = parseInt(maxPrice.max);
      const left = ((min - rangeMin) / (rangeMax - rangeMin)) * 100;
      const width = ((max - min) / (rangeMax - rangeMin)) * 100;
      rangeFill.style.left = left + '%';
      rangeFill.style.width = width + '%';
    }

    minPrice.addEventListener('input', updateRange);
    maxPrice.addEventListener('input', updateRange);
    updateRange();
  </script>
</body>

</html>
