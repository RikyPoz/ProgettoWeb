-- POPOLAMENTO




-- Popolamento della tabella Utente
INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono)
VALUES
    ('Riccardo', 'Polazzi', 'poz', 'poz@example.com', 'pass', 'cliente', NULL, '1234567890'),
    ('Mario', 'Rossi', 'mrossi', 'mrossi@example.com', 'password123', 'cliente', NULL, '1234567890'),
    ('Luigi', 'Verdi', 'lverdi', 'lverdi@example.com', 'password456', 'cliente', NULL, '0987654321'),
    ('Anna', 'Bianchi', 'abianchi', 'abianchi@example.com', 'password789', 'venditore', 'IT12345678901', '1122334455');

-- Popolamento della tabella Ambiente
INSERT INTO Ambiente (NomeAmbiente)
VALUES
    ('Cucina'),
    ('Salotto'),
    ('Camera da letto');

-- Popolamento della tabella Categoria
INSERT INTO Categoria (NomeCategoria)
VALUES
    ('Elettrodomestici'),
    ('Arredamento'),
    ('Decorazioni');

-- Popolamento della tabella Prodotto
INSERT INTO Prodotto (CodiceProdotto, Nome, Prezzo, Descrizione, Materiale, Peso, Altezza, Lunghezza, Profondita, ValutazioneMedia, NumeroRecensioni, Username, NomeAmbiente, NomeCategoria,Img,Disponibilita)
VALUES
    ('P001', 'Frigorifero', '499.99', 'Frigorifero a doppia porta', 'Acciaio', '70kg', '180cm', '70cm', '60cm', '4.5', '120', 'abianchi', 'Cucina', 'Elettrodomestici','upload/poz/img1.png','10'),
    ('P002', 'Divano', '299.99', 'Divano a tre posti', 'Tessuto', '50kg', '90cm', '200cm', '90cm', '4.2', '75', 'abianchi', 'Salotto', 'Arredamento','upload/poz/img1.png','12'),
    ('P003', 'Scrivania', '120', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Legno', '5kg', '70cm', '100cm', '5cm', '4.8', '50', 'poz', 'Salotto', 'Decorazioni','upload/poz/img1.png','13');

-- Popolamento della tabella Carrello
INSERT INTO Carrello (Username, IDcarrelo)
VALUES
    ('mrossi', 'C001'),
    ('lverdi', 'C002');

-- Popolamento della tabella DettaglioCarrello
INSERT INTO DettaglioCarrello (Username, CodiceProdotto)
VALUES
    ('mrossi', 'P001'),
    ('mrossi', 'P002'),
    ('lverdi', 'P003');

-- Popolamento della tabella WishList
INSERT INTO WishList (IDwishlist, Username)
VALUES
    ('W001', 'mrossi'),
    ('W002', 'lverdi'),
    ('WPOZ','poz');

-- Popolamento della tabella DettaglioWishlist
INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist)
VALUES
    ('P003', 'W001'),
    ('P002', 'W002'),
    ('P002', 'WPOZ'),
    ('P001', 'WPOZ');

-- Popolamento della tabella Notifiche
INSERT INTO Notifiche (IdNotifica, Username, Testo, Data)
VALUES
    ('N001', 'mrossi', 'Ordine spedito', '2024-12-25'),
    ('N002', 'lverdi', 'Nuova offerta disponibile', '2024-12-26');

-- Popolamento della tabella Ordine
INSERT INTO Ordine (IDordine, Username)
VALUES
    ('O001', 'mrossi'),
    ('O002', 'lverdi');

-- Popolamento della tabella DettaglioOrdine
INSERT INTO DettaglioOrdine (ID_Ord, CodiceProdotto)
VALUES
    (1, 'P001'),
    (2, 'P003');

-- Popolamento della tabella Recensione
INSERT INTO Recensione (Testo, stelle, IDrecensione, Username, CodiceProdotto)
VALUES
    ('Ottimo prodotto!', '5', 'R001', 'mrossi', 'P001'),
    ('Molto comodo e bello esteticamente.', '4', 'R002', 'lverdi', 'P002');

-- Popolamento della tabella Colore
INSERT INTO Colore (NomeColore)
VALUES
    ('Bianco'),
    ('Grigio'),
    ('Nero');

-- Popolamento della tabella Colorazione
INSERT INTO Colorazione (NomeColore, CodiceProdotto)
VALUES
    ('Bianco', 'P001'),
    ('Grigio', 'P002'),
    ('Nero', 'P003');


