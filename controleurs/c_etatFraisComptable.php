<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];
//$idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);

switch ($action) {
case 'selectionnerVisiteur':
      $lesVisiteurs = $pdo->getListeVisiteurs(); 
      $idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);
      include 'vues/comptable/v_listeVisiteur.php';
      break; 
case 'selectionnerMois': 
    $idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);
    $_SESSION['idVisiteur'] = $idvst;
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisiteur']);
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include 'vues/comptable/v_listeMoisComptable.php';
    break;
case 'voirEtatFrais':
    $idvst = filter_input(INPUT_POST, "lstVisiteurs",FILTER_SANITIZE_STRING);
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idvst);
    $moisASelectionner = $leMois;
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvst, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idvst, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idvst, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php';
    
}