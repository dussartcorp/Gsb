<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if ($uc === 'etatFraisComptable') { ?>
  <h2>Valider fiches de frais</h2>
  <div class="row">
    <div class="col-md-4">
      <h3>Sélectionner un visiteur : </h3>
    </div>
    <div class="col-md-4">
      <form action="index.php?uc=etatFraisComptable&action=selectionnerMois" 
            method="post" role="form">
        <div class="form-group">
          <label for="lstVisiteurs" accesskey="n">Visiteur : </label>
          <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
            <?php
            foreach ($lesVisiteurs as $unVisiteur) {
              $id_vst = $unVisiteur['id'];
              $nom_vst = $unVisiteur['nom'];
              $prenom_vst = $unVisiteur['prenom'];
              ?> 
              <option selected value="<?php echo $id_vst ?>">
                <?php echo $nom_vst . ' ' . $prenom_vst ?> </option> 
              <?php
            }
            ?>   
          </select>     
        </div>
        <input id="ok" type="submit" value="Valider" class="btn btn-success" 
               role="button">
        <input id="no" type="reset" value="Effacer" class="btn btn-danger" 
               role="button">
      </form> 
    </div>
  </div>
<?php } else { ?>
  <h2>Suivi fiche de frais</h2>
  <div class="row">
    <div class="col-md-4">
      <h4>Les visiteurs sont ceux du mois courantes, ayant une fiche de frais validée
      qui faut mettre en paiement.</h4>
      <h3>Sélectionner un visiteur : </h3>
    </div>
    <div class="col-md-4">
      <form action="index.php?uc=suivrePaiementFrais&action=FicheFraisSP" 
            method="post" role="form">
        <div class="form-group">
          <label for="lstVisiteur" accesskey="n">Visiteur : </label>
          <select id="lstVisiteur" name="lstVisiteur" class="form-control">
            <?php
            foreach ($lesVisiteurs as $unVisiteur) {
              $id_vst = $unVisiteur['visiteur'];
              $nom_vst = $unVisiteur['nomvisiteur'];
              if ($selectedValue == $id_vst) {
                ?><option selected value="<?php echo $selectedValue ?>"><?php echo $unVisiteur['nomvisiteur'] ?></option>               
              <?php } else { ?> <option value="<?php echo $id_vst ?>"><?php echo $unVisiteur['nomvisiteur'] ?></option> <?php
              }
            }
            ?>   
          </select>     
        </div>
        <input id="ok" type="submit" value="Valider" class="btn btn-success" 
               role="button">
        <input id="no" type="reset" value="Effacer" class="btn btn-danger" 
               role="button">
      </form> 
    </div>
  </div>
<?php } 
