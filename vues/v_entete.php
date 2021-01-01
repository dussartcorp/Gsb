<?php
/**
 * Vue Entête
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
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title> 
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./styles/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="./styles/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a19b0d8700.js" crossorigin="anonymous"></script>
    <link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all"
          rel="stylesheet">
    <link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all"
          rel="stylesheet">
    <link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <?php
      $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
      if ($estConnecte) {
        ?>
        <div class="header">
          <div class="row vertical-align">
            <div class="col-md-4">
              <h1>
                <img src="./images/logo.jpg" class="img-responsive" 
                     alt="Laboratoire Galaxy-Swiss Bourdin" 
                     title="Laboratoire Galaxy-Swiss Bourdin">
              </h1>
            </div>
            <div class="col-md-8">
              <ul class="nav nav-pills pull-right" role="tablist">
                <!-- Barre de nav visiteur medical-->
                <?php if ($_SESSION['type'] === 'visiteur') { ?>
                  <li <?php if (!$uc || $uc == 'accueil') { ?>class="active" <?php } ?>>
                    <a href="index.php">
                      <span class="glyphicon glyphicon-home"></span>
                      Accueil
                    </a>
                  </li>
                  <li <?php if ($uc == 'gererFrais') { ?>class="active"<?php } ?>>
                    <a href="index.php?uc=gererFrais&action=saisirFrais">
                      <span class="glyphicon glyphicon-pencil"></span>
                      Renseigner la fiche de frais
                    </a>
                  </li>
                  <li <?php if ($uc == 'etatFrais') { ?>class="active"<?php } ?>>
                    <a href="index.php?uc=etatFrais&action=selectionnerMois">
                      <span class="glyphicon glyphicon-list-alt"></span>
                      Afficher mes fiches de frais
                    </a>
                  </li>
                  <li 
                    <?php if ($uc == 'deconnexion') { ?>class="active"<?php } ?>>
                    <a href="index.php?uc=deconnexion&action=demandeDeconnexion">
                      <span class="glyphicon glyphicon-log-out"></span>
                      Déconnexion
                    </a>
                  </li>
                </ul>
              <?php } ?>
              <!----------------------------->

              <!-- Barre de nav comptable -->
              <?php if ($_SESSION['type'] === 'comptable') { ?>
                <ul class="nav nav-pills pull-right" role="tablist">
                  <li <?php if (!$uc || $uc == 'accueil') { ?>class="active1" <?php } ?>>
                    <a href="index.php" class="couleur">
                      <span class="glyphicon glyphicon-home"></span>
                      Accueil
                    </a>
                  </li>
                  <li <?php if ($uc == 'etatFraisComptable') { ?>class="active1"<?php } ?>>
                    <a href="index.php?uc=validerFichesDeFrais&action=selectionnerVisiteur" class="couleur">
                      <span class="fa fa-check"></span>
                      Valider les fiches de frais
                    </a>
                  </li>
                  <li 
                    <?php if ($uc == 'deconnexion') { ?>class="active1"<?php } ?>>
                    <a href="index.php?uc=deconnexion&action=demandeDeconnexion" class="couleur">
                      <span class="glyphicon glyphicon-log-out"></span>
                      Déconnexion
                    </a>
                  </li>
                <?php } ?>
                <!----------------------------->
              </ul>
            </div>
          </div>
        </div>
        <?php
      } else {
        ?>   
        <h1>
          <img src="./images/logo.jpg"
               class="img-responsive center-block"
               alt="Laboratoire Galaxy-Swiss Bourdin"
               title="Laboratoire Galaxy-Swiss Bourdin">
        </h1>
        <?php
      }
