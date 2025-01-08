-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Mon Dec 30 11:01:53 2024 
-- ********************************************* 


-- Database Section
-- ________________ 

drop database if exists aekiDB;
create database aekiDB;
use aekiDB;


-- Tables Section
-- _____________ 

create table Ambiente (
     NomeAmbiente VARCHAR(50) not null,
     PercorsoImmagine VARCHAR(50) not null,
     constraint ID_Ambiente_ID primary key (NomeAmbiente));

create table Carrello (
     IDcarrello INT AUTO_INCREMENT,
     Username VARCHAR(50) not null,
     constraint ID_Carrello_ID primary key (IDcarrello),
     constraint FKpossiede_ID unique (Username));

create table Categoria (
     NomeCategoria VARCHAR(50) not null,
     PercorsoImmagine VARCHAR(50) not null,
     constraint ID_Categoria_ID primary key (NomeCategoria));

create table Colorazione (
     NomeColore VARCHAR(50) not null,
     CodiceProdotto INT not null,
     constraint ID_Colorazione_ID primary key (NomeColore, CodiceProdotto));

create table Colore (
     NomeColore VARCHAR(50) not null,
     constraint ID_Colore_ID primary key (NomeColore));

create table DettaglioCarrello (
     IDcarrello INT not null,
     CodiceProdotto INT not null,
     Quantita INT not null,
     constraint ID_DettaglioCarrello_ID primary key (CodiceProdotto, IDcarrello));

create table DettaglioOrdine (
     IDordine INT not null,
     CodiceProdotto INT not null,
     Quantita INT not null,
     PrezzoPagato FLOAT not null,
     constraint ID_DettaglioOrdine_ID primary key (CodiceProdotto, IDordine));

create table DettaglioWishlist (
     CodiceProdotto INT not null,
     IDwishlist INT not null,
     constraint ID_DettaglioWishlist_ID primary key (CodiceProdotto, IDwishlist));

create table ImmagineProdotto (
     PercorsoImg VARCHAR(50) not null,
     Icona char not null,
     CodiceProdotto INT not null,
     constraint ID_ImmagineProdotto_ID primary key (PercorsoImg));

create table Notifiche (
     IdNotifica INT AUTO_INCREMENT,
     Username VARCHAR(50) not null,
     Testo VARCHAR(50) not null,
     Data DATETIME not null,
     constraint ID_Notifiche_ID primary key (IdNotifica),
     constraint SID_Notifiche_ID unique (Username, IdNotifica));

create table Ordine (
     IDordine INT AUTO_INCREMENT,
     Data date not null,
     Username VARCHAR(50) not null,
     constraint ID_Ordine_ID primary key (IDordine));

CREATE TABLE Prodotto (
    CodiceProdotto INT AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL,
    Prezzo FLOAT NOT NULL,
    Descrizione VARCHAR(200) NOT NULL,
    Materiale VARCHAR(50) NOT NULL,
    Peso FLOAT NOT NULL,
    Disponibilita INT NOT NULL DEFAULT 0,
    Altezza FLOAT NOT NULL,
    Larghezza FLOAT NOT NULL,
    Profondita FLOAT NOT NULL,
    ValutazioneMedia FLOAT NOT NULL DEFAULT 0,  
    NumeroRecensioni INT NOT NULL DEFAULT 0,      
    NomeAmbiente VARCHAR(50) NOT NULL,
    NomeCategoria VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL,
    CONSTRAINT ID_Prodotto_ID PRIMARY KEY (CodiceProdotto)
);

create table Recensione (
    IDrecensione INT AUTO_INCREMENT,
    Testo VARCHAR(200) not null,
    stelle INT not null,
    CodiceProdotto INT not null,
    Username VARCHAR(50) not null,
    constraint ID_Recensione_ID primary key (IDrecensione));

create table Utente (
     Nome VARCHAR(50) not null,
     Cognome VARCHAR(50) not null,
     Username VARCHAR(50) not null,
     Email VARCHAR(50) not null,
     Password VARCHAR(50) not null,
     Tipo VARCHAR(50) not null,
     PartitaIVA VARCHAR(50),
     Telefono VARCHAR(50) not null,
     Icona VARCHAR(50),
     constraint ID_Utente_ID primary key (Username));

create table WishList (
     IDwishlist INT AUTO_INCREMENT,
     Username VARCHAR(50) not null,
     constraint ID_WishList_ID primary key (IDwishlist),
     constraint FKha_ID unique (Username));


-- Constraints Section
-- ___________________ 

alter table Carrello add constraint FKpossiede_FK
     foreign key (Username)
     references Utente (Username);

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
     foreign key (IDcarrello)
     references Carrello (IDcarrello);

alter table DettaglioOrdine add constraint FKR_4_Pro
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table DettaglioOrdine add constraint FKR_4_Ord_FK
     foreign key (IDordine)
     references Ordine (IDordine);

alter table DettaglioWishlist add constraint FKR_2_Wis_FK
     foreign key (IDwishlist)
     references WishList (IDwishlist);

alter table DettaglioWishlist add constraint FKR_2_Pro_1
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table ImmagineProdotto add constraint FKR_2_FK
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table Notifiche add constraint FKriceve
     foreign key (Username)
     references Utente (Username);

alter table Ordine add constraint FKfa_FK
     foreign key (Username)
     references Utente (Username);

alter table Prodotto add constraint FKR_1_FK
     foreign key (NomeAmbiente)
     references Ambiente (NomeAmbiente);

alter table Prodotto add constraint FKR_FK
     foreign key (NomeCategoria)
     references Categoria (NomeCategoria);

alter table Prodotto add constraint FKaggiunge_FK
     foreign key (Username)
     references Utente (Username);

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

create unique index ID_Carrello_IND
     on Carrello (IDcarrello);

create unique index FKpossiede_IND
     on Carrello (Username);

create unique index ID_Categoria_IND
     on Categoria (NomeCategoria);

create unique index ID_Colorazione_IND
     on Colorazione (NomeColore, CodiceProdotto);

create index FKR_2_Pro_IND
     on Colorazione (CodiceProdotto);

create unique index ID_Colore_IND
     on Colore (NomeColore);

create unique index ID_DettaglioCarrello_IND
     on DettaglioCarrello (CodiceProdotto, IDcarrello);

create index FKR_3_Car_IND
     on DettaglioCarrello (IDcarrello);

create unique index ID_DettaglioOrdine_IND
     on DettaglioOrdine (CodiceProdotto, IDordine);

create index FKR_4_Ord_IND
     on DettaglioOrdine (IDordine);

create unique index ID_DettaglioWishlist_IND
     on DettaglioWishlist (CodiceProdotto, IDwishlist);

create index FKR_2_Wis_IND
     on DettaglioWishlist (IDwishlist);

create unique index ID_ImmagineProdotto_IND
     on ImmagineProdotto (PercorsoImg);

create index FKR_2_IND
     on ImmagineProdotto (CodiceProdotto);

create unique index ID_Notifiche_IND
     on Notifiche (IdNotifica);

create unique index SID_Notifiche_IND
     on Notifiche (Username, IdNotifica);

create unique index ID_Ordine_IND
     on Ordine (IDordine);

create index FKfa_IND
     on Ordine (Username);

create unique index ID_Prodotto_IND
     on Prodotto (CodiceProdotto);

create index FKR_1_IND
     on Prodotto (NomeAmbiente);

create index FKR_IND
     on Prodotto (NomeCategoria);

create index FKaggiunge_IND
     on Prodotto (Username);

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

