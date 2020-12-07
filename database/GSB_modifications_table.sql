
/**
Création table comptable
*/
drop table if exists comptable;

create table if not exists comptable (
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
alter table visiteur modify mdp varchar(512);
update visiteur set mdp = SHA2(mdp, 512);
/**
Insertion de comptable (nous) pour gérer les différentes fonctionnalités
*/
insert into comptable(id,nom,prenom,login,mdp) values 
('c01','AHMED ALI','Nassim','Anas', SHA2('P@ssw0rd', 512)),
('c02', 'LAUDE', 'Thibault', 'Lthi', SHA2('P@ssw0rd', 512)),
('c03', 'DUSSART', 'Luke', 'Dluke', SHA2('P@ssw0rd', 512));
	
/**
Modification table etat pour dissocier "Validée" et "Mise en paiement"
*/
Insert into etat(id, libelle) values("MP", "Mise en paiement");
Update etat set libelle = "Validée" where id="VA";

					 
/**
Création table fraisKM pour gérer les différents types de puissances
*/
drop table fraisKM;
Create table if not exists fraisKm(
	id char(4) not null,
    libelle varchar(40) not null,
    prix decimal(3,2) not null,
    primary key(id)
    )Engine=InnoDB;
    
/**
Insertion dans fraisKM des infos que l'on a dans le sujet
*/
insert into fraisKm(id, libelle, prix) values
('4D', 'véhicule 4CV diesel', 0.52),
('4E', 'véhicule 4CV essence', 0.62),
('5/6D', 'véhicule 5/6CV diesel ', 0.58),
('5/6E', 'véhicule 5/6CV essence', 0.67);
					 
/**
Modification de la table visiteur pour associer un fraisKm à un visiteur
*/
alter table visiteur add idVehicule char(4) not null default '4D';
alter table visiteur add constraint FK_Visiteur_FraisKm foreign key(idVehicule) references fraisKM(id);
update visiteur set idVehicule = '4E' where id in ('a131','a93');
update visiteur set idVehicule = '5/6D' where id = 'a17';
update visiteur set idVehicule = '5/6E' where id in ('b16', 'b34', 'c3');
