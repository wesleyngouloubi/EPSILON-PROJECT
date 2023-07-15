<?php

session_start();
require "../core/conf.inc.php";
require "../core/functions.php";	

include "../template/header.php"; 
include "../template/navbarBack.php";


if(!isAdmin()){
    header("location: /index.php");
}

// chemin vers les logs
$logFilePath = '/var/log/apache2/access.log';

// Read the log file and split it into individual lines
$logFileContent = file_get_contents($logFilePath);
$logEntries = explode("\n", $logFileContent);

// Create an empty array to store the parsed log entries
$parsedLogEntries = [];

// Loop through each log entry and parse it
foreach ($logEntries as $logEntry) {
    // Split the log entry into its individual parts
    $parts = explode(' ', $logEntry);

    // Ensure that the log entry has the expected number of parts
    if (count($parts) < 10) {
        continue; // Skip this log entry if it doesn't have the expected format
    }

    // Extract the fields that we're interested in
    $ipAddress = $parts[0];
    $dateTime = $parts[3] . ' ' . $parts[4];
    $requestMethod = trim($parts[5], '"');
    $requestUrl = $parts[6];
    $statusCode = $parts[8];
    $responseSize = $parts[9];

    // Build an array with the parsed log entry
    $parsedLogEntry = array(
        'ipAddress' => $ipAddress,
        'dateTime' => $dateTime,
        'requestMethod' => $requestMethod,
        'requestUrl' => $requestUrl,
        'statusCode' => $statusCode,
        'responseSize' => $responseSize
    );

    // Add the parsed log entry to the array of parsed log entries
    $parsedLogEntries[] = $parsedLogEntry;
}

// Format the parsed log entries as an HTML table
$htmlTable = '<table style="border-collapse: collapse; width: 100%;">';
$htmlTable .= '<thead style="background-color: #f2f2f2;"><tr>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">IP</th>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">Date</th>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">Méthode de requête</th>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">Url de requête</th>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">Code de status</th>';
$htmlTable .= '<th style="padding: 8px; border: 1px solid #ddd;">Taille</th>';
$htmlTable .= '</tr></thead>';
$htmlTable .= '<tbody>';

foreach ($parsedLogEntries as $parsedLogEntry) {
    $htmlTable .= '<tr>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['ipAddress']) . '</td>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['dateTime']) . '</td>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['requestMethod']) . '</td>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['requestUrl']) . '</td>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['statusCode']) . '</td>';
    $htmlTable .= '<td style="padding: 8px; border: 1px solid #ddd;">' . htmlspecialchars($parsedLogEntry['responseSize']) . '</td>';
    $htmlTable .= '</tr>';
}

$htmlTable .= '</tbody>';
$htmlTable .= '</table>';

echo $htmlTable;
