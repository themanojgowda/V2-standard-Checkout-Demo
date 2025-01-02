<?php
session_start();
// print_r($_SESSION['tes']);
// Fetching the Access Token, Merchant Order ID, and Amount from session
$accessToken = isset($_SESSION['accessToken']) ? $_SESSION['accessToken'] : '';
$merchantOrderId = isset($_SESSION['merchantOrderId']) ? $_SESSION['merchantOrderId'] : '';
$amount = isset($_SESSION['amount']) ? $_SESSION['amount'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhonePe API Integration - Make Payment</title>
    <style>
        /* Styling for the boxes */
        .form-box {
            border: 2px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-box h2 {
            margin-top: 0;
        }
        .form-box label {
            display: block;
            margin-bottom: 5px;
        }
        .form-box input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

        /* Styling for the new button */
        .redirect-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .redirect-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function openInNewTab(url) {
            const newTab = window.open(url, '_blank');
            if (!newTab) {
                alert('Please allow pop-ups to proceed with the payment.');
            }
        }
    </script>
</head>
<body>
    <h1>Make Payment</h1>

    <!-- Make Payment Form -->
    <form method="POST" action="process_payment.php" target="_blank">
        <div class="form-box">
            <h2>Make Payment</h2>
            <label for="accessToken">Access Token:</label>
            <input type="text" id="accessToken" name="accessToken" value="<?php echo $accessToken; ?>" required><br>

            <label for="merchantOrderId">Merchant Order ID:</label>
            <input type="text" id="merchantOrderId" name="merchantOrderId" value="<?php echo $merchantOrderId; ?>" required><br>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="<?php echo $amount; ?>" required><br>
        </div>

        <div class="form-box">
            <h2>Meta Info (Enter Values)</h2>
            <label for="udf1">UDF1:</label>
            <input type="text" id="udf1" name="udf1"><br>

            <label for="udf2">UDF2:</label>
            <input type="text" id="udf2" name="udf2"><br>

            <label for="udf3">UDF3:</label>
            <input type="text" id="udf3" name="udf3"><br>

            <label for="udf4">UDF4:</label>
            <input type="text" id="udf4" name="udf4"><br>

            <label for="udf5">UDF5:</label>
            <input type="text" id="udf5" name="udf5"><br>

            <label for="redirectUrl">Redirect URL:</label>
            <input type="text" id="redirectUrl" name="redirectUrl" value="https://example.com/payment-failure" required><br><br>
        </div>

        <!-- <button type="submit" onclick="openInNewTab('process_payment.php')">Make Payment</button> -->
        <button type="submit">Make Payment</button>
        
        <!-- New Button for redirection -->
        <button type="button" class="redirect-button" onclick="openInNewTab('process_payment_api_response.php')">Redirect to Process API Response</button>
        
    </form>
</body>
</html>
