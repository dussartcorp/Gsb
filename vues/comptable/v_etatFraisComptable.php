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
  <form action="index.php?uc=etatFraisComptable&action=#" 
        method="post" role="form">
    <fieldset>   
        <?php
        foreach ($lesFraisForfait as $unFrais) {
            $idFrais = $unFrais['idfrais'];
            $libelle = htmlspecialchars($unFrais['libelle']);
            $quantite = $unFrais['quantite'];
            ?>
          <div class="form-group">
            <label for="idFrais"><?php echo $libelle ?></label>
            <input type="text" id="idFrais" 
                   name="lesFrais[<?php echo $idFrais ?>]"
                   size="5" maxlength="5" 
                   value="<?php echo $quantite ?>" 
                   class="form-control">
          </div>
          <?php
      }
      ?>
      <button class="btn btn-success" type="submit">Corriger</button>
      <button class="btn btn-danger" type="reset">Reinitialiser</button>
    </fieldset>
  </form>
</div>


<div class="row">
  <form action="index.php?uc=etatFraisComptable&action=#" 
        method="post" role="form">
    <fieldset>
      <div class="panel panel-info">

        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th class="date">Date</th>
              <th class="libelle">Libellé</th>  
              <th class="montant">Montant</th>  
              <th class="action">&nbsp;</th> 
            </tr>
          </thead>  
          <tbody>
              <?php
              foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                  $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                  $date = $unFraisHorsForfait['date'];
                  // Met la date sous format americain
                  $dateR = implode('-', array_reverse(explode('/', $date))); 
                  $montant = $unFraisHorsForfait['montant'];
                  $id = $unFraisHorsForfait['id'];
                  ?>           
                <tr>
                  <td><input type="date" id="date" value=<?php echo $dateR ?>></td>
                  <td><input type="text" id="libelle" value=<?php echo $libelle ?>></td>
                  <td><input type="text" id="montant" value=<?php echo $montant ?>></td>
                  <td><a href="index.php?uc=gererFraisComptable&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                         onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');"><button class="btn btn-success" type="submit">Corriger</button></a></td>
                </tr>
                <?php
            }
            ?>
          </tbody>  
        </table> 
      </div>
      <!-- C'est pour le visuel n'a pas encore d'utilité propre -->
      <div>Nombre de justificatifs : <input type="text" id="nbjustificatifs" value=<?php echo $date ?>></div>
      <br>
      <button class="btn btn-success" type="submit">Corriger</button>
      <button class="btn btn-danger" type="reset">Reinitialiser</button>
    </fieldset>
</div>