<?php

$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];
$username = $_POST['user_name'];
//$url = 'https://hooks.slack.com/services/<url>';
$url = '<Incoming Slack Webhook URL>';

if($token != '<token>'){
  $msg = "Invalid Token.";
  die($msg);
  echo $msg;
}


// *************************************
// Function to post to Slack Channel
// *************************************
function slackPost($dest,$user,$icon,$msg){
  $ch = curl_init($GLOBALS['url']);
  $payload = array(
        'channel' => $dest,
        'username' => $user,
        'text' => $msg,
        'icon_emoji' => $icon
  );
  $jsonDataEncoded = json_encode($payload);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  $result = curl_exec($ch);
}


// *************************************
// Function to callPolice
// *************************************
function callPolice($textPart,$username){
  if ($textPart[0] != ''){
    $dest = $textPart[0];
    slackPost($dest,'SlackPolice',':slackpolice:','Ok folks, Please move along... perhaps to #simple-social');
  }else{
    $reply = "Where do you want me to send the police? \n";
    $reply .= ":interrobang: *Help* \n";
    $reply .= "Usage: /police [channel] \n";
    $reply .= "*/police #example*  - Deploys police to the example channel \n";
    echo $reply;
  }
}

// *************************************
// Function to call action
// *************************************
function callAction($textPart,$username){
  $action = $textPart[0];
  if ($action == 'help'){
    $reply = ":interrobang: *Help* \n";
    $reply .= "Usage: /police [channel] \n";
    $reply .= "*/police #example*  - Deploys police to the example channel \n";
    echo $reply;
  }else{
    callPolice($textPart,$username);
  }
}

$debug = false;
$textPart = preg_split('/\s+/', $text);
callAction($textPart,$username);

?>
