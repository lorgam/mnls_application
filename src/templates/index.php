<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MNLS Application</title>
  <link rel="stylesheet" href="http://localhost/assets/css/styles.css">
  <script type="text/javascript" src="http://localhost/assets/js/scripts.js"></script>
</head>

<body>
  <div class="content">
    <h1>MNLS Application</h1>

    <form id="config-form" action="#">
      <div class="nm-container">
        <label for="n">Value for n</label>
        <input type="text" name="n" value="3">
        <label for="m">Value for m</label>
        <input type="text" name="m" value="5">
        <input type="hidden" name="action" value="getWordCount">
        <input type="hidden" name="method" value="start">
        <input type="submit" value="Submit form">
      </div>
    </form>

    <div id="visor">
    </div>

  </div>
</body>
</html>
