<?php
/**
 * Vue État de Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<?php if ($uc === 'etatFraisComptable') { ?>
    <hr>
    <div class="panel panel-primary">
        <div class="panel-heading">Fiche de frais du mois 
            <?php echo $numMois . '-' . $numAnnee ?> : </div>
        <div class="panel-body">
            <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
            depuis le <?php echo $dateModif ?> <br> 
            <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">Eléments forfaitisés</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <?php
                foreach ($lesFraisForfait as $unFraisForfait) {
                    $libelle = $unFraisForfait['libelle'];
                    ?>
                    <th> <?php echo htmlspecialchars($libelle) ?></th>
                    <?php
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($lesFraisForfait as $unFraisForfait) {
                    $quantite = $unFraisForfait['quantite'];
                    ?>
                    <td class="qteForfait"><?php echo $quantite ?> </td>
                    <?php
                }
                ?>
            </tr>
        </table>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait - 
            <?php echo $nbJustificatifs ?> justificatifs reçus</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class='montant'>Montant</th>
            </tr>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $date = $unFraisHorsForfait['date'];
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $montant = $unFraisHorsForfait['montant'];
                ?>
                <tr>
                    <td><?php echo $date ?></td>
                    <td><?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>


<?php } else { ?>
  <br><br>
  <form method="post" 
        role="form">
    <div class="panel panel-info" style="border-color: #E02A2A;">
      <div class="panel-heading" style="border-color: #E02A2A; background-color: #E02A2A; color: white;">Fiche</div>
      <table class="table table-bordered table-responsive">
        <tr>
          <th>Date de modification</th>
          <th>Nombre de justificatifs</th>
          <th>Montant</th>
          <th>IdEtat</th>
          <th>Libelle Etat</th>
        </tr>
        <?php
        foreach ($infoFicheDeFrais as $infoFiche) {
          $date = $infoFiche['dateModif'];

          foreach ($infoFraisHorsForfait as $frais) {
            $montant = $frais['montant'];
            $montants += $montant;
          }
          foreach ($infoFraisForfait as $frais) {
            $idLibelle = $frais['idfrais'];
            $fraiskm = $frais['fraiskm'];
            if ($idLibelle !== 'KM') {
              $montant = $frais['quantite'] * $frais['prix'];
            } else {
              $montant = $frais['quantite'] * $fraiskm;
            }
            $montants += $montant;
          }
          $nbJustificatifs = $infoFiche['nbJustificatifs'];
          $libelle = $infoFiche['libEtat'];
          $idEtat = $infoFiche['idEtat'];
          ?>
          <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $nbJustificatifs ?></td>
            <td><?php echo $montants ?></td>
            <td><?php echo $idEtat ?></td>
            <td><?php echo $libelle ?></td>
          </tr>
        <?php } ?>
      </table>
    </div>
    </br> </br>
    <form method="post" 
          role="form">
      <div class="panel panel-info" style="border-color: #E02A2A;">
        <div class="panel-heading" style="border-color: #E02A2A; background-color: #E02A2A; color: white;">Eléments forfaitisés</div>
        <table class="table table-bordered table-responsive">
          <tr>
            <th>Libelle</th>
            <th>IDLibelle</th>
            <th>Quantités</th>
            <th>Prix</th>
          </tr>
          <?php
          foreach ($infoFraisForfait as $frais) {
            $idLibelle = $frais['idfrais'];
            $libelleFrais = $frais['libelle'];
            $quantite = $frais['quantite'];
            $prix = $frais['prix'];
            $fraiskm = $frais['fraiskm'];
            ?>
            <tr>
              <td><?php echo $libelleFrais ?></td>
              <td><?php echo $idLibelle ?></td>
              <td><?php echo $quantite ?></td>
              <?php if ($idLibelle !== 'KM') { ?>
                <td><?php echo $prix ?></td>
              <?php } else { ?>
                <td><?php echo $fraiskm ?></td>
              <?php } ?>
            </tr>

          <?php } ?>
        </table>
      </div>
      </br> </br>
      <form method="post" 
            role="form">
        <div class="panel panel-info" style="border-color: #E02A2A;">
          <div class="panel-heading" style="border-color: #E02A2A; background-color: #E02A2A; color: white;">Eléments hors-forfait</div>
          <table class="table table-bordered table-responsive">
            <tr>
              <th>Date</th>
              <th>Libelle</th>
              <th>Montant</th>
            </tr>
            <?php
            foreach ($infoFraisHorsForfait as $frais) {
              $date = $frais['date'];
              $datee = implode('-', array_reverse(explode('/', $date))); /* transform une date fr en une date us -> 29/10/2020 en 2020-10-29 */
              $libellehorsFrais = $frais['libelle'];
              $montant = $frais['montant'];
              $id = $frais['id'];
              ?>
              <tr>
                <td><?php echo $datee ?></td>
                <td><?php echo $libellehorsFrais ?></td>
                <td><?php echo $montant ?> € </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </form>
      <form method="post" 
            action="index.php?uc=suivrePaiementFrais&action=Valider" 
            role="form">
        <input id="okFicheFrais" type="submit" value="Mettre en Paiement" class="btn btn-success" 
               accept=""role="button" onclick="return confirm('Voulez-vous vraiment mettre en paiement cette fiche de frais ?');">
        </form></br></br>
<?php }
