<?php

// TODO: Make when klicking the buttons for a second time the order is reversed
  
  $path = 'http://demo.travelpulse.nl/sites/default/files/feeds/accofeed.xml';
  $xml_file = file_get_contents($path);
  $ob = simplexml_load_string($xml_file, 'SimpleXMLElement', LIBXML_NOCDATA);
  $g_sort_variable = ""; // made global in sort_by(); "$g_"
  $sorteer = "";

  if($_GET["sorteer"] ?? 0) { // daar heb je um!
    if($_GET["sorteer"] && $_GET["sorteer"] === "prijs") {
      $sorteer = htmlspecialchars($_GET["sorteer"]);
      $g_sort_variable = "price";
    } else if ($_GET["sorteer"] && $_GET["sorteer"] === "naam") {
      $sorteer = htmlspecialchars($_GET["sorteer"]);  
      $g_sort_variable = "accommodation_name";
    }
  }

  // Maak een sorteerbare array uit het simplexml_load_string object
  $sortable = array();
  foreach($ob->item as $node) {
    $sortable[] = $node;
  }

  usort($sortable, 'sort_by');

  // Maak van een SimpleXMLElement Object een php array
  $json = json_encode($sortable);
  $data_array = json_decode($json, true);