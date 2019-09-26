<?php

/**
 * File with helper functions to be included into the index file of the app
 * 
 * PHP version 5
 * 
 * @category Helper_File
 * @package  SortXML
 * @author   Andrew Millar <andrew@millar.dev>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     https://github.com/Sl4rtyb4rtf4st/SortXml
 * @file     functions.php 
 */


/**
 * Function to create a bootstrap card with the accomodation information 
 * provided by the parameter
 * 
 * @param array $item An associative array with the details of the accomodation
 * 
 * @return string Bootstrap card with the accomodation information filed in
 */
function formatItems($item) 
{
    return "
    <div class=\"card my-2\">\n\t
      <img class=\"card-img\" src=\"{$item["img_small"]}\">\n\t
      <div class=\"card-body\">\n\t\t
        <h5 class=\"card-title\">" . htmlspecialchars($item["title"]) . "</h5>\n\t\t
        <div class=\"text-muted\">\n\t\t\t
          <span>" . htmlspecialchars($item["holiday_type"]) . "</span>\n\t\t
        </div>\n\t\t
        <p class=\"card-text\">" . htmlspecialchars($item["description"]) . "</p>\n\t\t
        <p class=\"card-text\">" . htmlspecialchars($item["city_of_destination"]) . " aan de " . htmlspecialchars($item["continent_of_destination"]) . " in " . htmlspecialchars($item["country_of_destination"]) . "</p>\n\t\t
        <P class\"float-right\">&euro;" . htmlspecialchars($item["minimum_price"]) . "</P>\n\t\t
        <a href=\"" . htmlspecialchars($item["link"]) . "\" class=\"btn btn-primary btn-block\">Boek deze vakantie</a>\n\t\t
      </div>\n\t
      <div class=\"card-footer text-muted\">\n\t
        <div class=\"float-left\">Vertrek datum - " . formatDate($item["departure_date"]) . "</div>\n\t\t
        <div class=\"float-right stars\">\n\t\t\t
          <div class=\"stars-outer align-self-end\">\n\t\t\t\t
            <div class=\"stars-inner\" data-rating=\"" . htmlspecialchars($item["stars"]) . "\" name=\"rating\"></div>\n\t\t\t
          </div>\n\t\t
        </div>\n\t
      </div>\n
    </div>\n";
}


/**
 * Function to parse a given date into a well date in the given locale
 * 
 * @param string $str A datestring in the format 20190501
 * @param string $loc A locale string in the format 'nl NL'
 * 
 * @return string A formated string representation of the date, 'woensdag 1 mei 2019'
 */
function formatDate($str, $loc = 'nl NL') 
{
    $date = new DateTime($str);
    $date = explode(", ", $date->format('d, m, Y'));
    setlocale(LC_ALL, $loc);
    return strftime("%A %e %B %Y", mktime(0, 0, 0, $date[0], $date[1], $date[2]));
}


/**
 * Function to sort on the basis
 * 
 * @param object $a I don't really remomeber what this variable is
 * @param object $b simmilar to the first param
 * 
 * @return object The sorted objects are returned
 */
function sortBy($a, $b) {
    global $g_sort_variable; // niet ideaal
    $retval = strnatcmp($a->{$g_sort_variable}, $b->{$g_sort_variable});
    return $retval;
}