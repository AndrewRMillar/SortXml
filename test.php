<?php

$xmlString = <<<EOS
<items>
	<item>
		<minimum_price>14.00</minimum_price>
		<title><![CDATA[Ville degli Ulivi]]></title>
	</item>
	<item>
		<minimum_price>37.00</minimum_price>
		<title><![CDATA[Club Valtur Lacona]]></title>
	</item>
	<item>
		<minimum_price>48.00</minimum_price>
		<title><![CDATA[Airone del Parco & delle Terme]]></title>
	</item>
</items>
EOS;
$xml = simplexml_load_string($xmlString);
// print_r($xml);

$sortable = array();
foreach($xml->items as $node) {
    $sortable[] = $node;
}
print_r($sortable);

// $title = $xml->xpath('/items/item/title');
// $price = $xml->xpath('/items/item/minimum_price');
function sort_trees($t1, $t2) {
    return strcmp($t1['order'], $t2['order']);
}

// usort($trees, 'sort_trees');
// var_dump($trees);