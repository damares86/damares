<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the formatted HTML from the POST data
    $formattedHtml = $_POST['formattedHtml'];

    // Write the HTML to a file (you can customize the file path and name)
    $filePath = 'formatted_output.html';
    file_put_contents($filePath, $formattedHtml);

    // Send a response back to the JavaScript (you can customize the response)
    echo 'HTML saved successfully to ' . $filePath;
} else {
    // Invalid request method
    http_response_code(405);
    echo 'Invalid request method';
}
?>
