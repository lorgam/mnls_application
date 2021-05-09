<?php

class Analyzer
{
  private const API_LOCATION = 'http://api/';

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
      $this->queue[] = $this->parseText($document->textVersion);
    }

    $this->lastId = $document->id;
    $this->saveSession();

    return $this->getMaxWordInQueue();
  }

  public function next() : string
  {
    $this->getSession();

    if (count($this->documents) == 0) $this->documents = $this->getDocuments();

    array_shift($this->queue); // Remove the top of the queue
    $document = array_shift($this->documents);
    $this->queue[] = $this->parseText($document->textVersion);

    $this->lastId = $document->id;
    $this->saveSession();

    return $this->getMaxWordInQueue();
  }

  public function stop() : void
  {
    $this->cleanSession();
  }

  private function getDocuments(int $lastId = null)
  {
    $url = self::API_LOCATION . ($lastId ? "?lastID=$lastId" : '');
    return json_decode( file_get_contents($url) );
  }

  /**
   * Gets a counter of every word used in the text
   */
  private function parseText(string $text) : array
  {
    $wordCount = [];

    $words = explode(' ', $text);
    foreach ($words as $word) {
      if (!isset($wordCount[$word])) $wordCount[$word] = 0;
      $wordCount[$word]++;
    }

    return $wordCount;
  }

  /**
   * Get the word with the most combined count in queue
   */
  private function getMaxWordInQueue() : string
  {
    $max     = 0;
    $maxWord = null;
    $total   = [];

    foreach($this->queue as $wordCount) {
      foreach ($wordCount as $word => $count) {

        if (!isset($total[$word])) $total[$word] = 0;
        $total[$word] += $count;

        if ($total[$word] > $max) {
          $maxWord = $word;
          $max = $total[$word];
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

