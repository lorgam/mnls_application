<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MNLS Application</title>
  <link rel="stylesheet" href="https://localhost/assets/css/styles.css">
  <script type="text/javascript" src="https://localhost/assets/js/scripts.js"></script>
</head>

<body>
  <div class="content">
    <h1>MNLS Application</h1>

    <form id="config-form" action="#">
      <input type="hidden" name="action" value="getWordCount">

      <div class="nm-container">
        <div>
          <label for="n">Value for n</label>
          <input type="text" name="n" value="3">
        </div>
        <div>
          <label for="m">Value for m</label>
          <input type="text" name="m" value="5">
        </div>
      </div>

      <div class="controls">
        <input type="submit" value="Start">
        <input class="control" type="button" value="Stop">
        <input class="control" type="button" value="Pause">
        <input class="control" type="button" value="Next">
      </div>
    </form>

    <div id="visor">
    </div>

  </div>
</body>
</html>
