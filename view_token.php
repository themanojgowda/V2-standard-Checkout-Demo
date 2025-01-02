<?php
// Check if the token is passed via GET parameter
if (isset($_GET['token'])) {
    // Decode the token JSON data
    $tokenData = json_decode($_GET['token'], true);
} else {
    echo 'No token data found.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Auth Token</title>
    <style>
        .box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <h1>View Auth Token</h1>

    <div class="box">
        <h2>Auth Token Response</h2>
        <pre><?php echo json_encode($tokenData, JSON_PRETTY_PRINT); ?></pre>
    </div>
</body>
</html>
