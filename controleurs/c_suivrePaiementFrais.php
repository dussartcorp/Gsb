<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$montants = 0;
$date = date('Ym');
switch ($action) {
  case 'selectionnerSuiviVisiteur':
    if (empty($pdo->getVisiteurFromMoisVA($date))) {
      ?></br><?php
      ajouterErreur("Aucun visiteur n'a de fiche de frais ce mois ci");
      include 'vues/v_erreurs.php';
      include 'vues/comptable/v_listeVisiteur.php';
    } else {
      $_SESSION['date'] = $date;
      $lesVisiteurs = $pdo->getVisiteurFromMoisVA($date);
      $selectedValue = $lesVisiteurs[0];
      include 'vues/comptable/v_listeVisiteur.php';
    }
    break;
  case 'FicheFraisSP':
    $idVisi = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
    $lesVisiteurs = $pdo->getVisiteurFromMoisVA($_SESSION['date']);
    $selectedValue = $idVisi;
    include 'vues/comptable/v_listeVisiteur.php';
    $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
    trim($nomVis);
    $_SESSION['visiteur'] = $idVisi;
    $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
    $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
    $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
    include 'vues/comptable/v_etatFraisComptable.php';
    $_SESSION['montant'] = $montants;
    break;
  case 'Valider' :
    $pdo->validerFicheDeFraisVA($_SESSION['visiteur'], $_SESSION['date'], $_SESSION['montant']);
    ?>
    <div class = "alert alert-success" role = "alert">
      <p>Votre fiche de frais a bien été mise en paiement ! <a href = "index.php?uc=suivrePaiementFrais&action=selectionnerSuiviVisiteur">Cliquez ici</a>
        pour revenir à la selection.</p>
    </div>
  <?php
}
