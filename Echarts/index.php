<?php

use Hisune\EchartsPHP\Doc\IDE\XAxis;
use Hisune\EchartsPHP\ECharts;

require './vendor/autoload.php';
$chart = new ECharts();
$xAxis = new XAxis();
$xAxis->type = 'category';
$xAxis->data = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$chart->addXAxis($xAxis);

echo $chart->render('ss');