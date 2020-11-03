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
//switch ($action) {
//case 'selectionnerVisiteur':
      $lesVisiteurs = $pdo->getListeVisiteurs();
      require 'vues/v_listeVisiteur.php';
//   break;
//case 'selectionnerMois':
//    $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
//    $id_vst = $pdo->getIdVisiteur($leVisiteur['nom'],$leVisiteur['prenom']);
//    $lesMois = $pdo->getLesMoisDisponibles($id_vst);
//    $lesCles = array_keys($lesMois);
//    $moisASelectionner = $lesCles[0];
//    include 'vues/v_listeMois';
//    
//    break;
//}