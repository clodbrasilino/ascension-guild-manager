<?php 

  function getData($file) {
    $data = file($file);
    $returnArray = array();
    foreach($data as $line) {
        $explode = explode("=", $line);
        $returnArray[$explode[0]] = $explode[1];
    }
    return $returnArray;
  }

  function getAccessToken(){
    $credentials = getData('key.txt');
    $username = $credentials["client_id"];
    $password = $credentials["client_secret"];
    $url = "https://us.battle.net/oauth/token";
    $request_headers = [
      "Content-Type: application/x-www-form-urlencoded",
    ];
    $request_data = [
      'grant_type' => 'client_credentials'
    ];
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $url);
    curl_setopt($request, CURLOPT_POST, 1);
    curl_setopt($request, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($request, CURLOPT_USERPWD, $username . ":" . $password);

    $response = curl_exec($request);
    return json_decode($response, true);
  }

  echo getAccessToken();

?>
