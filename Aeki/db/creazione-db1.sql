-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Sat Dec 28 18:47:14 2024 
-- * LUN file: C:\Users\Pietro\Documents\ProgeettoWeb - Copy.lun 
-- * Schema: e-commerce/1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database e-commerce;
use e-commerce;


-- Tables Section
-- _____________ 

create table Ambiente (
     NomeAmbiente char(1) not null,
     constraint ID_Ambiente_ID primary key (NomeAmbiente));

create table Carrello (
     IDcarrelo char(1) not null,
     Username char(1) not null,
     constraint ID_Carrello_ID primary key (IDcarrelo),
     constraint FKpossiede_ID unique (Username));

create table Categoria (
     NomeCategoria char(1) not null,
     constraint ID_Categoria_ID primary key (NomeCategoria));

create table Colorazione (
     NomeColore char(1) not null,
     CodiceProdotto char(1) not null,
     constraint ID_Colorazione_ID primary key (NomeColore, CodiceProdotto));

create table Colore (
     NomeColore char(1) not null,
     constraint ID_Colore_ID primary key (NomeColore));

create table DettaglioCarrello (
     IDcarrelo char(1) not null,
     CodiceProdotto char(1) not null,
     Quantita char(1) not null,
     constraint ID_DettaglioCarrello_ID primary key (CodiceProdotto, IDcarrelo));

create table DettaglioOrdine (
     IDordine char(1) not null,
     CodiceProdotto char(1) not null,
     Quantita char(1) not null,
     constraint ID_DettaglioOrdine_ID primary key (CodiceProdotto, IDordine));

create table DettaglioWishlist (
     CodiceProdotto char(1) not null,
     IDwishlist char(1) not null,
     constraint ID_DettaglioWishlist_ID primary key (CodiceProdotto, IDwishlist));

create table Immagine (
     PercorsoImg char(1) not null,
     Icona char not null,
     CodiceProdotto char(1) not null,
     constraint ID_Immagine_ID primary key (PercorsoImg));

create table Notifiche (
     IdNotifica char(1) not null,
     Username char(1) not null,
     Testo char(1) not null,
     Data date not null,
     constraint ID_Notifiche_ID primary key (IdNotifica),
     constraint SID_Notifiche_ID unique (Username, IdNotifica));

create table Ordine (
     IDordine char(1) not null,
     Username char(1) not null,
     constraint ID_Ordine_ID primary key (IDordine));

create table Prodotto (
     CodiceProdotto char(1) not null,
     Nome char(1) not null,
     Prezzo float(1) not null,
     Descrizione char(1) not null,
     Materiale char(1) not null,
     Peso float(1) not null,
     Disponibilita int not null,
     Altezza float(1) not null,
     Larghezza float(1) not null,
     Profondita float(1) not null,
     ValutazioneMedia float(1) not null,
     NumeroRecensioni int not null,
     Username char(1) not null,
     NomeAmbiente char(1) not null,
     NomeCategoria char(1) not null,
     constraint ID_Prodotto_ID primary key (CodiceProdotto));

create table Recensione (
     Testo char(1) not null,
     stelle int not null,
     IDrecensione char(1) not null,
     CodiceProdotto char(1) not null,
     Username char(1) not null,
     constraint ID_Recensione_ID primary key (IDrecensione),
     constraint SID_Recensione_ID unique (CodiceProdotto, Username, IDrecensione));

create table Utente (
     Nome char(1) not null,
     Cognome char(1) not null,
     Username char(1) not null,
     Email char(1) not null,
     Password char(1) not null,
     Tipo char(1) not null,
     PartitaIVA char(1),
     Telefono char(1) not null,
     constraint ID_Utente_ID primary key (Username));

create table WishList (
     IDwishlist char(1) not null,
     Username char(1) not null,
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
     foreign key (IDcarrelo)
     references Carrello (IDcarrelo);

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

alter table Immagine add constraint FKR_2_FK
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table Notifiche add constraint FKriceve
     foreign key (Username)
     references Utente (Username);

-- Not implemented
-- alter table Ordine add constraint ID_Ordine_CHK
--     check(exists(select * from DettaglioOrdine
--                  where DettaglioOrdine.IDordine = IDordine)); 

alter table Ordine add constraint FKfa_FK
     foreign key (Username)
     references Utente (Username);

-- Not implemented
-- alter table Prodotto add constraint ID_Prodotto_CHK
--     check(exists(select * from Immagine
--                  where Immagine.CodiceProdotto = CodiceProdotto)); 

-- Not implemented
-- alter table Prodotto add constraint ID_Prodotto_CHK
--     check(exists(select * from Colorazione
--                  where Colorazione.CodiceProdotto = CodiceProdotto)); 

alter table Prodotto add constraint FKaggiunge_FK
     foreign key (Username)
     references Utente (Username);

alter table Prodotto add constraint FKR_1_FK
     foreign key (NomeAmbiente)
     references Ambiente (NomeAmbiente);

alter table Prodotto add constraint FKR_FK
     foreign key (NomeCategoria)
     references Categoria (NomeCategoria);

alter table Recensione add constraint FKSuUn
     foreign key (CodiceProdotto)
     references Prodotto (CodiceProdotto);

alter table Recensione add constraint FKScrive_FK
     foreign key (Username)
     references Utente (Username);

alter table WishList add constraint FKha_FK
     foreign key (Username)
     references Utente (Username);


-- Index Section
-- _____________ 

create unique index ID_Ambiente_IND
     on Ambiente (NomeAmbiente);

create unique index ID_Carrello_IND
     on Carrello (IDcarrelo);

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
     on DettaglioCarrello (CodiceProdotto, IDcarrelo);

create index FKR_3_Car_IND
     on DettaglioCarrello (IDcarrelo);

create unique index ID_DettaglioOrdine_IND
     on DettaglioOrdine (CodiceProdotto, IDordine);

create index FKR_4_Ord_IND
     on DettaglioOrdine (IDordine);

create unique index ID_DettaglioWishlist_IND
     on DettaglioWishlist (CodiceProdotto, IDwishlist);

create index FKR_2_Wis_IND
     on DettaglioWishlist (IDwishlist);

create unique index ID_Immagine_IND
     on Immagine (PercorsoImg);

create index FKR_2_IND
     on Immagine (CodiceProdotto);

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

create index FKaggiunge_IND
     on Prodotto (Username);

create index FKR_1_IND
     on Prodotto (NomeAmbiente);

create index FKR_IND
     on Prodotto (NomeCategoria);

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

