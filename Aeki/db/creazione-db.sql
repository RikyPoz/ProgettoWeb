-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Fri Dec 27 17:00:58 2024 
-- * LUN file: C:\Users\Pietro\Documents\ProgeettoWeb.lun 
-- * Schema: e-commerce/1 
-- ********************************************* 


-- Database Section
-- ________________ 

drop database if exists aekiDb;
create database aekiDb;
use aekiDb;


-- Tables Section
-- _____________ 

create table Ambiente (
     NomeAmbiente VARCHAR(100) not null,
     constraint ID_Ambiente_ID primary key (NomeAmbiente));

create table Carrello (
     Username VARCHAR(100) not null,
     IDcarrelo VARCHAR(100) not null,
     constraint FKpossiede_ID primary key (Username));

create table Categoria (
     NomeCategoria VARCHAR(100) not null,
     constraint ID_Categoria_ID primary key (NomeCategoria));

create table Notifiche (
     IdNotifica VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     Testo VARCHAR(100) not null,
     Data VARCHAR(100) not null,
     constraint ID_Notifiche_ID primary key (IdNotifica),
     constraint SID_Notifiche_ID unique (Username, IdNotifica));

create table Ordine (
     ID_Ord int not null auto_increment,
     IDordine VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     constraint ID_ID primary key (ID_Ord));

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
     Img VARCHAR(100) not null,
     Disponibilita VARCHAR (100) not null,
     constraint ID_Prodotto_ID primary key (CodiceProdotto));

create table Colore (
     NomeColore VARCHAR(100) not null,
     constraint ID_Colore_ID primary key (NomeColore));

create table Colorazione (
     NomeColore VARCHAR(100) not null,
     CodiceProdotto VARCHAR(100) not null,
     constraint ID_Colorazione_ID primary key (NomeColore, CodiceProdotto));

create table DettaglioCarrello (
     Username VARCHAR(100) not null,
     CodiceProdotto VARCHAR(100) not null,
     constraint ID_DettaglioCarrello_ID primary key (CodiceProdotto, Username));

create table DettaglioOrdine (
     ID_Ord int not null,
     CodiceProdotto VARCHAR(100) not null,
     constraint ID_DettaglioOrdine_ID primary key (CodiceProdotto, ID_Ord));

create table DettaglioWishlist (
     CodiceProdotto VARCHAR(100) not null,
     IDwishlist VARCHAR(100) not null,
     constraint ID_DettaglioWishlist_ID primary key (CodiceProdotto, IDwishlist));

create table Recensione (
     Testo VARCHAR(100) not null,
     stelle VARCHAR(100) not null,
     IDrecensione VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     CodiceProdotto VARCHAR(100) not null,
     constraint ID_Recensione_ID primary key (IDrecensione),
     constraint SID_Recensione_ID unique (CodiceProdotto, Username, IDrecensione));

create table Utente (
     Nome VARCHAR(100) not null,
     Cognome VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     Email VARCHAR(100) not null,
     Password VARCHAR(100) not null,
     Tipo VARCHAR(100) not null,
     PartitaIVA VARCHAR(100),
     Telefono VARCHAR(100) not null,
     constraint ID_Utente_ID primary key (Username));

create table WishList (
     IDwishlist VARCHAR(100) not null,
     Username VARCHAR(100) not null,
     constraint ID_WishList_ID primary key (IDwishlist),
     constraint FKha_ID unique (Username));


-- Constraints Section
-- ___________________ 

alter table Carrello add constraint FKpossiede_FK
     foreign key (Username)
     references Utente (Username);

alter table Notifiche add constraint FKriceve
     foreign key (Username)
     references Utente (Username);

-- Not implemented
-- alter table Ordine add constraint ID_CHK
--     check(exists(select * from DettaglioOrdine
--                  where DettaglioOrdine.ID_Ord = ID_Ord)); 

alter table Ordine add constraint FKfa_FK
     foreign key (Username)
     references Utente (Username);

-- Not implemented
-- alter table Prodotto add constraint ID_Prodotto_CHK
--     check(exists(select * from Colorazione
--                  where Colorazione.CodiceProdotto = CodiceProdotto)); 

alter table Prodotto add constraint FKvende_FK
     foreign key (Username)
     references Utente (Username);

alter table Prodotto add constraint FKR_1_FK
     foreign key (NomeAmbiente)
     references Ambiente (NomeAmbiente);

alter table Prodotto add constraint FKR_FK
     foreign key (NomeCategoria)
     references Categoria (NomeCategoria);

alter table Colorazione add constraint FKR_2_Pro_FK
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table Colorazione add constraint FKR_2_Col
     foreign key (NomeColore)
     references Colore (NomeColore);

alter table DettaglioCarrello add constraint FKR_3_Pro
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table DettaglioCarrello add constraint FKR_3_Car_FK
     foreign key (Username)
     references Carrello (Username);

alter table DettaglioOrdine add constraint FKR_4_Pro
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table DettaglioOrdine add constraint FKR_4_Ord_FK
     foreign key (ID_Ord)
     references Ordine (ID_Ord);

alter table DettaglioWishlist add constraint FKR_2_Wis_FK
     foreign key (IDwishlist)
     references WishList (IDwishlist);

alter table DettaglioWishlist add constraint FKR_2_Pro_1
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table Recensione add constraint FKScrive_FK
     foreign key (Username)
     references Utente (Username);

alter table Recensione add constraint FKSuUn
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table WishList add constraint FKha_FK
     foreign key (Username)
     references Utente (Username);


-- Index Section
-- _____________ 

create unique index ID_Ambiente_IND
     on Ambiente (NomeAmbiente);

create unique index FKpossiede_IND
     on Carrello (Username);

create unique index ID_Categoria_IND
     on Categoria (NomeCategoria);

create unique index ID_Notifiche_IND
     on Notifiche (IdNotifica);

create unique index SID_Notifiche_IND
     on Notifiche (Username, IdNotifica);

create unique index ID_IND
     on Ordine (ID_Ord);

create index FKfa_IND
     on Ordine (Username);

create unique index ID_Prodotto_IND
     on Prodotto (CodiceProdotto);

create index FKvende_IND
     on Prodotto (Username);

create index FKR_1_IND
     on Prodotto (NomeAmbiente);

create index FKR_IND
     on Prodotto (NomeCategoria);

create unique index ID_Colore_IND
     on Colore (NomeColore);

create unique index ID_Colorazione_IND
     on Colorazione (NomeColore, CodiceProdotto);

create index FKR_2_Pro_IND
     on Colorazione (CodiceProdotto);

create unique index ID_DettaglioCarrello_IND
     on DettaglioCarrello (CodiceProdotto, Username);

create index FKR_3_Car_IND
     on DettaglioCarrello (Username);

create unique index ID_DettaglioOrdine_IND
     on DettaglioOrdine (CodiceProdotto, ID_Ord);

create index FKR_4_Ord_IND
     on DettaglioOrdine (ID_Ord);

create unique index ID_DettaglioWishlist_IND
     on DettaglioWishlist (CodiceProdotto, IDwishlist);

create index FKR_2_Wis_IND
     on DettaglioWishlist (IDwishlist);

create unique index ID_Recensione_IND
     on Recensione (IDrecensione);

create unique index SID_Recensione_IND
     on Recensione (CodiceProdotto, Username, IDrecensione);

create index FKScrive_IND
     on Recensione (Username);

create unique index ID_Utente_IND
     on Utente (Username);

create unique index ID_WishList_IND
     on WishList (IDwishlist);

create unique index FKha_IND
     on WishList (Username);








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
    ('W002', 'lverdi');
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


