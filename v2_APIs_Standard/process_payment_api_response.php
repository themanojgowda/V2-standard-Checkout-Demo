<?php
session_start();

// Ensure the session value is always fetched dynamically
$response = isset($_SESSION['tes']) ? $_SESSION['tes'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Response</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .response-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            word-wrap: break-word;
        }
        .response-box pre {
            margin: 0;
            white-space: pre-wrap; /* Preserve formatting */
            word-break: break-word;
        }
    </style>
    <script>
        window.onload = function() {
            if (window.opener === null) {
                // Ensure this page opens in a new tab if not already opened
                window.open(location.href, '_blank');
                window.close();
            }
        };
    </script>
</head>
<body>
    <div class="response-box">
        <h2>Session Response</h2>
        <pre><?php echo htmlspecialchars(print_r($response, true)); ?></pre>
    </div>
</body>
</html>
