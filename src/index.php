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
$path = 'http://millar-knorr.nl/test/xml/accofeed.xml';
$xml_file = file_get_contents($path);
$ob = simplexml_load_string($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);

/**** 
 * Start sort
 * So this works but only the title or the price is ordered 
 * the rest of the simplexml array seems to be left out
 ****/

$naam = $ob->xpath('/items/item/accommodation_name');
$price = $ob->xpath('/items/item/minimum_price');
function sort_xml($t1, $t2) {
    return strcmp($t1, $t2);
} 
/****
 * End sort
 ****/

$sorteer = "";
if( $_GET["sorteer"] === "prijs") {
  $sorteer = htmlspecialchars($_GET["sorteer"]);
  usort($price, 'sort_xml');
  // var_dump($price);
} else if ($_GET["sorteer"] === "naam") {
  $sorteer = htmlspecialchars($_GET["sorteer"]);  
  usort($naam, 'sort_xml');
  // var_dump($name);
}
/****
 * Alt Sort
 ****/
$sortable = array();
foreach($ob->item as $node) {
  $sortable[] = $node;
}

function sort_by($a, $b) {
  // sort by price
  $retval = strnatcmp($a->accommodation_name, $b->accommodation_name);
  return $retval;
}

usort($sortable, 'sort_by');

print_r($sortable);
/****
 * End alt sort
 ****/

$json = json_encode($ob);
$data_array = json_decode($json, true);
$catagories = ["category", "description", "img_small", "link", "minimum_price", "departure_date", "title", "accommodation_name", "city_of_destination", "continent_of_destination", "country_of_destination", "accommodation_type", "holiday_type", "region_of_destination", "stars"];

function formatItems($item) {
  // Haal de data uit het item zodat het kan worden "behandeld"
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
            <a href=\"" . htmlspecialchars($item["link"]) . "\" class=\"btn btn-outline-primary btn-block\">link</a>
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
  // Maak van een 20190501 datum een "wendsday 1 ste mei 2019"
  $date = new DateTime($str);
  // $year = ;
  setlocale(LC_ALL, 'nl_NL');
  strftime("%A %d %B %Y", mktime(0, 0, 0, 12, 22, 1978));
  return $date->format('l jS M Y');
  // gebruik preg_replace() om de datum Nederlands te maken
  // Zou ook moeten kunnen door de locale te veranderen
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
      <a href="/sandbox/src/index.php?sorteer=prijs" class="btn <?= $_GET["sorteer"] === "prijs" ? "btn-primary" : "btn-secondary" ?>">Prijs</a>
      <a href="/sandbox/src/index.php?sorteer=naam" class="btn <?= $_GET["sorteer"] === "naam" ? "btn-primary" : "btn-secondary" ?>">Naam</a>
    </div>
    <?php 
      foreach ($data_array as $items) { 
        // Krijg de eerste array met items uit het json object
        foreach ($items as $item) {
          // Krijg de individuele item assoc uit de items array en echo het resultaat van formatItems()
          echo formatItems($item);
        }
      }    
    ?>
  </div>
</main>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="./js/main.js"></script>
</body>
</html>