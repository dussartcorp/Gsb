drop table if exists comptable;

create table if not exists comptable (
	id char(4) NOT NULL,
	nom char(30) DEFAULT NULL,
	prenom char(30)  DEFAULT NULL, 
	login char(20) DEFAULT NULL,
	mdp varchar(512) DEFAULT NULL,
    primary key(id)
) Engine=InnoDB;

alter table visiteur modify mdp varchar(512);
update visiteur set mdp = SHA2(mdp, 512);
insert into comptable(id,nom,prenom,login,mdp) values 
('c01','AHMED ALI','Nassim','Anas', SHA2('P@ssw0rd', 512)),
('c02', 'LAUDE', 'Thibault', 'Lthi', SHA2('P@ssw0rd', 512)),
('c03', 'DUSSART', 'Luke', 'Dluke', SHA2('P@ssw0rd', 512));
select * from visiteur;
					 
Insert into etat(id, libelle) values("MP", "Mise en paiement");
Update etat set libelle = "Validée" where id="VA";
