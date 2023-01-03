<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read the directory contents
    $dir = '/etc/apache2/sites-available';
    $files = scandir($dir);

    // Filter out hidden files and non-configuration files
    $config_files = array_filter($files, function($file) {
        return !preg_match('/^\./', $file) && preg_match('/\.conf$/', $file);
    });

    // Return the list of configuration files
    header('Content-Type: application/json');
    echo json_encode(['config_files' => $config_files]);
} else {
    // Return an error if the request method is not GET
    header('Content-Type: application/json');
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request method']);
}
