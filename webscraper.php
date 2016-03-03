<?
$url = "https://www.sis.hawaii.edu/uhdad/avail.classes?i=MAN&t=201540";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
echo $curl_scraped_page;
?>