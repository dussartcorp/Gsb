
<?php

// Connexion à la BDD
$bddname = 'gsb_frais';
$hostname = 'localhost';
$username = 'userGsb';
$password = 'secret';
$db = mysqli_connect($hostname, $username, $password, $bddname);
// Appel de la librairie FPDF
require("fpdf.php");

// Création de la class PDF
class PDF extends FPDF {

    // En-tête
    function Header() {

        // Positionnement à 1,5 cm du bas
        $this->SetY(50);
        // Logo
        $this->Image('../images/logo.jpg', 75, 6, 60);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(40);
        // Saut de ligne
        $this->Ln(20);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Titre
$pdf->SetY(55);
$pdf->SetX(50);
$pdf->Cell(110, 10, 'REMBOURSEMENT DE FRAIS ENGAGES', 1, 0, 'C');

$unId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$unMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);

$req = "SELECT id, CONCAT(nom, ' ', prenom)as nomvisiteur, mois FROM visiteur inner join lignefraisforfait on lignefraisforfait.idvisiteur=visiteur.id WHERE id='$unId' and mois='$unMois'";
$rep = mysqli_query($db, $req);
$row = mysqli_fetch_array($rep);
// Infos de la commande calées à gauche
$pdf->Text(15, 78, 'Visiteur : ' . $row['id']);
$pdf->Text(50, 78, 'Nom : ' . $row['nomvisiteur']);
$pdf->Text(15, 88, 'Mois : ' . $row['mois']);

// Position de l'entête à 10mm des infos (48 + 10)
$position_entete = 58;

function entete_table($position_entete) {
    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond
    $pdf->SetFillColor(221); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte
    $pdf->SetY($position_entete);
    $pdf->SetY(95);
    $pdf->SetX(15);
    $pdf->Cell(45, 10, 'Frais Forfaitaires', 1, 0, 'L', 1);
    $pdf->SetX(60); // 8 + 96
    $pdf->Cell(45, 10, 'Quantite', 1, 0, 'C', 1);
    $pdf->SetX(105); // 104 + 10
    $pdf->Cell(45, 10, 'Montant unitaire', 1, 0, 'C', 1);
    $pdf->SetX(150); // 104 + 10
    $pdf->Cell(45, 10, 'Total', 1, 0, 'C', 1);
    $pdf->Ln(); // Retour à la ligne
}

entete_table($position_entete);

// Liste des détails
$position_detail = 105; // Position à 8mm de l'entête

$req2 = "SELECT libelle, montant, quantite, (montant*quantite) as total FROM fraisforfait inner join lignefraisforfait on lignefraisforfait.idfraisforfait = fraisforfait.id WHERE idvisiteur='$unId' and mois='$unMois'";
$rep2 = mysqli_query($db, $req2);
$total = 0;
while ($row2 = mysqli_fetch_array($rep2)) {
    $pdf->SetY($position_detail);
    $pdf->SetX(15);
    $pdf->MultiCell(45, 10, utf8_decode($row2['libelle']), 1, 'L');
    $pdf->SetY($position_detail);
    $pdf->SetX(60);
    $pdf->MultiCell(45, 10, $row2['quantite'], 1, 'C');
    $pdf->SetY($position_detail);
    $pdf->SetX(105);
    $pdf->MultiCell(45, 10, $row2['montant'], 1, 'C');
    $pdf->SetY($position_detail);
    $pdf->SetX(150);
    $pdf->MultiCell(45, 10, $row2['total'], 1, 'C');
    $position_detail += 10;
    $total += $row2['total'];
}
$pdf->SetY(155);
$pdf->SetX(75);
$pdf->Cell(60, 10, 'AUTRES FRAIS', 1, 0, 'C');

function entete_table2() {
    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond
    $pdf->SetFillColor(221); // Couleur des filets
    $pdf->SetTextColor(0); // Couleur du texte
    $pdf->SetY(170);
    $pdf->SetX(37);
    $pdf->Cell(45, 10, 'Date', 1, 0, 'C', 1);
    $pdf->SetX(82); // 8 + 96
    $pdf->Cell(45, 10, 'Libelle', 1, 0, 'C', 1);
    $pdf->SetX(127); // 104 + 10
    $pdf->Cell(45, 10, 'Montant', 1, 0, 'C', 1);
    $pdf->Ln(); // Retour à la ligne
}

entete_table2();

// Liste des détails
$position_detail2 = 180; // Position à 8mm de l'entête

$req3 = "SELECT libelle, montant, date FROM lignefraishorsforfait WHERE idvisiteur='$unId' and mois='$unMois'";
$rep3 = mysqli_query($db, $req3);
$montant = 0;
while ($row3 = mysqli_fetch_array($rep3)) {
    $pdf->SetY($position_detail2);
    $pdf->SetX(37);
    $pdf->MultiCell(45, 10, utf8_decode($row3['date']), 1, 'C');
    $pdf->SetY($position_detail2);
    $pdf->SetX(82);
    $pdf->MultiCell(45, 10, substr(utf8_decode($row3['libelle']), 0, 20), 1, 'C');
    $pdf->SetY($position_detail2);
    $pdf->SetX(127);
    $pdf->MultiCell(45, 10, $row3['montant'], 1, 'C');
    $montant += $row3['montant'];

    $position_detail2 += 10;
}
$today = date("d M Y");
$pdf->SetY($position_detail2+17);
$pdf->SetX(125);
$pdf->Cell(40, 10, 'TOTAL ' . $unMois, 1, 0, 'C');
$pdf->SetX(165);
$pdf->Cell(30, 10, $total + $montant, 1, 0, 'C');
$pdf->Ln(12); // Retour à la ligne
$pdf->SetX(127);
$pdf->Cell(50, 10, utf8_decode('Fait à Toulon le ') . $today, 0, 0, 'C');
$pdf->Ln(8); // Retour à la ligne
$pdf->SetX(127);
$pdf->Cell(37, 10, utf8_decode('Vu l\'agent comptable '), 0, 0, 'C');
$pdf->Ln(13); // Retour à la ligne
$pdf->SetX(125);
$pdf->Image('../images/signatureComptable.jpg');

$pdf->Output();
?>
