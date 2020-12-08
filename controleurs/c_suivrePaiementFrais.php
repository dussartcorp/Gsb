<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];
$date = date('Ym');
switch ($action) {
  case 'selectionnerSuiviV':
    $_SESSION['date'] = $date;
    $lesVisiteurs = $pdo->getListeVisiteurVA($date);
    include 'vues/comptable/v_listeVisiteur.php';
    break;
  case 'afficheFiche':
    $id_vst = filter_input(INPUT_POST, "lstVisiteurs");
    $_SESSION['idVisiteur'] = $id_vst;
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisiteur'], $_SESSION['date']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisiteur'], $_SESSION['date']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisiteur'], $_SESSION['date']);
    $numAnnee = substr($_SESSION['date'], 0, 4);
    $numMois = substr($_SESSION['date'], 4, 2);
    $lesFiches = $lesInfosFicheFrais;
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/comptable/v_etatFraisComptable.php';
    break;
}