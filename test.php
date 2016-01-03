<?php

    $text = file_get_contents("slack.json");
    $config = json_decode($text, true);
    $url = $config['url'];    
    $payload = array
    (
        "text"          => $text,
        "username"      => $config["username"],
        "icon_emoji"    => $config["emoji"],
        "channel"       => $config["channel"]
    );

    $data = "payload=".json_encode($payload);
    echo $data;
?>
