<?php

    $filename = "proxies-" . date('Y-m-d-H-i-s', time()) . ".txt";
    
    // masukan url web ke source.txt
    $sources = file_get_contents("source.txt");

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $sources);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $source_web = curl_exec($ch);
    curl_close($ch);

    scrape($source_web, $filename);

function scrape($list, $output){
    $splitlist = explode("\n", $list);
    foreach($splitlist as $proxy){
        $string = $proxy;
        // Credit: https://stackoverflow.com/questions/11637555/regular-expressions-for-proxy-pattern
        $pattern = '/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b:\d{2,5}/';
        if (preg_match($pattern, $string, $match) ) {
            file_put_contents($output, $match[0] . "\n", FILE_APPEND | LOCK_EX);
        }
    }
}

?>
