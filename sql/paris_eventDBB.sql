drop database if exists paris_event;
create database paris_event;
use paris_event;

-- création de la table client
create table Client (
    id_client int(5) primary key auto_increment,                     -- identifiant unique du client
    nom varchar(50) not null,                      -- nom de l'utilisateur
    prenom varchar(50) not null,                   -- prénom de l'utilisateur
    tel varchar(20) unique not null,   
    email varchar(50) unique not null,             -- email unique pour l'authentification
    
    mot_de_passe varchar(255) not null,             -- mot de passe
    role enum('client', 'administrateur', 'commercial') not null,  -- role de l'utilisateur
    date_inscription timestamp default current_timestamp  -- date d'inscription
);

insert into client values(null, "Gramatikoff", "Sacha","+33768163276","sgrama@hotmail.com","aze","administrateur",null);

-- création de la table hall
create table Hall (
    id_hall int auto_increment primary key,        -- identifiant unique du hall
    nom_hall varchar(255) not null,                 -- nom du hall 
    localisation varchar(255),                      -- localisation du hall
    description text,                               -- description du hall
    capacite_totale int not null,                   -- capacité totale du hall
    plan_hall varchar(255)                         -- url ou chemin du plan du hall
);

-- création de la table stand
create table Stand (
    id_stand int auto_increment primary key,        -- identifiant unique du stand
    id_hall int not null,                           -- lien avec le hall
    numero_stand varchar(50) not null,              -- numéro du stand
    surface int,      
    descrip text,                                   -- description de l'article
    lienImage varchar(255),                                -- surface du stand en m²
    disponibilite boolean default true,             -- disponibilité du stand
    prix decimal(10, 2),                            -- prix de location du stand
    foreign key (id_hall) references hall(id_hall) on delete cascade
);

insert into stand values(null, 1, 1,1,"Emplacement spacieux sous chapiteau, idéal pour exposants ou restauration.","stand1.png",true,150);
insert into stand values(null, 1, 1,1,"Zone privée avec sièges confortables et service personnalisé.","stand2.png",true,300);
insert into stand values(null, 1, 1,1,"Position stratégique haute visibilité, parfait pour les partenaires.","stand3.png",true,500);
insert into stand values(null, 1, 1,1,"Surface goudronnée avec accès électricité et eau pour food-trucks.","stand4.png",true,100);
insert into stand values(null, 1, 1,1,"Espace intimiste équipé pour conférences ou réceptions.","stand5.png",true,250);
insert into stand values(null, 1, 1,1,"Vue imprenable sur l’événement, idéal pour sponsor premium.","stand6.png",true,1250);
insert into stand values(null, 1, 1,1,"Local clé en main pour vendre des produits ou goodies.","stand7.png",true,350);
insert into stand values(null, 1, 1,1,"Emplacement angulaire, double visibilité pour maximiser l’impact.","stand8.png",true,400);
insert into stand values(null, 1, 1,1,"Surface équipée pour animations interactives ou présentations.","stand9.png",true,250);
insert into stand values(null, 1, 1,1,"Espace insonorisé dédié aux interviews et contenus live.","stand10.png",true,600);



-- création de la table article
create table Article (
    id_article int auto_increment primary key,      -- identifiant unique de l'article
    nom_article varchar(255) not null,               -- nom de l'article
    descrip text,                                -- description de l'article
    lienImage varchar(255),                               -- adresse relative de l'image de l'article
    quantite int(255),                                   -- quantité de l'article
    type enum('mobilier', 'electricite', 'repas', 'autre') not null,  -- type de service/produit
    prix decimal(10, 2) not null            -- prix unitaire de l'article
);

insert into article values(null, 'Chaises pliantes', 'Solides et empilables, idéales pour tout type de rassemblement.','article1.png',10,'autre',6);
insert into article values(null, 'Tables rondes élégantes', 'Pour 8 à 10 personnes, plateau lisse et pieds stables.','article2.png',10,'autre',30);
insert into article values(null, 'Bar en bois massif', 'Design moderne avec comptoir et étagères intégrées.','article3.png',10,'autre',100);
insert into article values(null, 'Luminaires LED', "Éclairage d'ambiance réglable en intensité et couleur.",'article4.png',10,'autre',2);
insert into article values(null, 'Tapis rouge', 'Longueur modulable pour une entrée prestigieuse.','article5.png',10,'autre',10);
insert into article values(null, 'Glacières professionnelles', 'Grand volume, maintien du froid 24h.','article6.png',10,'autre',30);
insert into article values(null, 'Podium ajustable', 'Hauteur variable, surface antidérapante.','article7.png',10,'autre',20);
insert into article values(null, 'Poubelles design', 'Discrètes et spacieuses, avec couvercle.','article8.png',10,'autre',15);
insert into article values(null, "Panneaux d'affichage", 'Structure autoportante, facile à personnaliser.','article9.png',10,'autre',30);
insert into article values(null, 'Chauffages extérieurs', 'Puissants et sécurisés pour les soirées fraîches.','article10.png',10,'autre',50);



-- création de la table reservation
create table Reservation (
    id_reservation int auto_increment primary key,  -- identifiant unique de la réservation
    id_client int not null,                         -- lien avec le client
    date_reservation timestamp default current_timestamp,  -- date de la réservation
    etat enum('en attente', 'confirmée', 'annulée') not null,  -- état de la réservation
    foreign key (id_client) references client(id_client) on delete cascade
);

-- création de la table facture
create table Facture (
    id_facture int auto_increment primary key,      -- identifiant unique de la facture
    id_reservation int not null,                    -- lien avec la réservation
    montant_total decimal(10, 2) not null,          -- montant total de la facture
    date_facture timestamp default current_timestamp,  -- date de la facture
    etat enum('payée', 'en attente', 'annulée') not null,  -- état de la facture
    foreign key (id_reservation) references reservation(id_reservation) on delete cascade
);

-- création de la table echange
create table Echange (
    id_echange int auto_increment primary key,      -- identifiant unique de l'échange
    id_utilisateur int not null,                    -- lien avec l'utilisateur
    message text not null,                          -- contenu du message échangé
    date_message timestamp default current_timestamp,  -- date de l'échange
    foreign key (id_utilisateur) references utilisateur(id_utilisateur) on delete cascade
);

create table reserverStand(
    id_reservation int not null,
    id_stand int unique not null,
    foreign key (id_reservation) references reservation(id_reservation) on delete cascade,
    foreign key (id_stand) references stand(id_stand) on delete cascade,
    primary key (id_reservation,id_stand)
);

create table reserverArticle(
    id_reservation int not null,
    id_article int unique not null,
    quantite int(255),
    foreign key (id_reservation) references reservation(id_reservation) on delete cascade,
    foreign key (id_article) references stand(id_article) on delete cascade,
    primary key (id_reservation,id_article)
);