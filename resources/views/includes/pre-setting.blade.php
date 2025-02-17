<?php

function getCurrentUrl()
{
    // Check if the site is using HTTPS or HTTP
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    // Get the server name
    $host = $_SERVER['HTTP_HOST'];
    // Get the request URI which includes the path and the query string
    $requestUri = $_SERVER['REQUEST_URI'];
    // Combine the protocol, host, and request URI to get the full URL
    $fullUrl = $protocol . $host . $requestUri;
    return $fullUrl;
}

function getPageName($url)
{
    // Parse the URL to get the path
    $path = parse_url($url, PHP_URL_PATH);

    // Check if the path is empty or not found
    if (!$path) {
        return null;
    }

    // Explode the path into segments
    $segments = explode('/', trim($path, '/'));

    // Get the last segment
    $lastSegment = end($segments);

    // Check if the last segment is empty
    if (empty($lastSegment)) {
        return null;
    }

    // Replace dashes and underscores with spaces
    $lastSegment = str_replace(['-', '_'], ' ', $lastSegment);

    // Remove any non-alphanumeric characters except spaces
    $filteredSegment = preg_replace('/[^a-zA-Z0-9\s]/', '', $lastSegment);

    // Capitalize the first letter of each word
    $finalPageName = ucwords(strtolower($filteredSegment));

    return $finalPageName;
}

$website_name = 'Executive Nails Spa West University';
$website_primary_language = 'en';
$website_primary_color = '#ffffff';
$website_url = 'http://localhost/spa/';
$website_assets_url = $website_url . 'assets/';
$WEBSITE = $website_url; //temp
$facebook = '';
$instagram = '';
// Define default options

// Check if the page SEO tags are not set then use the default options
if (!isset($seoArray)) {
    // Check if dynamic page found
    $dynamicPage = getPageName(getCurrentUrl());
    if ($dynamicPage) {
        $seoArray = [
            'page_url' => getCurrentUrl(),
            'title' => $dynamicPage,
            'description' => $dynamicPage,
            'keywords' => $dynamicPage,
            'image' => 'https://placehold.co/600x400/.png',
        ];
    } else {
        $seoArray = $defaultSeoArray;
    }
} else {
    foreach ($defaultSeoArray as $key => $value) {
        if (!isset($seoArray[$key]) || empty($seoArray[$key])) {
            $seoArray[$key] = $value;
        }
    }
}
