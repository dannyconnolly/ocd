<?php

function formatDate($datetime) {
    $date = new DateTime($datetime);
    return $date->format('d-M-Y');
}
