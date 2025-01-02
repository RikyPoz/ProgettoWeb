<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
  
    <!-- Icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow">
        <div class="container-fluid d-flex justify-content-between">
        <div>
            <!-- Hamburger Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand Logo -->
            <a class="navbar-brand" href="#"><img src="logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">Tuo Sito</a>
        </div>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Search Bar -->
            <form class="d-flex mx-auto" role="search" style="width: 50%;">
            <input class="form-control me-2" type="search" placeholder="Cerca..." aria-label="Search">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i>
            </button>
            </form>

            <!-- Icons Section -->
            <ul class="navbar-nav ms-auto">
            <li class="nav-item d-flex flex-column align-items-center">
                <a href="../profile.php" class="btn btn-light text-center">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>  
                </a>
                <span>Profilo</span>
            </li>
            <li class="nav-item d-flex flex-column align-items-center mx-3">
                <button class="btn btn-light">
                <i class="bi bi-heart" style="font-size: 1.5rem;"></i>
                </button>
                <span>Preferiti</span>
            </li>
            <li class="nav-item d-flex flex-column align-items-center">
                <button class="btn btn-light">
                <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
                </button>
                <span>Carrello</span>
            </li>
            </ul>
        </div>
        </div>
    </nav>
    <!-- Main -->
    <main>
    <?php
    if(isset($templateParams["nome"])){
        require($templateParams["nome"]);
    }
    ?>
    </main>

    <!-- Footer -->
    <footer style="background-color: #000000; color: #fff; padding: 40px 20px;">
    <div style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
      <!-- Informazioni aziendali -->
      <div style="flex: 1 1 300px; margin-bottom: 20px;">
        <h3 style="color: #fff; margin-bottom: 10px;">[Nome Azienda]</h3>
        <p>P.IVA: 1234567890</p>
        <p>Via Roma, 10 - 00100 Roma, Italia</p>
        <p>Email: <a href="mailto:supporto@tuoecommerce.it" style="color: #4CAF50;">supporto@tuoecommerce.it</a></p>
        <p>Tel: +39 123 456 789</p>
      </div>
  
      <!-- Navigazione utile -->
      <div style="flex: 1 1 200px; margin-bottom: 20px;">
        <h4 style="color: #fff; margin-bottom: 10px;">Navigazione</h4>
        <ul style="list-style: none; padding: 0;">
          <li><a href="/" style="color: #4CAF50; text-decoration: none;">Home</a></li>
          <li><a href="/prodotti" style="color: #4CAF50; text-decoration: none;">Prodotti</a></li>
          <li><a href="/offerte" style="color: #4CAF50; text-decoration: none;">Offerte</a></li>
          <li><a href="/faq" style="color: #4CAF50; text-decoration: none;">FAQ</a></li>
        </ul>
      </div>
  
      <!-- Privacy e termini legali -->
      <div style="flex: 1 1 200px; margin-bottom: 20px;">
        <h4 style="color: #fff; margin-bottom: 10px;">Informazioni Legali</h4>
        <ul style="list-style: none; padding: 0;">
          <li><a href="/termini-condizioni" style="color: #4CAF50; text-decoration: none;">Termini e Condizioni</a></li>
          <li><a href="/privacy" style="color: #4CAF50; text-decoration: none;">Privacy Policy</a></li>
          <li><a href="/cookie-policy" style="color: #4CAF50; text-decoration: none;">Cookie Policy</a></li>
        </ul>
      </div>
  
      <!-- Social media e metodi di pagamento -->
      <div style="flex: 1 1 300px; margin-bottom: 20px; text-align: center;">
        <h4 style="color: #fff; margin-bottom: 10px;">Seguici su</h4>
        <a href="#" style="margin-right: 10px;"><img src="icon-facebook.png" alt="Facebook" width="30"></a>
        <a href="#" style="margin-right: 10px;"><img src="icon-instagram.png" alt="Instagram" width="30"></a>
        <a href="#"><img src="icon-twitter.png" alt="Twitter" width="30"></a>
        <h4 style="color: #fff; margin-top: 20px;">Pagamenti Accettati</h4>
        <img src="icon-visa.png" alt="Visa" width="50" style="margin-right: 10px;">
        <img src="icon-mastercard.png" alt="Mastercard" width="50" style="margin-right: 10px;">
        <img src="icon-paypal.png" alt="PayPal" width="50">
      </div>
    </div>
  
    <!-- Copyright -->
    <div style="text-align: center; margin-top: 20px; border-top: 1px solid #555; padding-top: 10px; font-size: 14px;">
      © 2024 [Nome Azienda]. Tutti i diritti riservati.
    </div>
  </footer>

  <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
</body>
</html>