-- Populating Utente table
INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono) VALUES
('Mario', 'Rossi', 'user1', 'mario.rossi@example.com', 'password123', 'Cliente', NULL, '1234567890'),
('Luigi', 'Verdi', 'user2', 'luigi.verdi@example.com', 'password123', 'Cliente', NULL, '0987654321'),
('Anna', 'Bianchi', 'user3', 'anna.bianchi@example.com', 'password123', 'Venditore', '12345678901', '1122334455');

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

-- Populating Prodotto table
INSERT INTO Prodotto (Nome, Prezzo, Descrizione, Materiale, Peso, Disponibilita, Altezza, Larghezza, Profondita, ValutazioneMedia, NumeroRecensioni, NomeAmbiente, NomeCategoria, Username) VALUES
('Sedia', 75.0, 'Sedia in legno', 'Legno', 5.0, 10, 90.0, 45.0, 45.0, 4.5, 20, 'Soggiorno', 'Sedie', 'user1'),
('Tavolo', 150.0, 'Tavolo da pranzo', 'Metallo', 20.0, 5, 75.0, 150.0, 75.0, 4.8, 15, 'Cucina', 'Tavoli', 'user2'),
('Lampada', 50.0, 'Lampada da terra', 'Plastica', 3.0, 8, 180.0, 50.0, 50.0, 4.2, 30, 'Camera da letto', 'Letti', 'user3');

-- Populating Immagine table
INSERT INTO ImmagineProdotto (PercorsoImg, Icona, CodiceProdotto) VALUES
('upload/products/img1.png', 'Y', 1),
('upload/products/img2.png', 'N', 1),
('upload/products/img3.png', 'N', 1),
('upload/products/imgLampada.png', 'Y', 2),
('upload/products/images.png', 'Y', 3);

-- Populating Colore table
INSERT INTO Colore (NomeColore) VALUES
('Rosso'),
('Blu'),
('Verde');

-- Populating Colorazione table
INSERT INTO Colorazione (NomeColore, CodiceProdotto) VALUES
('Rosso', 1),
('Blu', 1),
('Blu', 2),
('Verde', 3);

-- Populating Carrello table
INSERT INTO Carrello (Username) VALUES
('user1'),
('user2'),
('user3');

-- Populating DettaglioCarrello table
INSERT INTO DettaglioCarrello (IDcarrello, CodiceProdotto, Quantita) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 4);

-- Populating Ordine table
INSERT INTO Ordine (Data, Username) VALUES
('2024-12-01', 'user1'),
('2024-12-12', 'user1'),
('2024-12-02', 'user2'),
('2024-12-03', 'user3');

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
('user2'),
('user3');

-- Populating DettaglioWishlist table
INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist) VALUES
(1, 1),
(2, 1),
(3, 1),
(2, 2),
(3, 3);

-- Populating Notifiche table
INSERT INTO Notifiche (Username, Testo, Data) VALUES
('user1', 'Ordine Spedito', '2024-12-01'),
('user2', 'Nuovo Messaggio', '2024-12-02'),
('user3', 'Promozione Attiva', '2024-12-03');

-- Populating Recensione table
INSERT INTO Recensione (Testo, stelle, CodiceProdotto, Username) VALUES
('Ottimo prodotto', 5, 1, 'user1'),
('Molto buono', 4, 2, 'user2'),
('Soddisfatto', 4, 3, 'user3');























