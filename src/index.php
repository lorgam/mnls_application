<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once 'classes/class.controller.php';

  $controller = new Controller();
  echo json_encode($controller->processPostPetition());
} else {
  include_once 'templates/index.php';
}


