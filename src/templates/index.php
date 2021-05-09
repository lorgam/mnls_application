<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MNLS Application</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <script type="text/javascript" src="assets/js/scripts.js"></script>
</head>

<body>
  <div class="content">
    <h1>MNLS Application</h1>

    <div class="info">The server is making the petition to <?= $API_LOCATION ?></div>

    <form id="config-form" action="#">
      <input type="hidden" name="action" value="getWordCount">

      <div class="nm-container">
        <div>
          <label for="n">Amount of documents to analyze</label>
          <input type="text" name="n" value="3">
        </div>
        <div>
          <label for="m">Number of reports on screen</label>
          <input type="text" name="m" value="5">
        </div>
      </div>

      <div class="controls">
        <input class="control" type="button" value="Start" id="start">
        <input class="control" type="button" value="Stop" id="stop" disabled>
        <input class="control" type="button" value="Pause" id="pause" disabled>
        <input class="control" type="button" value="Next" id="next" disabled>
        <input class="control" type="button" value="Resume" id="resume" disabled>
      </div>
    </form>

    <div id="visor">
    </div>

  </div>
</body>
</html>
