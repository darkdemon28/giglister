<?php
include 'fbconfig.php';

    // Retrieve a new Auth token 
    $authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$app_id}&client_secret={$app_secret}"); 
    
    //$query = "https://graph.facebook.com/v1.0/167973073348132?fields=events.fields(name,description,location,owner,cover,ticket_uri,venue)&{$authToken}&limit=50";
    $query = "https://graph.facebook.com/v1.0/167973073348132/events?fields=name,description,location,owner,cover,ticket_uri,venue&{$authToken}&since=2010&until=now";
    
    // Get the response from Facebook
    $fb_response = file_get_contents($query);
    
    // Decode the JSON data from the response
    $fb_data = json_decode($fb_response);
    
    //print_r($fb_data);
    
    // Use a foreach loop to list the data from the array
    foreach ($fb_data->data as $item) {
        $event_id = $item->id;
        $name = $item->name;
        $description = $item->description;
        $location = $item->location;
        $venue = '<a href="map.php?coords='.$item->venue->latitude.','.$item->venue->longitude.'" target="_blank" title="Click to open a map">'.$item->venue->street . '</a> in ' . $item->venue->city . ' (' . $item->venue->country . ')';
        $start_time = $item->start_time;
        $start_date = $item->start_time;
        $event_date = format_date($start_date);
        $start_time = format_time($start_time);
        $cover_img = $item->cover->source;
?>
<!DOCTYPE HTML>
<html>
<head>
<link href="layout.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
    <div class="event-container">
        <div class="col1"><img src="<?php echo($cover_img); ?>" /></div>
        <div class="col2">
            <h3 class="event-name"><?php echo($name); ?></h3>
            <p class="event-description"><?php echo($description); ?></p>
            <p class="event-location"><span class="strong">Location:</span> <?php echo($location); ?></p>
            <p class="event-start-time"><span class="strong">Starting at:</span> <?php echo($start_time); ?></p>
            <p class="event-date"><span class="strong">Date:</span> <?php echo($event_date); ?></p>
            <p class="event-venue"><span class="strong">Venue address:</span> <?php echo($venue); ?></p>
            <p class="event-link"><span class="strong">Link:</span> <?php echo(get_link($event_id, $authToken)); ?></p>
        </div>
        <div class="clearer"></div>
    </div>
<?php
    }
?>
</div>
</body>
</html>
