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
  exec('sudo service apache2 restart');

  echo 'Virtual host created successfully';
} else {
  echo 'Error creating virtual host';
}
