<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read the configuration file name from the query string
    $config_file = $_GET['config_file'];

    // Check if the configuration file exists
    if (!file_exists('/etc/apache2/sites-available/' . $config_file)) {
        header('Content-Type: application/json');
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Configuration file not found']);
        exit;
    }

    // Disable the Apache configuration for the domain
    exec('sudo a2dissite ' . $config_file, $output, $return_var);
    if ($return_var !== 0) {
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Failed to disable Apache configuration']);
        exit;
    }

    // Delete the Apache configuration file
    unlink('/etc/apache2/sites-available/' . $config_file);

    // Reload the Apache configuration to apply the changes
    exec('sudo apachectl graceful', $output, $return_var);
    if ($return_var !== 0) {
        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Failed to reload Apache configuration']);
        exit;
    }

    // Return a success message
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Configuration file deleted']);

} else {
    // Return an error if the request method is not POST
    header('Content-Type: application/json');
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid request method']);
}
