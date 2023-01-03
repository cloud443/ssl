<?php

// Set the default custom domain and the frequency of the IP check (in seconds)
$default_domain = 'api.hifyc.link';
$default_check_frequency = 3600; // 1 hour

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Read the domain and check frequency from the query parameters
    $domain = isset($_GET['domain']) ? $_GET['domain'] : $default_domain;
    $check_frequency = isset($_GET['frequency']) ? intval($_GET['frequency']) : $default_check_frequency;

    // Initialize the resolved IP address
    $ip_address = gethostbyname($domain);

    // Resolve the IP address for the domain
    $new_ip_address = gethostbyname($domain);

    // If the IP address has changed, trigger Certbot to generate a new SSL certificate
    if ($new_ip_address != $ip_address) {
        $ip_address = $new_ip_address;
        exec('sudo certbot --apache --redirect -n --expand -d ' . $domain);
    }

    // Return the resolved IP address in the response
    header('Content-Type: application/json');
    echo json_encode(['ip_address' => $ip_address]);
} else {
    // Return an error for unsupported request methods
    header('Content-Type: application/json');
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method not allowed']);
}
