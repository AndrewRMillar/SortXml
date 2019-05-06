<?php

function formatItems($item) {
  // Stop de data uit het item assoc in een bootstrap card
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
              <div class=\"float-right stars\">
                <div class=\"stars-outer align-self-end\">
                  <div class=\"stars-inner\" data-rating=\"" . htmlspecialchars($item["stars"]) . "\" name=\"rating\"></div>
                </div>
              </div>
            </div>
          </div>";
}

function formatDate($str) {
  // Maak van een 20190501 "woendsdag 1 mei 2019"
  $date = new DateTime($str);
  $date = explode(", ", $date->format('d, m, Y'));
  // Set de locale naar Nederlands
  setlocale(LC_ALL, 'nl_NL');
  return strftime("%A %e %B %Y", mktime(0, 0, 0, $date[0], $date[1], $date[2]));
}

function sort_by($a, $b) {
  // Sorteer op basis van de sorteer variabele
  global $g_sort_variable; // niet ideaal
  $retval = strnatcmp($a->{$g_sort_variable}, $b->{$g_sort_variable});
  return $retval;
}