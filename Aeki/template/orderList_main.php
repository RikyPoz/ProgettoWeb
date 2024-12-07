<div>
    <h2>I miei ordini</h2>
    <?php foreach($templateParams["ordini"] as $ordine): ?>
        <div col-md-10 > 
            <p> <?php echo $ordine["idOrdine"] ?> </p>
            <p> <?php echo $ordine["dataOrdine"] ?> </p>
            <p> <?php echo $ordine["costoTotale"] ?> </p>
        </div>
    <?php endforeach; ?>
</div>
