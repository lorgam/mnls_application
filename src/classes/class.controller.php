<?php

class Controller
{
  public function processPostPetition() : array
  {
    if (!isset($_POST['action']) || $_POST['action'] != 'getWordCount') return $this->errorMsg('action parameter not correctly configured');
    if (!isset($_POST['method'])) return $this->errorMsg('Missing method parameter');

    $method = trim($_POST['method']);
    $func = "process_$method";

    if (method_exists($this, $func)) return call_user_func([$this, $func]);
    else return $this->errorMsg('method parameter value not valid');
  }

  private function process_start() : array
  {
    $res = ['success' => true, 'method' => 'start'];
    if (!isset($_POST['n']) || !is_numeric($_POST['n'])) return $this->errorMsg('Incorrect value for n');
    if (!isset($_POST['m']) || !is_numeric($_POST['m'])) return $this->errorMsg('Incorrect value for m');
    if (!isset($_POST['minimum_length']) || !is_numeric($_POST['minimum_length'])) return $this->errorMsg('Incorrect value for minimum_length');
    $n = intval($_POST['n']);
    $m = intval($_POST['m']);
    $minimum_length = intval($_POST['minimum_length']);
    if ($n <= 0) return $this->errorMsg('The value for n must be greater than 0');
    if ($m <= 0) return $this->errorMsg('The value for m must be greater than 0');
    if ($minimum_length <= 0) return $this->errorMsg('The value for minimum_length must be greater than 0');

    $res['n'] = $n;
    $res['m'] = $m;

    $analyzer = new Analyzer();
    $word = $analyzer->start([
      'n' => $n,
      'm' => $m,
      'minimum_length' => $minimum_length,
    ]);

    $res['word'] = $word;
    return $res;
  }

  private function process_stop() : array
  {
    $res = ['success' => true, 'method' => 'stop'];

    $analyzer = new Analyzer();
    $analyzer->stop();

    return $res;
  }

  private function process_next() : array
  {
    $res = ['success' => true, 'method' => 'next'];

    $analyzer = new Analyzer();
    $word = $analyzer->next();

    $res['word'] = $word;
    return $res;
  }

  private function errorMsg(string $error) : array
  {
    return [
      'success' => false,
      'message' => $error
    ];
  }
}
