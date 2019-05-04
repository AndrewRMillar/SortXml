<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<?php 
$path = 'http://millar-knorr.nl/test/xml/accofeed.xml';
$xml_file = file_get_contents($path);
$ob = simplexml_load_string($xml_file);
$json = json_encode($ob);
$data_array = json_decode($json, true);

print_r($data_array);
// print_r($json);
// print_r($ob);
// print_r($xml_file);
echo "<br>";
echo "<br>";
// var_dump($data_array);

// print_r($json); // This results in loss of data, link/img data amoung




?>

</body>
</html>