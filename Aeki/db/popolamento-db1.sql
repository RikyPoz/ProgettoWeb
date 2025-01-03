-- Populating Utente table
INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono) VALUES
('Mario', 'Rossi', 'user1', 'mario.rossi@example.com', 'password123', 'Cliente', NULL, '1234567890'),
('Luigi', 'Verdi', 'user2', 'luigi.verdi@example.com', 'password123', 'Cliente', NULL, '0987654321'),
('Anna', 'Bianchi', 'user3', 'anna.bianchi@example.com', 'password123', 'Venditore', '12345678901', '1122334455');

-- Populating Ambiente table
INSERT INTO Ambiente (NomeAmbiente, PercorsoImmagine) VALUES
('Soggiorno', '../upload/homePage/soggiorno.png'),
('Cucina', 'upload/homePage/cucina.png'),
('Bagno', 'upload/homePage/bagno.png'),
('Camera', 'upload/homePage/cameradaletto.png');

-- Populating Categoria table
INSERT INTO Categoria (NomeCategoria, PercorsoImmagine) VALUES
('Armadi', 'upload/homePage/armadio.png'),
('Letti', 'upload/homePage/letto.png'),
('Tavoli', 'upload/homePage/tavolo.png'),
('Sedie', 'upload/homePage/sedia.png');

-- Populating Prodotto table
INSERT INTO Prodotto (CodiceProdotto, Nome, Prezzo, Descrizione, Materiale, Peso, Disponibilita, Altezza, Larghezza, Profondita, ValutazioneMedia, NumeroRecensioni, NomeAmbiente, NomeCategoria, Username) VALUES
('PROD1', 'Sedia', 75.0, 'Sedia in legno', 'Legno', 5.0, 10, 90.0, 45.0, 45.0, 4.5, 20, 'Soggiorno', 'Sedie', 'user1'),
('PROD2', 'Tavolo', 150.0, 'Tavolo da pranzo', 'Metallo', 20.0, 5, 75.0, 150.0, 75.0, 4.8, 15, 'Cucina', 'Tavoli', 'user2'),
('PROD3', 'Lampada', 50.0, 'Lampada da terra', 'Plastica', 3.0, 8, 180.0, 50.0, 50.0, 4.2, 30, 'Camera', 'Letti', 'user3');

-- Populating Immagine table
INSERT INTO ImmagineProdotto (PercorsoImg, Icona, CodiceProdotto) VALUES
('upload/products/img1.png', 'Y', 'PROD1'),
('upload/products/img2.png', 'N', 'PROD1'),
('upload/products/img3.png', 'N', 'PROD1'),
('upload/products/imgLampada.png', 'Y', 'PROD2'),
('upload/products/images.png', 'Y', 'PROD3');

-- Populating Carrello table
INSERT INTO Carrello (IDcarrelo, Username) VALUES
('CAR1', 'user1'),
('CAR2', 'user2'),
('CAR3', 'user3');


-- Populating Colore table
INSERT INTO Colore (NomeColore) VALUES
('Rosso'),
('Blu'),
('Verde');

-- Populating Colorazione table
INSERT INTO Colorazione (NomeColore, CodiceProdotto) VALUES
('Rosso', 'PROD1'),
('Blu', 'PROD2'),
('Verde', 'PROD3');


-- Populating Notifiche table
INSERT INTO Notifiche (IdNotifica, Username, Testo, Data) VALUES
('NOT1', 'user1', 'Ordine Spedito', '2024-12-01'),
('NOT2', 'user2', 'Nuovo Messaggio', '2024-12-02'),
('NOT3', 'user3', 'Promozione Attiva', '2024-12-03');

-- Populating Ordine table
INSERT INTO Ordine (IDordine, Data, Username) VALUES
('ORD1', '2024-12-01', 'user1'),
('ORD4', '2024-12-12', 'user1'),
('ORD2', '2024-12-02', 'user2'),
('ORD3', '2024-12-03', 'user3');


-- Populating Recensione table
INSERT INTO Recensione (Testo, stelle, IDrecensione, CodiceProdotto, Username) VALUES
('Ottimo prodotto', 5, 'REC1', 'PROD1', 'user1'),
('Molto buono', 4, 'REC2', 'PROD2', 'user2'),
('Soddisfatto', 4, 'REC3', 'PROD3', 'user3');

-- Populating WishList table
INSERT INTO WishList (IDwishlist, Username) VALUES
('WISH1', 'user1'),
('WISH2', 'user2'),
('WISH3', 'user3');

-- Populating DettaglioCarrello table
INSERT INTO DettaglioCarrello (IDcarrelo, CodiceProdotto, Quantita) VALUES
('CAR1', 'PROD1', '2'),
('CAR2', 'PROD2', '1'),
('CAR3', 'PROD3', '4');

-- Populating DettaglioOrdine table
INSERT INTO DettaglioOrdine (IDordine, CodiceProdotto, Quantita, PrezzoPagato) VALUES
('ORD1', 'PROD1', '2', 150.0),
('ORD4', 'PROD2', '2', 80.0),
('ORD4', 'PROD3', '2', 60.0),
('ORD2', 'PROD2', '1', 75.0),
('ORD3', 'PROD3', '4', 300.0);

-- Populating DettaglioWishlist table
INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist) VALUES
('PROD1', 'WISH1'),
('PROD2', 'WISH1'),
('PROD3', 'WISH1'),
('PROD2', 'WISH2'),
('PROD3', 'WISH3');