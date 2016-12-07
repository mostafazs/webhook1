<?php 
//Function for POST instead of file_get_contents
function send($url,$data,$header=array("Content-type: application/json")){
	$ch = curl_init(); 
	curl_setopt($ch,CURLOPT_URL,$url); 
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
	$res = curl_exec($ch); 
	curl_close($ch); 
	return $res; 
	}
?>
<html>
<head><title>Send Message</title>
<meta charset="utf-8"/>
<script src="./jQuery.js"></script>
</head>
<body>

<form action="./send_message.php" method="POST">
<input type="text" name="message" />
<input type="hidden" name="submitted" value="1"/>
<input type="submit" value="Send"/>
</form>
<?php

if( isset($_POST['submitted']) ){
  $secret = "2453536"; // secret key or token or any things that not allow any one to post to our hook
  $url = "http://fbf05522.ngrok.io";
  $hooker_sender_url = $url."/Hook1/hooker_sender.php";
  //$postdata = http_build_query(array('message'=>'helllo','secret'=>'2451514')); for send http query
  $message = $_POST['message'];
  $postdata = array('message'=>$message,'secret'=>$secret);
  $json = json_encode($postdata);
  echo $json;
  //echo "<script>console.log(".$json.")</script>";
  $opts = array('http'=>array(
    'method' => 'POST',
    'header' => 'Content-Type: application/json',
    'content' => $json
  ));
  $context = stream_context_create($opts);
  //$result = file_get_contents($hooker_sender_url,false,$context); // use cURL ..it's not work
  $Result = send($hooker_sender_url,$json);
  echo $Result;
}else{
  echo "Fill Form";
}

?>



<!--
<input type="text" name="message" id="message"/>
<button id="send">Send</button>
-->
<script>
/*
$("document").ready(function(){
  $("button#send").on("click",function(){
    var msg = $("input#message").val();
    console.log(msg);


    var xhrSend = $.ajax({
      url:'hooker_sender.php',
      context: $(this),
      data: {message: msg},
      dataType: 'text',
      type: 'POST',
      timeout: '5000'
    });
    xhrSend.success(function(data,status){
      console.log(data);
      console.log("success");
      console.log(status);
    });
    xhrSend.fail(function(data,status){
      console.log(status);
      console.log("fail");
    });
    xhrSend.done(function(data,status){
      console.log("done");
      console.log(status);
      $(this).addClass("Done");
    });




  });


});
*/
</script>
</body>
</html>
