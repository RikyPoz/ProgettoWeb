--modifiche tabelle

create table Prodotto (
     CodiceProdotto VARCHAR(100) not null,
     Nome VARCHAR(100) not null,
     Prezzo VARCHAR(100) not null,
     Descrizione VARCHAR(100) not null,
     Materiale VARCHAR(100) not null,
     Peso VARCHAR(100) not null,
     Altezza VARCHAR(100) not null,
     Lunghezza VARCHAR(100) not null,
     Profondita VARCHAR(100) not null,
     ValutazioneMedia VARCHAR(100) not null,
     NumeroRecensioni VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     NomeAmbiente VARCHAR(100) not null,
     NomeCategoria VARCHAR(100) not null,
     constraint ID_Prodotto_ID primary key (CodiceProdotto));


--modifiche popolamento

INSERT INTO Prodotto (CodiceProdotto, Nome, Prezzo, Descrizione, Materiale, Peso, Altezza, Lunghezza, Profondita, ValutazioneMedia, NumeroRecensioni, Username, NomeAmbiente, NomeCategoria)
VALUES
    ('P001', 'Piantina Verde', '20', 'Piantina verde perfetta per l'arredamento in ogni ambiente della casa', 'Vegetale', '3kg', '40cm', '10cm', '10cm', '4', '19', 'abianchi', 'Cucina', 'Elettrodomestici'),
