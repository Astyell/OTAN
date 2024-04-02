<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = (__DIR__ . "/../DB/DB.inc.php");
require $chemin;


//require 'lecteurFichier.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;


//creerPvComm(1,1);

//TODO: mettre coeff et changer date ??

/**************/
/* COMMISSION */
/**************/
function creerPvComm($semestre, $annee)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    //recup de la base de donnée
    $db = DB::getInstance();

    //Titre feuille
    $sheet->getStyle('E2:E4')->getFont()->setBold(true);
    $sheet->getStyle('E2:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E2:E4')->getFont()->setSize(18);

    $sheet->setCellValue('E2', 'Semestre ' . $semestre . " - BUT INFO");
    $sheet->setCellValue('E3', $annee . ' - ' . ($annee + 1));//a changer ?
    $sheet->setCellValue('E4', 'COMMISION DU <date>');//a changer ?

    //Nom des colonnes
    $sheet->getStyle('A8:CA8')->getFont()->setBold(true);
    $sheet->setCellValue('A8', 'Rg');
    $sheet->setCellValue('B8', 'Nom');
    $sheet->setCellValue('C8', 'Prénom');
    $sheet->setCellValue('D8', 'Cursus');
    $sheet->setCellValue('E8', 'UEs');
    $sheet->setCellValue('F8', 'Moy');

    //Mettre nom competence et ressource
    $nomColonne = $db->getVueNomColonne($semestre, $annee);

    $ligne = 8;
    $colonne = 'G';

    $comp = null;
    foreach($nomColonne as $nom)
    {
        if($comp != $nom->getCompetence())
        {
            $comp = $nom->getCompetence();
            $sheet->setCellValue($colonne . $ligne, $comp);
            $sheet->setCellValue(++$colonne . $ligne, "Bonus " . $comp);
            $colonne++;
        }
        
        $sheet->setCellValue($colonne . $ligne, $nom->getRessource());
        
        //echo $comp . "  " .$nom->getRessource() . "<br>";
        $colonne++;
    }
    
    //Mettre info étudiants
    $etudiants = $db->getVueCommission($semestre, $annee);
    
    $ligne = 10;
    foreach($etudiants as $etud)
    {
        $colonne = 'B';
        for($compteur = 0; $compteur < 5; $compteur++)
        {
            $sheet->setCellValue('A' . $ligne, ($ligne - 9) . "/" . count($etudiants));
            $sheet->setCellValue($colonne . $ligne, $etud->getInfo($compteur) );
            $colonne++;
        }
        $ligne++;
    }

    //Mettre notes ressources
    $moyRessources = $db->getVueMoyRessource($semestre, $annee);
    $moyCompetences = $db->getVueMoyCompetence($semestre, $annee);
    $bonusEtud = $db->getAllEtuSemWithSem($semestre, $annee);

    $numEtud = $moyRessources[0]->getNetud();
    $ligne = 10;
    foreach($moyRessources as $moyRes)
    {
        if ( !strstr($numEtud, $moyRes->getNetud()) ) 
        {
            $ligne++;
        }

        $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

        for ($col = 1; $col <= $lastCol; $col++) 
        {
            $currentCol = Coordinate::stringFromColumnIndex($col);
            
            if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $moyRes->getRessource() ) ) 
            {
                $sheet->setCellValue($currentCol . $ligne, $moyRes->getMoy());  
            }
        }

        $numEtud = $moyRes->getNetud();

        //mettre les note et bonus de competences
        foreach ($moyCompetences as $moyComp) 
        {
            if( strstr($numEtud, $moyComp->getNetud()) )
            {
                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

                for ($col = 1; $col <= $lastCol; $col++) 
                {
                    $currentCol = Coordinate::stringFromColumnIndex($col);
                    
                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $moyComp->getCompetence() )
                        && !strstr ($sheet->getCell($currentCol . 8)->getValue(), "Bonus" ) ) 
                    {
                        $moyen = $moyComp->getMoy();
                        $sheet->setCellValue($currentCol . $ligne, $moyComp->getMoy());

                        //ajouter couleur
                        switch (true) 
                        {
                            case ($moyen > 10): $couleur = '00FF00'; break;
                            case ($moyen > 8):  $couleur = 'FFFF00'; break;
                            case ($moyen > 0):  $couleur = 'FF0000'; break;
                            default:            $couleur = 'FFFFFF'; break;
                        }
                        $sheet->getStyle($currentCol . $ligne)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
                    }
                }
            }
        }

        foreach ($bonusEtud as $bonus) 
        {
            if( strstr($numEtud, $bonus->getN_Etud()) )
            {
                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

                for ($col = 1; $col <= $lastCol; $col++) 
                {
                    $currentCol = Coordinate::stringFromColumnIndex($col);
                    
                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), "Bonus" ) ) 
                    {
                        $sheet->setCellValue($currentCol . $ligne, $bonus->getBonus());  
                    }
                }
            }
        }
    }

    $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
   
    // Appliquer les bordures à la plage de cellules
    $sheet->getStyle('A8:'. Coordinate::stringFromColumnIndex($lastCol) . (9 + count($etudiants)))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    for ($col = 1; $col <= $lastCol; $col++) 
    {
        $currentCol = Coordinate::stringFromColumnIndex($col);
        $sheet->getColumnDimension($currentCol)->setAutoSize(true);
    }

    //telecharger
    telecharger("PV Commission S" . $semestre . "-" . $annee . ".xlsx", $spreadsheet);//manque mois et année
}


creerPvJury(2, 1);

//TODO:Finir les différents semestres

/**************/
/*    JURY    */
/**************/
function creerPvJury($semestre, $annee)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    //recup de la base de donnée
    $db = DB::getInstance();

    //Titre feuille
    $sheet->getStyle('F2:F5')->getFont()->setBold(true);
    $sheet->getStyle('F2:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('F2:F5')->getFont()->setSize(18);

    $sheet->setCellValue('F2', "BUT " . (int)($semestre/2) . " INFORMATIQUE");
    $sheet->setCellValue('F3', 'Semestre ' . $semestre);
    $sheet->setCellValue('F4', $annee . ' - ' . ($annee + 1));
    $sheet->setCellValue('F5', 'JURY DU <date>');

    //Nom des colonnes
    $sheet->getStyle('A7:CA8')->getFont()->setBold(true);
    $sheet->setCellValue('A8', 'code_nip');
    $sheet->setCellValue('B8', 'Rg');
    $sheet->setCellValue('C8', 'Nom');
    $sheet->setCellValue('D8', 'Prénom');
    $sheet->setCellValue('E8', 'Parcours');
    //$sheet->setCellValue('F8', 'Cursus');

    //ajout info étudiant
    $etudiants = $db->getVueCommission($semestre, $annee);
    $nbEtud = count($etudiants);

    $ligne = 9;
    foreach($etudiants as $etud)
    {
        $numSemestre = 'S' . $semestre;
        if( strstr ( $etud->getCursus(), $numSemestre ) )
        {
            $lastPosition = strrpos($etud->getCursus(), $numSemestre);
            if ($lastPosition !== false) {
                $cursus = substr($etud->getCursus(), 0, $lastPosition + strlen($numSemestre));
            }

            $sheet->setCellValue('A' . $ligne, $etud->getNip());
            $sheet->setCellValue('B' . $ligne, ($ligne - 8) . "/" . count($etudiants));
            $sheet->setCellValue('C' . $ligne, $etud->getNom());
            $sheet->setCellValue('D' . $ligne, $etud->getPrenom());
            $sheet->setCellValue('E' . $ligne, 'A'); //TODO: tkt parcours = A
            $sheet->setCellValue('F' . $ligne, $cursus);

            if($semestre % 2 == 1)
            {
                ajouterUE($sheet, $etud, $semestre, $ligne, 'M');
            }
            else
            {
                ajouterUE($sheet, $etud, $semestre, $ligne, 'G');

            }
            $ligne++;
        } 
    }

    //semestre 1
    if($semestre == 1)
    {
        //nom colonne ancien semestre
        ajouterC($sheet, 1, 'G', 'L');

        //Nom des colonnes de ce semestre
        $nomComp = $db->getAllCompetenceWithSem($semestre, $annee);

        $j = 'M';
        $sheet->setCellValue($j . 8, "UEs");
        $sheet->setCellValue(++$j . 8, "Moy");
        foreach($nomComp as $nom)
        {
            $sheet->setCellValue(++$j . 8, $nom->getId_competence());
        }

        remplirNote($db, $sheet, $semestre, $annee,  $nbEtud);
    }
    
    //semestre 3
    if($semestre == 3)
    {
        //Nom des colonnes de ce semestre
        $nomComp = $db->getAllCompetenceWithSem($semestre, $annee);

        $j = 'M';
        $sheet->setCellValue($j . 8, "UEs");
        $sheet->setCellValue(++$j . 8, "Moy");
        foreach($nomComp as $nom)
        {
            $sheet->setCellValue(++$j . 8, $nom->getId_competence());
        }

        remplirNote($db, $sheet, $semestre, $annee,  $nbEtud);
        
        $nomComp = $db->getAllCompetenceWithSem($semestre - 1, $annee);
        $nomComp2 = $db->getAllCompetenceWithSem($semestre - 2, $annee);

        $j = 'F';
        for($i = 0; $i < count($nomComp); $i++)
        {
            $sheet->setCellValue(++$j . 8, $nomComp2[$i]->getId_competence() . $nomComp[$i]->getId_competence());
        }
        remplirNote($db, $sheet, 2, $annee, $nbEtud, 0);

        ajouterC($sheet, 1, 'G', 'L');
    }

    //semestre 2
    if($semestre == 2)
    {
        $sheet->setCellValue('G8', "RCUEs");
        $sheet->setCellValue('N8', "Moy");

        remplirAdmission($db, $sheet,  $semestre, $annee, $nbEtud, 'O', 'T', 1);
        setPassageAnnee($sheet, 'U', 'G', $nbEtud);
        
        ajouterC($sheet, 1, 'H', 'M');
    }

    //semestre 4
    if($semestre == 4)
    {
        $sheet->setCellValue('G8', "RCUEs");
        $sheet->setCellValue('T8', "Moy");

        remplirAdmission($db, $sheet,  $semestre - 2, $annee, $nbEtud, 'H', 'M', 0);
        remplirAdmission($db, $sheet,  $semestre, $annee, $nbEtud, 'U', 'Z', 1);

        setPassageAnnee($sheet, 'AA', 'G', $nbEtud);
        
        ajouterC($sheet, 1, 'H', 'M');
        ajouterC($sheet, 2, 'N', 'S');
        
        /*//nom colonne ancien semestre
        ajouterC($sheet, 2, 'H', 'M');

        //Nom des colonnes de ce semestre
        $nomComp = $db->getAllCompetenceWithSem($semestre, $annee);
        $nomComp2 = $db->getAllCompetenceWithSem($semestre - 1, $annee);

        $sheet->setCellValue('G8', "RCUEs");
        $sheet->setCellValue('T8', "Moy");

        $j = 'N';
        for($i = 0; $i < count($nomComp); $i++)
        {
            $sheet->setCellValue(++$j . 8, $nomComp2[$i]->getId_competence() . $nomComp[$i]->getId_competence());
        }

        remplirNote($db, $sheet, $semestre, $annee, $nbEtud);

        remplirMoyPair($sheet, $nbEtud, count($nomComp), 'N');

        setPassageAnnee($sheet, 'U', 'G', $nbEtud);*/
    }


    $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
   
    // Appliquer les bordures à la plage de cellules
    $sheet->getStyle('A8:'. Coordinate::stringFromColumnIndex($lastCol) . (9 + count($etudiants)))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    for ($col = 1; $col <= $lastCol; $col++) 
    {
        $currentCol = Coordinate::stringFromColumnIndex($col);
        $sheet->getColumnDimension($currentCol)->setAutoSize(true);
    }

    telecharger("PV Jury S" . $semestre . "-" . $annee . ".xlsx", $spreadsheet);
}

function remplirAdmission($db, $sheet, $semestre, $annee, $nbEtud, $debut, $fin, $num)
{
    $nomComp = $db->getAllCompetenceWithSem($semestre, $annee);
    $nomComp2 = $db->getAllCompetenceWithSem($semestre - 1, $annee);

    $j = $debut;
    for($i = 0; $i < count($nomComp); $i++)
    {
        $sheet->setCellValue($j++ . 8, $nomComp2[$i]->getId_competence() . $nomComp[$i]->getId_competence());
    }
    remplirNote($db, $sheet, $semestre, $annee, $nbEtud);

    remplirMoyPair($sheet, $nbEtud, count($nomComp), Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($debut)-1));
}

function ajouterUE($sheet, $etud, $semestre, $ligne, $colUE)
{
    if($semestre % 2 == 1)
    {
        $sheet->setCellValue($colUE . $ligne, $etud->getUE());
        $sheet->setCellValue(Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($colUE)+1) . $ligne, $etud->getMoy());

        //ajouter couleur
        switch (true) 
        {
            case ( strstr($etud->getUE(), '6/6')):  $couleur = '00FF00'; break;
            case ( strstr($etud->getUE(), '0/6')):  $couleur = 'FF0000'; break;
            default:                                $couleur = 'FFFF00'; break;
        }
        $sheet->getStyle($colUE . $ligne)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
    }
    else
    {
        $sheet->setCellValue($colUE . $ligne, $etud->getUE());

        //ajouter couleur
        switch (true) 
        {
            case ( strstr($etud->getUE(), '6/6')):  $couleur = '00FF00'; break;
            case ( strstr($etud->getUE(), '0/6')):  $couleur = 'FF0000'; break;
            default:                                $couleur = 'FFFF00'; break;
        }
        $sheet->getStyle($colUE . $ligne)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
    }
}

function ajouterC($sheet, $num, $colDebut, $fin)
{
    $sheet->mergeCells($colDebut . '7:' . $fin . '7');
    $sheet->setCellValue($colDebut . 7, "Compétences BUT " . $num );

    for($i = 1; $i < 7; $i++)
    {
        $sheet->setCellValue($colDebut++ . 8, "C" . $i);
    }
}

function remplirMoyPair($sheet, $nbEtud, $nbNote, $start)
{
    for($i=0; $i < $nbEtud; $i++)
    {
        $total = 0;
        $j = $start;
        for($y=0; $y < $nbNote; $y++)
        {
            $total += (int)($sheet->getCell(++$j . ($i + 9))->getValue());
        }
        $sheet->setCellValue($start. ($i + 9), number_format($total/$nbNote, 2));
    }
}

function remplirNote($db, $sheet, $semestre, $annee, $nbEtud, $adm=1)
{
    if($semestre % 2 == 1)
    {
        $noteComp = $db->getAllNoteCompWithSem($semestre, $annee);
        foreach ($noteComp as $note) 
        {
            for($x = 9; $x < $nbEtud + 9; $x++)
            {
                if( $sheet->getCell('A' . $x)->getValue() != null)
                {
                    $tudiant = $db->getEtudiant( "'" . $sheet->getCell('A' . $x)->getValue() . "'" );
                    
                    if( strstr($note->getN_Etud(), $tudiant[0]->getN_Ip() ) )
                    {
                        $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
    
                        for ($col = 1; $col <= $lastCol; $col++) 
                        {
                            $currentCol = Coordinate::stringFromColumnIndex($col);
                            
                            if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $note->getId_competence() ) ) 
                            {
                                $sheet->setCellValue($currentCol . $x, $note->getMoy_UE() ); 
                                //ajouter couleur
                                switch (true) 
                                {
                                    case ($note->getMoy_UE() > 10): $couleur = '00FF00'; break;
                                    case ($note->getMoy_UE() > 8):  $couleur = 'FFFF00'; break;
                                    case ($note->getMoy_UE() > 0):  $couleur = 'FF0000'; break;
                                    default:                        $couleur = 'FFFFFF'; break;
                                }
                                $sheet->getStyle($currentCol . $x)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
                            
                            }
                        }
                    }
                }
            }
        }
    }
    else
    {
        $noteComp = $db->getAllNoteCompWithSem($semestre, $annee);
        $noteComp2 = $db->getAllNoteCompWithSem($semestre - 1, $annee);
        foreach($noteComp as $note)
        {
            foreach($noteComp2 as $note2) 
            {
                if(strstr($note->getN_Etud(), $note2->getN_Etud() ) )
                {
                    $division = ($note->getMoy_UE() + $note2->getMoy_UE())/2;
                    for($x = 9; $x < $nbEtud + 9; $x++)
                    {
                        if( $sheet->getCell('A' . $x)->getValue() != null)
                        {
                            $tudiant = $db->getEtudiant( "'" . $sheet->getCell('A' . $x)->getValue() . "'" );
                            
                            if(strstr($note->getN_Etud(), $tudiant[0]->getN_Ip() ) )
                            {
                                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
            
                                for ($col = 1; $col <= $lastCol; $col++) 
                                {
                                    $currentCol = Coordinate::stringFromColumnIndex($col);
                                    
                                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $note2->getId_competence().$note->getId_competence() ) ) 
                                    {
                                        $sheet->setCellValue($currentCol . $x, $division ); 
                                        //ajouter couleur
                                        switch (true) 
                                        {
                                            case ($division > 10): $couleur = '00FF00'; break;
                                            case ($division > 8):  $couleur = 'FFFF00'; break;
                                            case ($division > 0):  $couleur = 'FF0000'; break;
                                            default:               $couleur = 'FFFFFF'; break;
                                        }
                                        $sheet->getStyle($currentCol . $x)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 

                                        if($adm == 1)
                                        {
                                            setAdmissionComp($note->getMoy_UE(), $note2->getMoy_UE(), $x, Coordinate::stringFromColumnIndex($col - 7), $sheet);
                                        }
                                        else
                                        {
                                            setAdmissionComp($note->getMoy_UE(), $note2->getMoy_UE(), $x, $currentCol, $sheet);
                                        }
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}


function setPassageAnnee($sheet, $colonne, $colUes, $nbEtud)
{
    $sheet->setCellValue($colonne . 7, "Année" ); 
    $sheet->setCellValue($colonne . 8, "Décision" ); 

    for($i = 9; $i < $nbEtud + 9; $i++)
    {
        $ues = $sheet->getCell($colUes . $i)->getValue();
        switch ($ues) 
        {
            case "6/6": $admission = 'ADM'; $couleur = '00FF00'; break;
            case "5/6":
            case "4/6": $admission = 'PASD'; $couleur = 'FFFFFF'; break;
            case "0/6": $admission = 'AJ'; $couleur = 'FF0000'; break;
            default   : $admission = 'NAR'; $couleur = 'FFFF00'; break;
        }

        
        $sheet->setCellValue($colonne . $i, $admission ); 
        $sheet->getStyle($colonne . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
    }
}

function setAdmissionComp($noteSem1, $noteSem2, $ligne, $colonne, $sheet)
{
    $admission = "ADM";
    if($noteSem1 < 10 || $noteSem2 < 10)
    {
        $admission = "CMP";
    }
    if( ($noteSem1 + $noteSem2) /2  < 10)
    {
        $admission = "AJ";
    }

    $sheet->setCellValue($colonne . $ligne, $admission ); 
    //ajouter couleur
    switch ($admission) 
    {
        case "ADM": 
        case "CMP":  $couleur = '00FF00'; break;
        case "AJ" :  $couleur = 'FF0000'; break;
        default:     $couleur = 'FFFFFF'; break;
    }
    $sheet->getStyle($colonne . $ligne)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 

}



function telecharger($nomfichier, $spreadsheet)
{
    //Téléchargement fichier
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nomfichier.'"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
}

