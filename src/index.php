<?php
session_start();

require_once 'classes/class.analyzer.php';
require_once 'classes/class.controller.php';

const DEFAULT_LOCATION = 'http://localhost:8888/';
$API_LOCATION = getenv('API_LOCATION');
$API_LOCATION = ($API_LOCATION ? $API_LOCATION : DEFAULT_LOCATION);
Analyzer::$API_LOCATION = $API_LOCATION;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $controller = new Controller();
  echo json_encode($controller->processPostPetition());
} else {
  include_once 'templates/index.php';
}

