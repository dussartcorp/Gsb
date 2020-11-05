<?php
/**
 * Gestion de la validation des frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Nassim AHMED ALI <nassim.ahmedali@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];
switch ($action) {
case 'selectionnerVisiteur':
      $lesVisiteurs = $pdo->getListeVisiteurs();
      include 'vues/v_listeVisiteur.php';
   break;
case 'moisVisiteur':
    $id_vst = filter_input(INPUT_POST, "lstVisiteurs");
    $lesMois = $pdo->getLesMoisDisponibles($id_vst);
    $lesCles = array_keys($lesMois);
    $moisASelectionner = $lesCles[0];
    include 'vues/v_listeMois.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($id_vst,$moisASelectionner);
    $lesFraisForfait = $pdo->getLesFraisForfait($id_vst, $moisASelectionner);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($id_vst, $moisASelectionner);
    $numAnnee = substr($moisASelectionner, 0, 4);
    $numMois = substr($moisASelectionner, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_etatFrais.php';
    break;
}