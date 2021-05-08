<?php

class Analyzer
{
  private const API_LOCATION = 'http://api/';

  /**
   * Gets the most used words in a combination of documents
   */
  public function getFrequency(array $params) : array
  {
    $n         = $params['n'];
    $m         = $params['m'];
    $documents = json_decode( file_get_contents(self::API_LOCATION) );
    $queue     = [];
    $maxWords  = [];

    for ($i = 0; $i < $n; ++$i) { // Read the first items to fill the queue that we are going to use to calculate the most used word in the documents
      $document = $documents[$i];

      $queue[] = $this->parseText($document->textVersion);
    }

    for ($i = $n; $i < $m + $n; ++$i) {
      $word = $this->getMaxWordInQueue($queue);
      $maxWords[] = $word;

      array_shift($queue); // Remove the top of the queue
      $document = $documents[$i];
      $queue[] = $this->parseText($document->textVersion);
    }

    return $maxWords;
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
  private function getMaxWordInQueue(array $queue) : string
  {
    $max     = 0;
    $maxWord = null;
    $total   = [];

    foreach($queue as $wordCount) {
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
}

