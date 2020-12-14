
/**
Création table comptable
*/
DROP TABLE IF EXISTS comptable;

CREATE TABLE IF NOT EXISTS comptable (
	id char(4) NOT NULL,
	nom char(30) DEFAULT NULL,
	prenom char(30)  DEFAULT NULL, 
	login char(20) DEFAULT NULL,
	mdp varchar(512) DEFAULT NULL,
    primary key(id)
) Engine=InnoDB;

/**
Modification pour le hachage des mots de passe
*/
ALTER TABLE visiteur MODIFY mdp varchar(512);
UPDATE visiteur SET mdp = SHA2(mdp, 512);
/**
Insertion de comptable (nous) pour gérer les différentes fonctionnalités
*/
INSERT INTO comptable(id,nom,prenom,login,mdp) VALUES 
('c01','AHMED ALI','Nassim','Anas', SHA2('P@ssw0rd', 512)),
('c02', 'LAUDE', 'Thibault', 'Lthi', SHA2('P@ssw0rd', 512)),
('c03', 'DUSSART', 'Luke', 'Dluke', SHA2('P@ssw0rd', 512));
	
/**
Modification table etat pour dissocier "Validée" et "Mise en paiement"
*/
INSERT INTO etat(id, libelle) VALUES ("MP", "Mise en paiement");
UPDATE etat SET libelle = "Validée" WHERE id="VA";

					 
/**
Création table fraisKM pour gérer les différents types de puissances
*/
DROP TABLE IF EXISTS fraisKM;
CREATE TABLE IF NOT EXISTS fraisKm(
	id char(4) not null,
    libelle varchar(40) not null,
    prix decimal(3,2) not null,
    primary key(id)
    )Engine=InnoDB;
    
/**
Insertion dans fraisKM des infos que l'on a dans le sujet
*/
INSERT INTO fraisKm(id, libelle, prix) VALUES
('4D', 'véhicule 4CV diesel', 0.52),
('4E', 'véhicule 4CV essence', 0.62),
('5/6D', 'véhicule 5/6CV diesel ', 0.58),
('5/6E', 'véhicule 5/6CV essence', 0.67);
					 
/**
Modification de la table visiteur pour associer un fraisKm à un visiteur
*/
ALTER TABLE visiteur ADD idVehicule char(4) not null default '4D';
ALTER TABLE visiteur ADD CONSTRAINT FK_Visiteur_FraisKm foreign key(idVehicule) references fraisKM(id);
UPDATE visiteur SET idVehicule = '4E' WHERE id in ('a131','a93');
UPDATE visiteur SET idVehicule = '5/6D' WHERE id = 'a17';
UPDATE visiteur SET idVehicule = '5/6E' WHERE id in ('b16', 'b34', 'c3');
