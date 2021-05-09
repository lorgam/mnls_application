<?php

class Analyzer
{
  private const API_LOCATION = 'http://api/';

  private $documents;
  private $queue;

  /**
   * Gets the most used words in a combination of documents
   */
  public function getFrequency(array $params) : string
  {
    $n               = $params['n'];
    $this->documents = $this->getDocuments();
    $this->queue     = [];

    for ($i = 0; $i < $n; ++$i) { // Read the first items to fill the queue that we are going to use to calculate the most used word in the documents
      $document = array_shift($this->documents);
      $this->queue[] = $this->parseText($document->textVersion);
    }

    $word = $this->getMaxWordInQueue();

    array_shift($this->queue); // Remove the top of the queue
    $document = array_shift($this->documents);
    $this->queue[] = $this->parseText($document->textVersion);

    return $word;
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

  private function saveSession()
  {
    $_SESSION['queue']     = $this->queue;
    $_SESSION['documents'] = $this->documents;
  }

  private function getSession()
  {
    $this->queue     = $_SESSION['queue'];
    $this->documents = $_SESSION['documents'];
  }
}

