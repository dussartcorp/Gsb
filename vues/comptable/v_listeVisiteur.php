<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2>Valider fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un visiteur : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=validerFichesDeFrais&action=selectionnerMois" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                        <?php 
                            foreach($lesVisiteurs as $unVisiteur)
                            {
                                $id_vst = $unVisiteur['id'];
                                $nom_vst = $unVisiteur['nom'];
                                $prenom_vst = $unVisiteur['prenom'];
                           ?> 
                            <option value="<?php echo $id_vst ?>">
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
