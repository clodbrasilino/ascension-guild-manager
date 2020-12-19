<?php 

  function getData($file) {
    $data = file($file);
    $returnArray = array();
    foreach($data as $line) {
        $explode = explode("=", $line);
        $returnArray[$explode[0]] = preg_replace( "/\n/", "", $explode[1]);
    }
    return $returnArray;
  }

  function getAccessToken(){
    $credentials = getData('key.txt');
    $username = $credentials["client_id"];
    $password = $credentials["client_secret"];
    $url = "https://us.battle.net/oauth/token";
    $headers = [
      "Content-Type: application/x-www-form-urlencoded",
    ];
    $payload = [
      'grant_type' => 'client_credentials',
    ];
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $url);
    curl_setopt($request, CURLOPT_POST, 1);
    curl_setopt($request, CURLOPT_HTTPHEADER, $header);
    curl_setopt($request, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($request, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($request);
    if(!$response) return false;
    $token = json_decode($response, true);
    if($token) return $token["access_token"];
  }
?>
