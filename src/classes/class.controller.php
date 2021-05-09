<?php
require_once 'class.analyzer.php';

class Controller
{
  public function processPostPetition() : array
  {
    if (!isset($_POST['action']) || $_POST['action'] != 'getWordCount') return $this->errorMsg('action parameter not correctly configured');
    if (!isset($_POST['method'])) return $this->errorMsg('Missing method parameter');

    $method = trim($_POST['method']);
    $res = ['success' => true, 'method' => $method];

    switch ($method) {
      case 'start':
        if (!isset($_POST['n']) || !is_numeric($_POST['n'])) return $this->errorMsg('Incorrect value for n');
        if (!isset($_POST['m']) || !is_numeric($_POST['m'])) return $this->errorMsg('Incorrect value for m');
        $n = intval($_POST['n']);
        $m = intval($_POST['m']);
        if ($n <= 0) return $this->errorMsg('The values for n must be greater than 0');
        if ($m <= 0) return $this->errorMsg('The values for m must be greater than 0');

        $res['n'] = $n;

        $analyzer = new Analyzer();
        $word = $analyzer->getFrequency([
          'n' => $n,
          'm' => $m,
        ]);

        $res['word'] = $word;
        break;

      default :
        if (!isset($_POST['method'])) return $this->errorMsg('method parameter value not valid');
    }
    // If everything has gone right
    return $res;
  }

  private function errorMsg(string $error)
  {
    return [
      'success' => false,
      'message' => $error
    ];
  }
}
