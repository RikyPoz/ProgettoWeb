-- Popola Ambiente
INSERT INTO Ambiente (NomeAmbiente) VALUES
('Cucina'),
('Salotto'),
('Camera da letto'),
('Bagno');

-- Popola Categoria
INSERT INTO Categoria (NomeCategoria) VALUES
('Mobili'),
('Elettrodomestici'),
('Decorazioni'),
('Illuminazione');

-- Popola Utente
INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono) VALUES
('Riccardo', 'Polazzi', 'poz', 'poz@example.com', 'pass', 'Cliente', NULL, '111111'),
('Pietro', 'Pasini', 'paso', 'paso@example.com', 'pass', 'Cliente', NULL, '111111'),
('Gaia', 'Pojaghi', 'gaa', 'gaa@example.com', 'pass', 'Cliente', NULL, '111111'),
('Luca', 'Bianchi', 'lbianchi', 'luca.bianchi@example.com', 'pass', 'Venditore', 'IT12345678901', '1122334455');

-- Popola Carrello
INSERT INTO Carrello (IDcarrello, Username) VALUES
('CART1', 'poz'),
('CART2', 'paso');

-- Popola WishList
INSERT INTO WishList (IDwishlist, Username) VALUES
('WISH1', 'poz'),
('WISH2', 'paso');

-- Popola Prodotto
INSERT INTO Prodotto (CodiceProdotto, Nome, Prezzo, Descrizione, Materiale, Peso, Disponibilita, Altezza, Larghezza, Profondita, ValutazioneMedia, NumeroRecensioni, Username, NomeAmbiente, NomeCategoria) VALUES
('P001', 'Scrivania', 299.99, 'Tavolo in legno massello', 'Legno', 30.5, 10, 75, 150, 90, 4.5, 20, 'lbianchi', 'Cucina', 'Mobili'),
('P002', 'Lampada da terra', 89.99, 'Lampada moderna in metallo', 'Metallo', 5.0, 15, 160, 30, 30, 4.8, 35, 'lbianchi', 'Salotto', 'Illuminazione'),
('P003', 'Poltrona', 129.99, 'Poltrona in tessuto con imbottitura', 'Tessuto', 20.0, 5, 90, 80, 85, 4.3, 10, 'lbianchi', 'Salotto', 'Mobili');

-- Popola Colorazione
INSERT INTO Colore (NomeColore) VALUES
('Bianco'),
('Nero'),
('Marrone');

INSERT INTO Colorazione (NomeColore, CodiceProdotto) VALUES
('Bianco', 'P001'),
('Nero', 'P002'),
('Marrone', 'P003');

-- Popola DettaglioCarrello
INSERT INTO DettaglioCarrello (IDcarrello, CodiceProdotto, Quantita) VALUES
('CART1', 'P001', 1),
('CART1', 'P003', 2),
('CART2', 'P002', 1);

-- Popola DettaglioWishlist
INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist) VALUES
('P001', 'WISH1'),
('P002', 'WISH1'),
('P003', 'WISH2');

-- Popola Ordine
INSERT INTO Ordine (IDordine, Username) VALUES
('ORD1', 'poz'),
('ORD2', 'paso');

-- Popola DettaglioOrdine
INSERT INTO DettaglioOrdine (IDordine, CodiceProdotto, Quantita) VALUES
('ORD1', 'P001', 1),
('ORD1', 'P003', 1),
('ORD2', 'P002', 2);

-- Popola Recensione
INSERT INTO Recensione (Testo, stelle, IDrecensione, CodiceProdotto, Username) VALUES
('Ottimo prodotto, consigliato!', 5, 'REV1', 'P001', 'poz'),
('Buona qualità, ma prezzo alto.', 4, 'REV2', 'P002', 'paso'),
('Comodo e di design.', 5, 'REV3', 'P003', 'poz');

-- Popola Immagine
INSERT INTO Immagine (PercorsoImg, Icona, CodiceProdotto) VALUES
('upload/poz/img1.png', 1, 'P001'),
('upload/poz/img2.png', 0, 'P001'),
('upload/poz/img3.png', 0, 'P001');

-- Popola Notifiche
INSERT INTO Notifiche (IdNotifica, Username, Testo, Data) VALUES
('NOT1', 'poz', 'Il tuo ordine è stato spedito.', '2024-12-20'),
('NOT2', 'paso', 'Il prodotto è tornato disponibile.', '2024-12-21');
