<?php 
echo 'a';
$file = file_get_contents('https://iedes.verisk.com/des/');

file_put_contents('./results_test.txt', $file);
