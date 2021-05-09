<?php

class Analyzer
{
  public static $API_LOCATION;
  private $documents;
  private $queue;
  private $lastId;

  /**
   * Gets the most used words in a combination of documents
   */
  public function start(array $params) : string
  {
    $this->cleanSession();

    $n               = $params['n'];
    $this->documents = $this->getDocuments();
    $this->queue     = [];

    for ($i = 0; $i < $n; ++$i) { // Read the first items to fill the queue that we are going to use to calculate the most used word in the documents
      $document = array_shift($this->documents);
      $this->lastId = $document->id;
      $this->queue[] = $this->parseText($document->textVersion);

    }

    $this->saveSession();

    return $this->getMaxWordInQueue($this->queue);
  }

  public function next() : string
  {
    $this->getSession();

    if (count($this->documents) == 0) $this->documents = $this->getDocuments();

    array_shift($this->queue); // Remove the top of the queue
    $document = array_shift($this->documents);
    $this->lastId = $document->id;
    $this->queue[] = $this->parseText($document->textVersion);

    $this->saveSession();

    return $this->getMaxWordInQueue($this->queue);
  }

  public function stop() : void
  {
    $this->cleanSession();
  }

  private function getDocuments(int $lastId = null)
  {
    $url = self::$API_LOCATION . ($lastId ? "?lastID=$lastId" : '');
    $contents =  json_decode( file_get_contents($url) );
    return $contents;
  }

  /**
   * Gets a counter of every word used in the text
   */
  private function parseText(string $text) : array
  {
    $wordCount = [];

    $words = explode(' ', $text);
    foreach ($words as $word) {
      if (!isset($wordCount[$word])) $wordCount[$word] = 1;
      else $wordCount[$word]++;
    }

    return $wordCount;
  }

  /**
   * Get the word with the most combined count in queue
   */
  private function getMaxWordInQueue(array $queue) : string
  {
    $max     = 0;
    $maxWord = '';
    $total   = [];
    $value   = 0;

    foreach($queue as $wordCount) {
      foreach ($wordCount as $word => $count) {

        if (isset($total[$word])) $value = $total[$word];
        else $value = 0;

        $value += $count;
        $total[$word] = $value;

        if ($value > $max) {
          $maxWord = $word;
          $max = $value;
        }

      }
    }

    return $maxWord;
  }

  private function saveSession() : void
  {
    $_SESSION['queue']     = $this->queue;
    $_SESSION['documents'] = $this->documents;
    $_SESSION['lastId']    = $this->lastId;
  }

  private function getSession() : void
  {
    $this->queue     = $_SESSION['queue'];
    $this->documents = $_SESSION['documents'];
    $this->lastId    = $_SESSION['lastId'];
  }

  private function cleanSession() : void
  {
    unset($_SESSION['queue']);
    unset($_SESSION['documents']);
    unset($_SESSION['lastId']);
  }
}

