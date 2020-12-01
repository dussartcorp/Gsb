<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];
switch ($action) {
  case 'selectionnerSuiviV':
    $lesVisiteurs = $pdo->getListeVisiteurs();
    include 'vues/comptable/v_listeVisiteur.php';
    break;
  case 'moisVisiteur':
    $id_vst = filter_input(INPUT_POST, "lstVisiteurs");
    $_SESSION['idVisiteur'] = $id_vst;
    $lesMois = $pdo->getLesMoisDisponibles($_SESSION['idVisiteur']);
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisiteur'], $moisASelectionner);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisiteur'], $moisASelectionner);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisiteur'], $moisASelectionner);
    $numAnnee = substr($moisASelectionner, 0, 4);
    $numMois = substr($moisASelectionner, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php';
    break;
}