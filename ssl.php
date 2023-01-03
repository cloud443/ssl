<?php

$domain = $_GET['domain'];

exec("sudo certbot --apache --redirect -n --expand -d $domain", $output, $return_var);

if ($return_var == 0) {
  
  http_response_code(500);
  $result = array(
    'status' => 'error',
    'message' => "An error occurred while trying to enable HTTPS for $domain"
  );
} else {
 
  http_response_code(200);
  $result = array(
    'status' => 'success',
    'message' => "HTTPS was successfully enabled for $domain"
  );
}

header('Content-Type: application/json');
echo json_encode($result);
