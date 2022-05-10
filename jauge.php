<?php
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_odo.php');

// Create a new odometer graph (width=250, height=200 pixels)
$graph = new OdoGraph(850,450);

$graph->title->Set('Chiffre d\'affaire');

// Add drop shadow for graph
$graph->SetShadow(false);
$graph->SetColor('#FFFFF');
$graph->SetMarginColor("white");

// Now we need to create an odometer to add to the graph.
// By default the scale will be 0 to 100
$odo = new Odometer(ODO_HALF);
$odo->SetBorder('white',-9);
//$odo->Set(FF_ARIAL,FS_NORMAL,14);

//$odo->SetCenterAreaWidth(100);
$odo->scale->label->SetColor('white');
//$odo->scale->label->SetFont(FF_ARIAL,FS_BOLD,12);
// Add color indications
$odo->AddIndication(0,90,"red");
$odo->AddIndication(90,95,"orange");
$odo->AddIndication(95,100,"green:0.7");

// Set display value for the odometer
$odo->needle->Set(82);

// Set the size of the non-colored base area to 40% of the radius
$odo->SetCenterAreaWidth(0.55);


//$odo->needle->SetWeight(50);
// Add drop shadow for needle
$odo->needle->SetShadow(false,'white');
$odo->needle->SetFillColor('#2F2D2D');
$odo->needle->SetColor('#2F2D2D');
//$odo->needle->SetWeight(2);

//$odo->needle->SetStyle('NEEDLE_STYLE_MEDIUM_TRIANGLE');
$odo->needle->SetStyle(NEEDLE_STYLE_HUGE_TRIANGLE, NEEDLE_ARROW_LL);
//$odo->SetFont(FF_ARIAL,FS_BOLD,12);
$odo->SetSize(400);
$odo->needle->SetLength("1.1");
//$odo->needle->SetLineWeight(2);
// Add the odometer to the graph
$row2 = new LayoutHor( array($odo) );
$graph->Add($odo);

// ... and finally stroke and stream the image back to the browser
$graph->Stroke();
