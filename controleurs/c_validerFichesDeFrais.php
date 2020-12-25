<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idcomptable = $_SESSION['idComptable'];
$montants = 0;
switch ($action) {
  case 'selectionnerVisiteur':
    $lesVisiteurs = $pdo->getListeVisiteurs();
    $idvst = filter_input(INPUT_POST, "lstVisiteurs", FILTER_SANITIZE_STRING);
    $_SESSION['idVisi'] = $idvst;
    include 'vues/comptable/v_listeVisiteur.php';
    break;
  case 'selectionnerMois':
    $idvst = filter_input(INPUT_POST, "lstVisiteurs", FILTER_SANITIZE_STRING);
    $_SESSION['idVisi'] = $idvst;
    $lesMois = $pdo->getLesMoisDisponiblesCR($_SESSION['idVisi']);
    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
    // on demande toutes les clés, et on prend la première,
    // les mois étant triés décroissants
    if (empty($lesMois)) {
      ?></br><?php
      ajouterErreur("Aucune fiche de frais n'est à valider pour ce visiteur. Veuillez-en choisir un autre");
      include 'vues/v_erreurs.php';
      include 'vues/comptable/v_listeMoisComptable.php';
    } else {
      $lesCles = array_keys($lesMois);
      $moisASelectionner = $lesCles[0];
      include 'vues/comptable/v_listeMoisComptable.php';
    }
    break;
  case 'voirEtatFrais':
    $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $_SESSION['date'] = $leMois;
    $lesMois = $pdo->getLesMoisDisponiblesCR($_SESSION['idVisi']);
    $moisASelectionner = $leMois;
    include 'vues/comptable/v_listeMoisComptable.php';
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    include 'vues/comptable/v_etatFraisComptable.php';
    break;
  case 'CorrigerNbJustificatifs' :
    $lesMois = $pdo->getLesMoisDisponiblesCR($_SESSION['idVisi']);
    $moisASelectionne = $_SESSION['date'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $nbJust = filter_input(INPUT_POST, 'nbJust', FILTER_DEFAULT);
    if (estEntierPositif($nbJust)) {
      $pdo->majNbJustificatifs($_SESSION['idVisi'], $_SESSION['date'], $nbJust);
      ?>
      <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
      <?php
    } else {
      ajouterErreur('Les valeurs des frais doivent être numériques');
      include 'vues/v_erreurs.php';
    }
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['date']);
    include'vues/comptable/v_etatFraisComptable.php';

    break;
  case 'CorrigerFraisForfait':
    $lesMois = $pdo->getLesMoisDisponiblesCR($_SESSION['idVisi']);
    $moisASelectionne = $_SESSION['date'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $selectedValue = $_SESSION['idVisi'];
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
      $pdo->majFraisForfait($_SESSION['idVisi'], $_SESSION['date'], $lesFrais);
      ?>
      <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
      <?php
    } else {
      ajouterErreur('Les valeurs des frais doivent être numériques');
      include 'vues/v_erreurs.php';
    }
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['date']);
    include'vues/comptable/v_etatFraisComptable.php';
    break;
  case 'CorrigerElemHorsForfait' :
    $lesMois = $pdo->getLesMoisDisponiblesCR($_SESSION['idVisi']);
    $moisASelectionne = $_SESSION['date'];
    include 'vues/comptable/v_listeMoisComptable.php';
    $selectedValue = $_SESSION['idVisi'];
    $lesHorsForfaitDate = (filter_input(INPUT_POST, 'lesDates', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
    $lesHorsForfaitLibelle = (filter_input(INPUT_POST, 'lesLibelles', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
    $lesHorsForfaitMontant = (filter_input(INPUT_POST, 'lesMontants', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
    foreach ($lesHorsForfaitDate as $uneDate) {
      dateAnglaisVersFrancais($uneDate);
      foreach ($lesHorsForfaitLibelle as $unLibelle) {
        foreach ($lesHorsForfaitMontant as $unMontant) {
          if (estDateDepassee($uneDate) || ($unLibelle == '') || ($unMontant == '')) {
            ajouterErreur('Une information est mauvaise. Rappel: date de moins de 1 ans, libelle et montant non null');
            include 'vues/v_erreurs.php';
            break 3;
          } else {
            $pdo->majFraisHorsForfait($_SESSION['idVisi'], $_SESSION['date'], $lesHorsForfaitLibelle, $lesHorsForfaitMontant, $lesHorsForfaitDate);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
            break 3;
          }
        }
      }
    }
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesFraisForfait = $pdo->getLesFraisForfait($_SESSION['idVisi'], $_SESSION['date']);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($_SESSION['idVisi'], $_SESSION['date']);
    include'vues/v_ValiderFicheDeFrais.php';
    break;
  case 'supprimerFrais':
    $unIdFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $ceMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
    ?></br>
    <div class="alert alert-info" role="alert">
      <p><h4>Voulez vous modifier ou supprimer le frais?<br></h4>
      <a href="index.php?uc=validerFichesDeFrais&action=supprimer&idFrais=<?php echo $unIdFrais ?>">Supprimer</a> 
      ou <a href="index.php?uc=validerFichesDeFrais&action=reporter&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>&id=<?php echo $idVisiteur ?>">Reporter</a></p>
    </div>
    <?php
    break;
  case 'supprimer':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $pdo->refuserFraisHorsForfait($idFrais);
    ?>
    <div class="alert alert-info" role="alert">
      <p>Ce frais hors forfait a bien été supprimé! <a href = "index.php?uc=validerFichesDeFrais&action=selectionnerVisiteur">Cliquez ici</a>
        pour revenir à la selection.</p>
    </div>
    <?php
    break;

  case 'reporter':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
    $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
    $moisSuivant = $pdo->getMoisSuivant($mois);
    $idVisiteur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if ($pdo->estPremierFraisMois($idVisiteur, $moisSuivant)) {
      $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
    }
    $moisAReporter = $pdo->reporterFraisHorsForfait($idFrais, $mois);
    ?>
    <div class="alert alert-info" role="alert">
      <p>Ce frais hors forfait a bien été reporté au mois suivant! <a href = "index.php?uc=validerFichesDeFrais&action=selectionnerVisiteur">Cliquez ici</a>
        pour revenir à la selection.</p>
    </div>
    <?php
    break;
  case 'Valider' :
    $pdo->validerFicheDeFrais($_SESSION['idVisi'], $_SESSION['date'], $_SESSION['montant']);
    ?> </br>
    <div class = "alert alert-success" role = "alert">
      <p>Votre fiche de frais a bien été validée ! <a href = "index.php?uc=ValiderFicheDeFrais&action=selectionnerMois">Cliquez ici</a>
        pour revenir à la selection.</p>
    </div>
  <?php
}
  