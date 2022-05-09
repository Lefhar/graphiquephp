<?php
include("Database.php");
$db = Database::connect();
setlocale(LC_ALL, 'fr_FR', 'fra_FRA');

$datedebut ='2018-01-01';
$dateDepartTimestamp = strtotime($datedebut);

$req = $db->prepare('SELECT date, ca FROM `ca`  where Date <= NOW() and Date >= Date_add(Now(),interval - 12 month) ORDER by date');
$req->execute();
$TabCa = $req->fetchAll();
$TabMoyenne = array();
//var_dump($TabCa);
foreach ($TabCa as $row){

    //à tester SELECT  avg(ca)
    //FROM ca
    //where Date <= "2022-12-01" and Date >= Date_add("2022-12-01",interval - 12 month)
    $req = $db->prepare(' SELECT  avg(ca) as moyenne
    FROM ca
    where Date <= ? and Date >= Date_add(?,interval - 12 month)');

//    echo ' SELECT  avg(ca) as moyenne
//    FROM ca
//    where Date <= '.$row['date'].' and Date >= Date_add('.$row['date'].',interval - 12 month)';

    $req->execute(array($row['date'],$row['date']));
    $moyenne = $req->fetch();
    $TabMoyenne[]= $moyenne['moyenne'];

}
 foreach ($TabCa as $row){
             $tabca[]=  $row['ca'];
              }


// content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_bar.php');

$l1datay = $TabMoyenne;
$l2datay = $tabca;
foreach ($TabCa as $row){
    $tabMonth[]= utf8_encode(ucfirst(strftime('%B %Y', strtotime($row['date']))));
}
$datax=$tabMonth;

// Create the graph.
$graph = new Graph(1500,400,'auto');
$graph->SetScale('textlin');

$graph->Set90AndMargin(150,20,50,30);
$graph->SetShadow();
$graph->yaxis->scale->SetGrace(20);
$graph->yaxis->Hide();
// Create the linear error plot
$l1plot=new LinePlot($l1datay);
$l1plot->SetColor('red');
$l1plot->SetWeight(2);
$l1plot->SetLegend('chiffre d\'affaire 12 mois précédent');

// Create the bar plot
$bplot = new BarPlot($l2datay);
$bplot->SetFillColor('orange');
$bplot->SetLegend('Chiffre d\'affaire');

// Add the plots to t'he graph
$graph->Add($bplot);
$graph->Add($l1plot);

$graph->title->Set('Graphique chiffre d\'affaire');
//$graph->xaxis->title->Set('X-title');
//$graph->yaxis->title->Set('Y-title');

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->SetTickLabels($datax);
//$graph->xaxis->SetTextTickInterval(2);

// Display the graph
$graph->Stroke();
