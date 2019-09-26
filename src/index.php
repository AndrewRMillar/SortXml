<?php 
  require('includes/functions.php');
  require_once('includes/logic.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name=”robots” content=”noindex,nofollow”>
  <title>Noverius | Assessment</title> 
  <link rel="shortcut icon" href="https://www.noverius.nl/sites/all/themes/noverius/favicon.ico" type="image/vnd.microsoft.icon">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/stars.css">
  <link rel="stylesheet" href="./css/main.css">
</head>
<body>
  <div class="navbar navbar-custom navbar-static-top affix-top noverius-header">
    <div class="col-xs-6 col-sm-3 col-md-3">
      <a id="logo" href="https://www.noverius.nl/nl" title="Website &amp; Applicatie Ontwikkeling"></a>				
    </div>	
  </div>
  <main role="main" class="container">
    <div class="row">
      <div class="btn-group mt-2 btn-block" role="group" aria-label="Basic example">
        <button class="btn btn-light">sorteer op: </button>
        <a href="index.php<?= $sorteer === "prijs"? "": "?sorteer=prijs" ?>" class="btn <?= $sorteer === "prijs" ? "btn-primary" : "btn-secondary" ?>">Prijs</a>
        <a href="index.php<?= $sorteer === "naam"? "": "?sorteer=naam" ?>" class="btn <?= $sorteer === "naam" ? "btn-primary" : "btn-secondary" ?>">Naam</a>
      </div>
      <?php 
        foreach ($data_array as $items) { 
          // Krijg de individuele assoc's uit het xml array
          echo formatItems($items);
        }    
      ?>
    </div>
  </main>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="./js/main.js"></script>
  </body>
</html>