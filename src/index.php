<?php

require_once 'classes/class.analyzer.php';

$analyzer = new Analyzer();
$res = $analyzer->getFrequency([
  'n' => 3,
  'm' => 5
]);

require_once 'templates/index.php';

