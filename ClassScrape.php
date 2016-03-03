<?php

$curl = curl_init('https://www.sis.hawaii.edu/uhdad/avail.classes?i=MAN&t=201540');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
$html = curl_exec($curl);
curl_close($curl);

if (!$html) {
    die("something's wrong!");
}

//var_dump(strlen($data));

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

$scores = array();

$tableRows = $xpath->query('//body/');
echo $tableRows;
echo "blah";

?>
