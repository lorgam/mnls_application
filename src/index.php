<?php
session_start();

require_once 'classes/class.analyzer.php';

if (isset($_POST['action']) && $_POST['action'] == 'getWordCount') {
  $res = [];
  echo json_encode($res);
} else {
  include_once 'templates/index.php';
}

