<?php

function formatDate($datetime, $format = 'd-M-Y') {
    $date = new DateTime($datetime);
    return $date->format($format);
}

function get_favicon($url) {
    $site_url = parse_url($url);
    $favicon = "http://g.etfv.co/" . $site_url['scheme'] . "://" . $site_url['host'] . "?defaulticon=http://en.wikipedia.org/favicon.ico";

    return $favicon;
}
