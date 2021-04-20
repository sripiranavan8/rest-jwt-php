<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/My/REST/jwt-auth/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "name":"generateToken",
    "param":{
        "email":"sripianavan08@gmail.com",
        "password":"123456"
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));
$token = json_decode(curl_exec($curl),true)['response']['result']['token'];
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  header('Content-Type:application/json');
    echo 'Curl Error: ' . $err;
} else {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost/My/REST/jwt-auth/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
      "name":"getCustomerDetails",
      "param":{
          "customerId":3
      }
  }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer '. $token,
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err) {
    header('Content-Type:application/json');
    echo 'Curl Error: ' . $err;
  } else {
    header('Content-Type:application/json');
    echo $response;
  }
}
?>