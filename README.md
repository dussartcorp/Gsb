## PPE - GSB Par les magnifiques développeur de la Dussart Corp

### L'entreprise
Le laboratoire Galaxy Swiss Bourdin (GSB) est issu de la fusion entre le géant américain Galaxy (spécialisé dans le secteur des maladies virales dont le SIDA et les hépatites) et le conglomérat européen Swiss Bourdin (travaillant sur des médicaments plus conventionnels), lui-même déjà union de trois petits laboratoires. 

### L'application
Le travail à réaliser porte sur le développement d'une application de gestion des frais de déplacement, de restauration et d'hébergement générés par l'activité de visite médicale. L'application va permettre d'établir une gestion plus précise et uniforme entre les entités du laboratoire. Elle devra permettre aux visiteurs d'inscrire leurs dépenses, de visualiser la prise en charge des remboursements (enregistré, validé, remboursé). 

### Différentes Méthodes
**1. Développement de la partie comptable** 

Coder la partie comptable en respectant le cas d'utilisation correspondant et respecter les règles présentées dans le document "Normes de développement"
  - Tâche 1 : Validation d'une fiche de frais
  - Tâche 2 : Suivi du paiement des fiches de frais
  - Tâche 3 : Production de la documentation
  - Tâche 4 : Gestion du refus de certains frais hors forfait
  - Tâche 5 : Sécurisation des mots de passe stockés
  - Tâche 6 : Gestion plus fine de l'indemnisation kilométrique
  - Tâche 7 : Génération d'un état de frais au format PDF
  - Tâche 8 : Davantage d'écologie dans l'application

**2. Gestion de la clôture** 

Le cahier des charges de l’application Frais GSB stipule que la fiche d’un visiteur est clôturée au dernier jour du mois. Cette clôture sera réalisée par l’application selon l’une des modalités suivantes :  À la première saisie pour le mois N par le visiteur, sa fiche du mois précédent est clôturée si elle ne l’est pas. Au début de la campagne de validation des fiches par le service comptable, un script est lancé qui clôture toutes les fiches non clôturées du mois qui va être traité.
  - Tâche 1 : Création de la classe d'accès aux données
  - Tâche 2 : Création d'une classe de gestion de dates
  - Tâche 3 : Création de l'application
  - Tâche 4 : Création d'un service Windows
  
**3. Application mobile** 

Suite aux demandes des visiteurs, une application Android est en cours de développement. Elle doit permettre aux visiteurs de saisir en direct leurs frais (forfaitisés ou hors forfaits). L'application est une sorte de mémo qui permet d'enregistrer l'information à tout moment. Les visiteurs peuvent ensuite consulter leur mobile pour voir ce qu'ils ont enregistré et ainsi remplir le formulaire sur le site officiel. 
  - Tâche 1 : Configuration
  - Tâche 2 : Interdiction de saisie directe des quantités
  - Tâche 3 : Enregistrement des autres catégories de frais forfaitisés
  - Tâche 4 : Suppression de frais hors forfait
  - Tâche 5 : Synchronisation avec la base de données distante
