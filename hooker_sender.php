<?php

$secret = "2453536";//same secret as send_message.php file
$in = file_get_contents("php://input");
$decoded = json_decode($in);
//var_dump($decoded);
$get_secret = $decoded->secret;
$message = $decoded->message;
$new_post_data = array("message"=>$message);
$new_post_data = json_encode($new_post_data);
//$hook_endpoints = ["http://29baf15.ngrok.io/handle_webhooks.php","http://localhost:8080/handle_webhooks.php"];
$url_endpoint = "http://fbf05522.ngrok.io";
$hook_endpoints = [$url_endpoint."/endpoint1/index.php",$url_endpoint."/endpoint2/index.php",$url_endpoint."/endpoint3/index.php"];
if("php://input" && ($secret == $get_secret)) {


    // very lazily chuck the whole thing at json_encode
    // a Real Application would validate or look things up
    //$post_body = json_encode($_POST);
    $post_body = $new_post_data;
    // send using streams
    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/json',
            'content' => $post_body,
        ]
    ]);

    foreach ($hook_endpoints as $endpoint) {
        $success = file_get_contents($endpoint, false, $context);

        echo "<p>Send to:" . $endpoint . "</p>\n";
    }

    include ("hook_thanks.html");
} else {
    // display the template
    //include("send_message.php");
    //or
    echo "OHHH";
    //http_response_code(200); exit();

}
