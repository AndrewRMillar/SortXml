<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Noverius</title> 
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/stars.css">
  <link rel="stylesheet" href="./css/main.css">
</head>
<body>
<?php 
$path = 'http://demo.travelpulse.nl/sites/default/files/feeds/accofeed.xml';
$xml_file = file_get_contents($path);
$ob = simplexml_load_string($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);
$sort_variable = "";

// Sorteer start, maak er misschien nog een functie van, Class is over the top
$sorteer = "";
if($_GET["sorteer"] ?? 0) {
  if($_GET["sorteer"] && $_GET["sorteer"] === "prijs") {
    $sorteer = htmlspecialchars($_GET["sorteer"]);
    $sort_variable = "price";
  } else if ($_GET["sorteer"] && $_GET["sorteer"] === "naam") {
    $sorteer = htmlspecialchars($_GET["sorteer"]);  
    $sort_variable = "accommodation_name";
  }
}

// Maak een sorteerbare array uit het simplexml_load_string object
$sortable = array();
foreach($ob->item as $node) {
  $sortable[] = $node;
}

function sort_by($a, $b) {
  // sort by price or accommodation_name
  global $sort_variable;
  $retval = strnatcmp($a->{$sort_variable}, $b->{$sort_variable});
  return $retval;
}

usort($sortable, 'sort_by');

$json = json_encode($sortable);
$data_array = json_decode($json, true);

function formatItems($item) {
  // Stop de data uit het item in een bootstrap card
  // Dat htmlspecialchars gebeuren kan ongetwijfelt wat meer DRY
  return "<div class=\"card my-2\">
          <img class=\"card-img\" src=\"{$item["img_small"]}\">
          <div class=\"card-body\">
            <h5 class=\"card-title\">" . htmlspecialchars($item["title"]) . "</h5>
            <div class=\"text-muted\">
              <span>" . htmlspecialchars($item["holiday_type"]) . "</span>
            </div>
            <p class=\"card-text\">" . htmlspecialchars($item["description"]) . "</p>
            <p class=\"card-text\">" . htmlspecialchars($item["city_of_destination"]) . " aan de " . htmlspecialchars($item["continent_of_destination"]) . " in " . htmlspecialchars($item["country_of_destination"]) . "</p>
            <P class\"float-right\">&euro;" . htmlspecialchars($item["minimum_price"]) . "</P>
            <a href=\"" . htmlspecialchars($item["link"]) . "\" class=\"btn btn-primary btn-block\">Boek deze vakantie</a>
          </div>
          <div class=\"card-footer text-muted\">
            <div class=\"float-left\">Vertrek datum - " . formatDate($item["departure_date"]) . "</div>
            <div class=\"float-right\">
              <div class=\"stars-outer align-self-end\">
                <div class=\"stars-inner\" data-rating=\"" . htmlspecialchars($item["stars"]) . "\" name=\"rating\"></div>
              </div>
            </div>
          </div>
        </div>";
}

function formatDate($str) {
  // Maak van een 20190501 datum een "woendsdag 1ste mei 2019"
  $date = new DateTime($str);
  $date = explode(", ", $date->format('d, m, Y'));
  // Set de locale Nederlands
  setlocale(LC_ALL, 'nl_NL');
  return strftime("%A %e %B %Y", mktime(0, 0, 0, $date[0], $date[1], $date[2]));
}
?>

<div class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar noverius-header">
  <div class="col-xs-6 col-sm-3 col-md-3">
    <a id="logo" href="https://www.noverius.nl/nl" title="Website &amp; Applicatie Ontwikkeling"></a>				
  </div>	
</div>
<main role="main" class="container">
  <div class="row">
    <div class="btn-group mt-3" role="group" aria-label="Basic example">
      <button class="btn btn-light">sorteer op: </button>
      <a href="/sandbox/src/index.php<?= $sorteer === "prijs"? "": "?sorteer=prijs" ?>" class="btn <?= $_GET["sorteer"] === "prijs" ? "btn-primary" : "btn-secondary" ?>">Prijs</a>
      <a href="/sandbox/src/index.php<?= $sorteer === "naam"? "": "?sorteer=naam" ?>" class="btn <?= $_GET["sorteer"] === "naam" ? "btn-primary" : "btn-secondary" ?>">Naam</a>
    </div>
    <?php 
      foreach ($data_array as $items) { 
        // Krijg de eerste array met items uit het json object
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