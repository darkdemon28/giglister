<?php
$app_id = "Your APP-ID here"; 
$app_secret = "Your APP-SECRET here";

function fetchUrl($url){ 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
    // You may need to add the line below // 
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);   
    $retData = curl_exec($ch); curl_close($ch);   
    return $retData; 
}

function format_time($timestamp) {
    $t = explode('T', $timestamp);
    //$date_time = $t[0]. ' ' . substr($t[1], 0, -5);
    $date_time = substr($t[1], 0, -5);
    $date_time = date_create($date_time);
    //return 'Starting on: ' . date('d/m/y',$date) . ' at: ' . date_format('H:i:s',$time);
    //return date_format($date_time, 'G:i \U\h\r \o\n d/m/y');
    return date_format($date_time, 'G:i \U\h\r');
}

function format_date($datestamp) {
    $d = explode('T', $datestamp);
    $event_d = $d[0] . ' ';
    //$event_d = date($event_date, 'd/m/y');
    $event_d = new DateTime($event_d);
    return $event_d->format('d/m/y');
}

function get_link($event_id, $token) {
    $query = "https://graph.facebook.com/v1.0/".$event_id."/feed?fields=link&{$token}";
    $fb_response = file_get_contents($query);
    $fb_data = json_decode($fb_response);
    
    foreach($fb_data->data as $key) {
        $event_link = $key->link;
    }
    return $event_link;
}
