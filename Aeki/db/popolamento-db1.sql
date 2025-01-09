-- Populating Utente table
INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono, Icona) VALUES
('anonimo', 'Anonimo', 'Anonimo', 'anonimo@example.com', 'password', 'cliente', NULL, '0000000000', NULL),
('Mario', 'Rossi', 'user1', 'mario.rossi@example.com', 'password123', 'Cliente', NULL, '1234567890', NULL),
('Luigi', 'Verdi', 'user2', 'luigi.verdi@example.com', 'password123', 'Cliente', NULL, '0987654321', NULL),
('Pietro', 'Pasini', 'Paso', 'pietro.pasini@example.com', 'password123', 'Venditore', '12345678901', '1122334455', 'upload/seller/profilo1.png'),
('Gaia', 'Pojaghi', 'Gaia', 'gaia.pojaghi@example.com', 'password123', 'Venditore', '12345678901', '1122334455', 'upload/seller/profilo2.png'),
('Riccardo', 'Polazzi', 'Poz', 'riccardo.polazzi@example.com', 'password123', 'Venditore', '12345678901', '1122334455', 'upload/seller/profilo1.png');

-- Populating Ambiente table
INSERT INTO Ambiente (NomeAmbiente, PercorsoImmagine) VALUES
('Soggiorno', 'upload/homePage/soggiorno.png'),
('Cucina', 'upload/homePage/cucina.png'),
('Bagno', 'upload/homePage/bagno.png'),
('Camera da letto', 'upload/homePage/cameradaletto.png'),
('Sala da pranzo', 'upload/homePage/saladapranzo.png'),
('Studio', 'upload/homePage/studio.png');

-- Populating Categoria table
INSERT INTO Categoria (NomeCategoria, PercorsoImmagine) VALUES
('Armadi', 'upload/homePage/armadio.png'),
('Letti', 'upload/homePage/letto.png'),
('Tavoli', 'upload/homePage/tavolo.png'),
('Sedie', 'upload/homePage/sedia.png'),
('Cassettiere', 'upload/homePage/cassettiera.png'),
('Divani', 'upload/homePage/divano.png'),
('Librerie e scaffali', 'upload/homePage/libreria.png');

-- Populating Colore table
INSERT INTO Colore (NomeColore) VALUES
('Marrone'),
('Grigio'),
('Bianco'),
('Beige'),
('Argento'),
('Nero'),
('Rosso'),
('Blu'),
('Trasparente'),
('Verde');

-- Populating Materiale table 
INSERT INTO Materiale (NomeMateriale) VALUES
('Legno massello'),
('Pelle'),
('Legno'),
('Plastica'),
('Vetro e acciaio'),
('Tessuto e acciaio'),
('Legno e vetro'),
('Vetro'),
('Alluminio'),
('Tessuto'),
('Acciaio'),
('Legno e metallo'),
('Metallo'),
('Tessuto e metallo'),
('Plastica e metallo'),
('Bamboo'),
('Metallo e plastica'),
('Tessuto e legno'),
('Acciaio e tessuto'),
('Pelle e legno');

-- PRODOTTI
INSERT INTO Prodotto (Nome, Prezzo, Descrizione, NomeMateriale, Peso, NomeColore, Altezza, Larghezza, Profondita, NomeAmbiente, NomeCategoria, Username) VALUES
('Armadio moderno', 350.0, 'Un armadio elegante per il soggiorno.', 'Legno massello', 50.0, 'Marrone', 200.0, 120.0, 60.0, 'Soggiorno', 'Armadi', 'Paso'),
('Divano angolare', 800.0, 'Divano spazioso e confortevole.', 'Pelle', 100.0, 'Grigio', 90.0, 250.0, 90.0, 'Soggiorno', 'Divani', 'Paso'),
('Libreria modulare', 450.0, 'Libreria con design personalizzabile.', 'Legno', 70.0, 'Bianco', 180.0, 100.0, 35.0, 'Soggiorno', 'Librerie e scaffali', 'Paso'),
('Sedia design', 120.0, 'Sedia di design ergonomica.', 'Plastica', 7.0, 'Nero', 85.0, 50.0, 45.0, 'Soggiorno', 'Sedie', 'Paso'),
('Tavolino da caffè', 150.0, 'Perfetto per il soggiorno moderno.', 'Vetro e acciaio', 15.0, 'Trasparente', 40.0, 100.0, 60.0, 'Soggiorno', 'Tavoli', 'Paso'),
('Tavolo da pranzo', 500.0, 'Tavolo elegante per la cucina.', 'Legno', 75.0, 'Marrone', 75.0, 180.0, 90.0, 'Cucina', 'Tavoli', 'Paso'),
('Sedia imbottita', 90.0, 'Sedia comoda per la cucina.', 'Tessuto e acciaio', 8.0, 'Beige', 90.0, 45.0, 45.0, 'Cucina', 'Sedie', 'Paso'),
('Cassettiera compatta', 200.0, 'Cassettiera salvaspazio per la cucina.', 'Legno', 25.0, 'Bianco', 100.0, 50.0, 40.0, 'Cucina', 'Cassettiere', 'Paso'),
('Armadio pensile', 300.0, 'Armadio per riporre utensili.', 'Legno', 30.0, 'Grigio', 90.0, 100.0, 40.0, 'Cucina', 'Armadi', 'Paso'),
('Credenza', 400.0, 'Elegante credenza per la cucina.', 'Legno', 80.0, 'Marrone', 150.0, 120.0, 50.0, 'Cucina', 'Librerie e scaffali', 'Paso'),
('Mobile bagno sospeso', 350.0, 'Mobile bagno moderno sospeso.', 'Legno e vetro', 30.0, 'Bianco', 60.0, 100.0, 45.0, 'Bagno', 'Cassettiere', 'Paso'),
('Specchio LED', 120.0, 'Specchio bagno con illuminazione LED.', 'Vetro', 8.0, 'Argento', 80.0, 60.0, 5.0, 'Bagno', 'Librerie e scaffali', 'Paso'),
('Sgabello doccia', 50.0, 'Sgabello resistente per doccia.', 'Alluminio', 5.0, 'Grigio', 45.0, 35.0, 35.0, 'Bagno', 'Sedie', 'Paso'),
('Armadio per biancheria', 200.0, 'Armadio per asciugamani e biancheria.', 'Legno', 40.0, 'Bianco', 180.0, 70.0, 45.0, 'Bagno', 'Armadi', 'Paso'),
('Tavolino multifunzione', 80.0, 'Tavolino da bagno per accessori.', 'Legno', 10.0, 'Marrone', 60.0, 50.0, 40.0, 'Bagno', 'Tavoli', 'Paso'),
('Letto matrimoniale', 600.0, 'Letto matrimoniale con contenitore.', 'Legno', 90.0, 'Marrone', 40.0, 200.0, 160.0, 'Camera da letto', 'Letti', 'Paso'),
('Comodino moderno', 150.0, 'Comodino con due cassetti.', 'Legno', 20.0, 'Bianco', 50.0, 60.0, 40.0, 'Camera da letto', 'Cassettiere', 'Paso'),
('Armadio scorrevole', 800.0, 'Armadio con ante scorrevoli.', 'Legno e vetro', 100.0, 'Grigio', 220.0, 180.0, 60.0, 'Camera da letto', 'Armadi', 'Paso'),
('Libreria minimal', 300.0, 'Libreria per libri e accessori.', 'Legno', 50.0, 'Beige', 180.0, 90.0, 35.0, 'Camera da letto', 'Librerie e scaffali', 'Paso'),
('Poltrona relax', 250.0, 'Poltrona comoda per lettura.', 'Tessuto', 25.0, 'Blu', 100.0, 80.0, 80.0, 'Camera da letto', 'Sedie', 'Paso'),
('Tavolo ovale', 700.0, 'Tavolo elegante per sala da pranzo.', 'Legno massello', 80.0, 'Marrone', 75.0, 200.0, 100.0, 'Sala da pranzo', 'Tavoli', 'Paso'),
('Sedia elegante', 100.0, 'Sedia comoda ed elegante.', 'Tessuto e acciaio', 10.0, 'Beige', 90.0, 45.0, 45.0, 'Sala da pranzo', 'Sedie', 'Paso'),
('Credenza classica', 600.0, 'Credenza con vetrina.', 'Legno e vetro', 120.0, 'Marrone', 180.0, 160.0, 50.0, 'Sala da pranzo', 'Armadi', 'Gaia'),
('Cassettiera vintage', 300.0, 'Cassettiera dallo stile retrò.', 'Legno', 60.0, 'Bianco', 100.0, 120.0, 45.0, 'Sala da pranzo', 'Cassettiere', 'Gaia'),
('Mensola decorativa', 150.0, 'Mensola per oggetti decorativi.', 'Legno', 15.0, 'Beige', 20.0, 150.0, 30.0, 'Sala da pranzo', 'Librerie e scaffali', 'Gaia'),
('Scrivania angolare', 450.0, 'Scrivania spaziosa con design moderno.', 'Legno e metallo', 50.0, 'Nero', 75.0, 160.0, 90.0, 'Studio', 'Tavoli', 'Gaia'),
('Sedia ergonomica', 250.0, 'Sedia regolabile per comfort e postura.', 'Tessuto e metallo', 15.0, 'Grigio', 120.0, 50.0, 50.0, 'Studio', 'Sedie', 'Gaia'),
('Libreria verticale', 300.0, 'Libreria alta e spaziosa.', 'Legno', 60.0, 'Bianco', 200.0, 80.0, 30.0, 'Studio', 'Librerie e scaffali', 'Gaia'),
('Cassettiera con ruote', 180.0, 'Cassettiera pratica e mobile.', 'Legno e metallo', 20.0, 'Grigio', 60.0, 50.0, 40.0, 'Studio', 'Cassettiere', 'Gaia'),
('Armadio archivio', 400.0, 'Armadio per documenti e materiali.', 'Metallo', 70.0, 'Argento', 180.0, 90.0, 45.0, 'Studio', 'Armadi', 'Gaia'),
('Armadio grande soggiorno', 600.0, 'Armadio spazioso con ripiani regolabili.', 'Legno', 90.0, 'Marrone', 200.0, 120.0, 50.0, 'Soggiorno', 'Armadi', 'Gaia'),
('Armadio scorrevole bagno', 450.0, 'Armadio compatto con ante scorrevoli.', 'Plastica', 60.0, 'Bianco', 180.0, 90.0, 40.0, 'Bagno', 'Armadi', 'Gaia'),
('Armadio cucina alto', 500.0, 'Armadio per utensili da cucina.', 'Acciaio', 75.0, 'Grigio', 210.0, 80.0, 45.0, 'Cucina', 'Armadi', 'Gaia'),
('Guardaroba camera da letto', 700.0, 'Guardaroba elegante e spazioso.', 'Legno massello', 100.0, 'Marrone', 220.0, 160.0, 60.0, 'Camera da letto', 'Armadi', 'Gaia'),
('Archivio ufficio studio', 400.0, 'Armadio archivio per documenti.', 'Metallo', 80.0, 'Nero', 190.0, 100.0, 45.0, 'Studio', 'Armadi', 'Gaia'),
('Letto matrimoniale moderno', 800.0, 'Letto elegante con testiera imbottita.', 'Tessuto e legno', 120.0, 'Bianco', 40.0, 200.0, 160.0, 'Camera da letto', 'Letti', 'Gaia'),
('Letto singolo classico', 400.0, 'Letto singolo in legno massello.', 'Legno massello', 80.0, 'Marrone', 35.0, 190.0, 90.0, 'Camera da letto', 'Letti', 'Gaia'),
('Divano letto soggiorno', 650.0, 'Divano trasformabile in letto.', 'Tessuto e acciaio', 100.0, 'Grigio', 45.0, 200.0, 120.0, 'Soggiorno', 'Letti', 'Gaia'),
('Letto a castello', 750.0, 'Letto a castello per due persone.', 'Metallo', 95.0, 'Nero', 150.0, 200.0, 90.0, 'Camera da letto', 'Letti', 'Gaia'),
('Letto pieghevole', 300.0, 'Letto pratico e pieghevole.', 'Acciaio e tessuto', 50.0, 'Blu', 50.0, 190.0, 80.0, 'Studio', 'Letti', 'Gaia'),
('Tavolo pranzo ovale', 900.0, 'Tavolo elegante per la sala da pranzo.', 'Legno massello', 120.0, 'Marrone', 75.0, 220.0, 110.0, 'Sala da pranzo', 'Tavoli', 'Gaia'),
('Scrivania ufficio', 400.0, 'Scrivania funzionale con ripiani.', 'Legno e metallo', 70.0, 'Bianco', 75.0, 150.0, 80.0, 'Studio', 'Tavoli', 'Gaia'),
('Tavolino soggiorno', 200.0, 'Tavolino basso per il soggiorno.', 'Legno', 30.0, 'Marrone', 45.0, 120.0, 60.0, 'Soggiorno', 'Tavoli', 'Poz'),
('Tavolo cucina quadrato', 300.0, 'Tavolo quadrato per la cucina.', 'Plastica', 40.0, 'Bianco', 75.0, 100.0, 100.0, 'Cucina', 'Tavoli', 'Poz'),
('Tavolo pieghevole', 150.0, 'Tavolo pieghevole per spazi ridotti.', 'Metallo e plastica', 25.0, 'Grigio', 75.0, 120.0, 60.0, 'Bagno', 'Tavoli', 'Poz'),
('Sedia imbottita soggiorno', 150.0, 'Sedia confortevole con imbottitura.', 'Tessuto e legno', 15.0, 'Grigio', 90.0, 50.0, 50.0, 'Soggiorno', 'Sedie', 'Poz'),
('Sgabello cucina alto', 120.0, 'Sgabello moderno e robusto.', 'Metallo', 10.0, 'Bianco', 100.0, 40.0, 40.0, 'Cucina', 'Sedie', 'Poz'),
('Sedia da pranzo classica', 180.0, 'Sedia elegante per la sala da pranzo.', 'Legno massello', 20.0, 'Marrone', 95.0, 45.0, 45.0, 'Sala da pranzo', 'Sedie', 'Poz'),
('Sedia ergonomica studio', 250.0, 'Sedia regolabile e comoda.', 'Plastica e metallo', 18.0, 'Nero', 120.0, 50.0, 50.0, 'Studio', 'Sedie', 'Poz'),
('Panca bagno', 100.0, 'Sedia/panca multifunzione.', 'Bamboo', 8.0, 'Bianco', 50.0, 90.0, 35.0, 'Bagno', 'Sedie', 'Poz'),
('Cassettiera soggiorno moderna', 400.0, 'Cassettiera spaziosa con design minimalista.', 'Legno', 50.0, 'Marrone', 100.0, 80.0, 40.0, 'Soggiorno', 'Cassettiere', 'Poz'),
('Cassettiera bagno compatta', 200.0, 'Cassettiera ideale per spazi piccoli.', 'Plastica', 15.0, 'Bianco', 70.0, 50.0, 35.0, 'Bagno', 'Cassettiere', 'Poz'),
('Cassettiera camera da letto', 500.0, 'Cassettiera elegante e robusta.', 'Legno massello', 80.0, 'Marrone', 120.0, 100.0, 45.0, 'Camera da letto', 'Cassettiere', 'Poz'),
('Cassettiera cucina multiuso', 300.0, 'Cassettiera pratica per utensili.', 'Metallo', 40.0, 'Grigio', 90.0, 60.0, 40.0, 'Cucina', 'Cassettiere', 'Poz'),
('Cassettiera ufficio studio', 350.0, 'Cassettiera con ruote per ufficio.', 'Legno e metallo', 30.0, 'Nero', 75.0, 50.0, 40.0, 'Studio', 'Cassettiere', 'Poz'),
('Divano letto soggiorno', 800.0, 'Divano trasformabile in letto.', 'Tessuto e legno', 100.0, 'Grigio', 85.0, 200.0, 90.0, 'Soggiorno', 'Divani', 'Poz'),
('Divano angolare soggiorno', 1200.0, 'Divano spazioso e confortevole.', 'Tessuto e metallo', 150.0, 'Blu', 90.0, 300.0, 150.0, 'Soggiorno', 'Divani', 'Poz'),
('Poltrona relax soggiorno', 600.0, 'Poltrona comoda per il relax.', 'Pelle e legno', 80.0, 'Marrone', 100.0, 90.0, 90.0, 'Soggiorno', 'Divani', 'Poz'),
('Divano letto studio', 750.0, 'Divano pratico per spazi ridotti.', 'Tessuto', 90.0, 'Nero', 85.0, 190.0, 80.0, 'Studio', 'Divani', 'Poz'),
('Divano classico camera da letto', 700.0, 'Divano elegante per la camera.', 'Tessuto e legno', 110.0, 'Beige', 85.0, 220.0, 100.0, 'Camera da letto', 'Divani', 'Poz'),
('Libreria soggiorno moderna', 500.0, 'Libreria elegante con scaffali regolabili.', 'Legno massello', 80.0, 'Marrone', 200.0, 120.0, 40.0, 'Soggiorno', 'Librerie e scaffali', 'Poz'),
('Scaffale bagno compatto', 150.0, 'Scaffale a tre ripiani per spazi piccoli.', 'Plastica', 20.0, 'Bianco', 90.0, 60.0, 30.0, 'Bagno', 'Librerie e scaffali', 'Poz'),
('Libreria cucina multiuso', 250.0, 'Libreria per utensili e oggetti decorativi.', 'Metallo', 50.0, 'Grigio', 180.0, 90.0, 35.0, 'Cucina', 'Librerie e scaffali', 'Poz'),
('Libreria camera classica', 600.0, 'Libreria elegante con ante in vetro.', 'Legno', 100.0, 'Marrone', 220.0, 140.0, 45.0, 'Camera da letto', 'Librerie e scaffali', 'Poz'),
('Scaffale studio modulare', 400.0, 'Scaffale modulare per uffici o studi.', 'Metallo e plastica', 70.0, 'Nero', 190.0, 100.0, 40.0, 'Studio', 'Librerie e scaffali', 'Poz');
 
-- Immagini per prodotti
INSERT INTO ImmagineProdotto (PercorsoImg, Icona, CodiceProdotto) VALUES
('upload/products/armadio_moderno_1.png', 'Y', 1),      -- GAIA
('upload/products/armadio_moderno_2.png', 'N', 1),
('upload/products/divano_angolare_1.png', 'Y', 2),
('upload/products/divano_angolare_2.png', 'N', 2),
('upload/products/libreria_modulare_1.png', 'Y', 3),
('upload/products/libreria_modulare_2.png', 'N', 3),
('upload/products/sedia_design_1.png', 'Y', 4),
('upload/products/sedia_design_2.png', 'N', 4),
('upload/products/tavolino_caffe_1.png', 'Y', 5),
('upload/products/tavolino_caffe_2.png', 'N', 5),
('upload/products/tavolo_pranzo_1.png', 'Y', 6),
('upload/products/tavolo_pranzo_2.png', 'N', 6),
('upload/products/sedia_imbottita_1.png', 'Y', 7),
('upload/products/sedia_imbottita_2.png', 'N', 7),
('upload/products/cassettiera_compatta_1.png', 'Y', 8),
('upload/products/cassettiera_compatta_2.png', 'N', 8),
('upload/products/armadio_pensile_1.png', 'Y', 9),
('upload/products/armadio_pensile_2.png', 'N', 9),
('upload/products/credenza_1.png', 'Y', 10),
('upload/products/credenza_2.png', 'N', 10),
('upload/products/mobile_bagno_1.png', 'Y', 11),
('upload/products/mobile_bagno_2.png', 'N', 11),
('upload/products/specchio_led_1.png', 'Y', 12),
('upload/products/specchio_led_2.png', 'N', 12),
('upload/products/sgabello_doccia_1.png', 'Y', 13),
('upload/products/sgabello_doccia_2.png', 'N', 13),
('upload/products/armadio_biancheria_1.png', 'Y', 14),
('upload/products/armadio_biancheria_2.png', 'N', 14),
('upload/products/tavolino_multifunzione_1.png', 'Y', 15),
('upload/products/tavolino_multifunzione_2.png', 'N', 15),
('upload/products/letto_matrimoniale_1.png', 'Y', 16),
('upload/products/letto_matrimoniale_2.png', 'N', 16),
('upload/products/comodino_moderno_1.png', 'Y', 17),
('upload/products/comodino_moderno_2.png', 'N', 17),
('upload/products/armadio_scorrevole_1.png', 'Y', 18),
('upload/products/armadio_scorrevole_2.png', 'N', 18),
('upload/products/libreria_minimal_1.png', 'Y', 19),
('upload/products/libreria_minimal_2.png', 'N', 19),
('upload/products/poltrona_relax_1.png', 'Y', 20),
('upload/products/poltrona_relax_2.png', 'N', 20),
('upload/products/tavolo_ovale_1.png', 'Y', 21),
('upload/products/tavolo_ovale_2.png', 'N', 21),
('upload/products/sedia_elegante_1.png', 'Y', 22),
('upload/products/sedia_elegante_2.png', 'N', 22),  
('upload/products/credenza_classica_1.png', 'Y', 23),       -- PASO
('upload/products/credenza_classica_2.png', 'N', 23),       
('upload/products/cassettiera_vintage_1.png', 'Y', 24),
('upload/products/cassettiera_vintage_2.png', 'N', 24),
('upload/products/mensola_decorativa_1.png', 'Y', 25),
('upload/products/mensola_decorativa_2.png', 'N', 25),
('upload/products/scrivania_angolare_1.png', 'Y', 26),
('upload/products/scrivania_angolare_2.png', 'N', 26),
('upload/products/sedia_ergonomica_1.png', 'Y', 27),
('upload/products/sedia_ergonomica_2.png', 'N', 27),
('upload/products/libreria_verticale_1.png', 'Y', 28),
('upload/products/libreria_verticale_2.png', 'N', 28),
('upload/products/cassettiera_ruote_1.png', 'Y', 29),
('upload/products/cassettiera_ruote_2.png', 'N', 29),
('upload/products/armadio_archivio_1.png', 'Y', 30),
('upload/products/armadio_archivio_2.png', 'N', 30),
('upload/products/armadio_soggiorno_1.png', 'Y', 31),
('upload/products/armadio_soggiorno_2.png', 'N', 31),
('upload/products/armadio_bagno_1.png', 'Y', 32),
('upload/products/armadio_bagno_2.png', 'N', 32),
('upload/products/armadio_cucina_1.png', 'Y', 33),
('upload/products/armadio_cucina_2.png', 'N', 33),
('upload/products/guardaroba_camera_1.png', 'Y', 34),
('upload/products/guardaroba_camera_2.png', 'N', 34),
('upload/products/archivio_studio_1.png', 'Y', 35),
('upload/products/archivio_studio_2.png', 'N', 35),
('upload/products/letto_moderno_1.png', 'Y', 36),
('upload/products/letto_moderno_2.png', 'N', 36),
('upload/products/letto_singolo_1.png', 'Y', 37),
('upload/products/letto_singolo_2.png', 'N', 37),
('upload/products/divano_letto_1.png', 'Y', 38),
('upload/products/divano_letto_2.png', 'N', 38),
('upload/products/letto_castello_1.png', 'Y', 39),
('upload/products/letto_castello_2.png', 'N', 39),
('upload/products/letto_pieghevole_1.png', 'Y', 40),
('upload/products/letto_pieghevole_2.png', 'N', 40),
('upload/products/tavolo_pranzo_3.png', 'Y', 41),
('upload/products/tavolo_pranzo_4.png', 'N', 41),
('upload/products/scrivania_ufficio_1.png', 'Y', 42),
('upload/products/scrivania_ufficio_2.png', 'N', 42),
('upload/products/tavolino_soggiorno_1.png', 'Y', 43),
('upload/products/tavolino_soggiorno_2.png', 'N', 43),
('upload/products/tavolo_cucina_1.png', 'Y', 44),
('upload/products/tavolo_cucina_2.png', 'N', 44),
('upload/products/tavolo_pieghevole_1.png', 'Y', 45),       --POZ
('upload/products/tavolo_pieghevole_2.png', 'N', 45),
('upload/products/sedia_soggiorno_1.png', 'Y', 46),
('upload/products/sedia_soggiorno_2.png', 'N', 46),
('upload/products/sgabello_cucina_1.png', 'Y', 47),
('upload/products/sgabello_cucina_2.png', 'N', 47),
('upload/products/sedia_pranzo_1.png', 'Y', 48),
('upload/products/sedia_pranzo_2.png', 'N', 48),
('upload/products/sedia_studio_1.png', 'Y', 49),
('upload/products/sedia_studio_2.png', 'N', 49),
('upload/products/panca_bagno_1.png', 'Y', 50),
('upload/products/panca_bagno_2.png', 'N', 50),
('upload/products/cassettiera_soggiorno_1.png', 'Y', 51),
('upload/products/cassettiera_soggiorno_2.png', 'N', 51),
('upload/products/cassettiera_bagno_1.png', 'Y', 52),
('upload/products/cassettiera_bagno_2.png', 'N', 52),
('upload/products/cassettiera_camera_1.png', 'Y', 53),
('upload/products/cassettiera_camera_2.png', 'N', 53),
('upload/products/cassettiera_cucina_1.png', 'Y', 54),
('upload/products/cassettiera_cucina_2.png', 'N', 54),
('upload/products/cassettiera_studio_1.png', 'Y', 55),
('upload/products/cassettiera_studio_2.png', 'N', 55),
('upload/products/divano_letto_3.png', 'Y', 56),
('upload/products/divano_letto_4.png', 'N', 56),
('upload/products/divano_angolare_3.png', 'Y', 57),
('upload/products/divano_angolare_4.png', 'N', 57),
('upload/products/poltrona_relax_3.png', 'Y', 58),
('upload/products/poltrona_relax_4.png', 'N', 58),
('upload/products/divano_studio_1.png', 'Y', 59),
('upload/products/divano_studio_2.png', 'N', 59),
('upload/products/divano_classico_1.png', 'Y', 60),
('upload/products/divano_classico_2.png', 'N', 60),
('upload/products/libreria_soggiorno_1.png', 'Y', 61),
('upload/products/libreria_soggiorno_2.png', 'N', 61),
('upload/products/scaffale_bagno_1.png', 'Y', 62),
('upload/products/scaffale_bagno_2.png', 'N', 62),
('upload/products/libreria_cucina_1.png', 'Y', 63),
('upload/products/libreria_cucina_2.png', 'N', 63),
('upload/products/libreria_camera_1.png', 'Y', 64),
('upload/products/libreria_camera_2.png', 'N', 64),
('upload/products/scaffale_studio_1.png', 'Y', 65),
('upload/products/scaffale_studio_2.png', 'N', 65);


-- Populating Carrello table
INSERT INTO Carrello (Username) VALUES
('user1'),
('user2');

-- Populating DettaglioCarrello table
INSERT INTO DettaglioCarrello (IDcarrello, CodiceProdotto, Quantita) VALUES
(1, 1, 2),
(2, 2, 1);

-- Populating Ordine table
INSERT INTO Ordine (Data, Username, Spedito) VALUES
('2024-12-01', 'user1', 'Y'),
('2024-12-12', 'user1', 'N'),
('2024-12-02', 'user2', 'Y'),
('2024-12-03', 'user2', 'N');

-- Populating DettaglioOrdine table
INSERT INTO DettaglioOrdine (IDordine, CodiceProdotto, Quantita, PrezzoPagato) VALUES 
(1, 1, 2, 800.00),
(1, 2, 2, 500.00),
(2, 2, 1, 150.00),
(3, 1, 2, 800.00),
(4, 2, 1, 150.00);

-- Populating WishList table
INSERT INTO WishList (Username) VALUES
('user1'),
('user2');

-- Populating DettaglioWishlist table
INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist) VALUES
(1, 1),
(2, 1),
(3, 1),
(2, 2),
(3, 2);

-- Populating Notifiche table
INSERT INTO Notifiche (Username, Testo, Data) VALUES
('user1', 'Ordine Spedito', '2024-12-01 08:30:00'),
('user2', 'Nuovo Messaggio', '2024-12-02 14:45:00'),
('user2', 'Promozione Attiva', '2024-12-03 09:15:00');

-- Populating Recensione table
INSERT INTO Recensione (Testo, stelle, CodiceProdotto, Username) VALUES
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce in hendrerit nulla. Phasellus consequat sapien eleifend, porttitor est nec, consequat elit.', 5, 1, 'user1'),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce in hendrerit nulla. Phasellus consequat sapien eleifend, porttitor est nec, consequat elit.', 4, 2, 'user2'),
('Soddisfatto', 4, 3, 'user2');
