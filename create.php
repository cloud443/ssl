<?php

// Get the server name from the query string
$serverName = $_GET['serverName'];

// Set the document root and allow override
$documentRoot = '/var/www/html/public';
$allowOverride = 'All';

// Generate the virtual host configuration
$config = <<<EOF
<VirtualHost *:80>
  ServerName $serverName
  DocumentRoot $documentRoot

  <Directory $documentRoot>
    AllowOverride $allowOverride
    Require all granted
  </Directory>
</VirtualHost>
EOF;

// Write the configuration to a file
$result = file_put_contents('/etc/apache2/sites-available/' . $serverName . '.conf', $config);

if ($result !== false) {
  // Enable the virtual host
  exec('sudo a2ensite ' . $serverName . '.conf');

  // Restart Apache
  exec('sudo apachectl graceful');

  // Set the response message
  $response['message'] = 'Virtual host created successfully';

  // Set the HTTP status code to 200 (OK)
  http_response_code(200);
} else {
  // Set the response message
  $response['message'] = 'Error creating virtual host';

  // Set the HTTP status code to 500 (Internal Server Error)
  http_response_code(500);
}

// Set the content type to JSON
header('Content-Type: application/json');
