<?php

use Goutte-master\Goutte\Client;

$client = new Client();

// Go to the symfony.com website
$crawler = $client->request('GET', 'http://www.symfony.com/blog/');


// Get the latest post in this category and display the titles
$crawler->filter('h2.post > a')->each(function ($node) {
    print $node->text()."\n";
});
?>