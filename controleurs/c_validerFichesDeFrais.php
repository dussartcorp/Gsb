<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];

switch ($action) {
case 'selectionnerVisiteur':
     $lesVisiteurs = $pdo->getListeVisiteurs(); 
     $idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);
     $_SESSION['idVisi'] = $idvst;
     include 'vues/comptable/v_listeVisiteur.php';
     break; 
case 'selectionnerMois': 
    $idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);
    $_SESSION['idVisi'] = $idvst;
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisi']);
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include 'vues/comptable/v_listeMoisComptable.php';
    break;
case 'voirEtatFrais':
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $_SESSION['mois'] = $leMois;
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisi']);
    $moisASelectionner = $leMois;
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php'; 
    break;
case 'validerFicheFrais':
    $pdo->validerFichesDeFrais($_SESSION['idVisi'], $_SESSION['mois']);
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisi']);
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['mois']);
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php'; 
    break;
case 'modifierElementFicheHorsFrais':  
    $laDate = date('Y-m-d');
    $unMontant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_STRING);
    $unLibelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    var_dump($unMontant, $unLibelle);
    $pdo->modifierElementFicheHorsFrais($_SESSION['idVisi'],$laDate,$unMontant,$unLibelle);
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisi']);
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['mois']);
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php'; 
    break;
case 'modifierElementForfaitisés':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($_SESSION['idVisi'], $_SESSION['mois'], $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisi']);
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['mois']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['mois']);
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php'; 
    break;
case 'supprimerFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $pdo->supprimerFraisHorsForfait($idFrais);
    break;
}