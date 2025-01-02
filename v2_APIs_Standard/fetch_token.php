<?php
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $clientId = $_POST['clientId'];
    $clientVersion = $_POST['clientVersion'];
    $clientSecret = $_POST['clientSecret'];
    $grantType = $_POST['grantType'];

    // Prepare the URL and headers for the cURL request
    $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';
    $data = [
        'client_id' => $clientId,
        'client_version' => $clientVersion,
        'client_secret' => $clientSecret,
        'grant_type' => $grantType
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
 
    // Close cURL session
    curl_close($ch);

    // Decode the response JSON
    $responseData = json_decode($response, true);

    // Check if the token was fetched successfully
    if (isset($responseData['access_token'])) {
        $accessToken = $responseData['access_token'];
        $clientSecret = ''; // Hide the client secret after fetching the token for security reasons

        // // Store the access token, merchant order ID, and amount in session
        $_SESSION['accessToken'] = $accessToken;
        $_SESSION['merchantOrderId'] = $merchantOrderId;//'TX' . rand(100000, 999999); // Random Merchant Order ID
        $_SESSION['amount'] = $amount;//rand(100, 1000); // Random amount
        // Redirect to the make payment form
        // header('Location: make_payment.php');
        // exit;


    } else {
        echo 'Failed to fetch token: ' . $responseData['error_description'];
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhonePe API Integration</title>
    <style>
        .box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }
        .button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>PhonePe API Integration</h1>

    <!-- Box for Fetch Auth Token -->
    <div class="box">
        <h2>Fetch Auth Token</h2>
        <form method="POST" action="fetch_token.php">
            <label for="clientId">Client ID:</label>
            <input type="text" id="clientId" name="clientId" value="<?php echo isset($clientId) ? $clientId : ''; ?>" required><br>

            <label for="clientSecret">Client Secret:</label>
            <input type="password" id="clientSecret" name="clientSecret" value="<?php echo isset($clientSecret) ? $clientSecret : ''; ?>" required><br>

            <label for="clientVersion">Client Version:</label>
            <input type="text" id="clientVersion" name="clientVersion" value="1" readonly><br>

            <label for="grantType">Grant Type:</label>
            <input type="text" id="grantType" name="grantType" value="client_credentials" readonly><br><br>

            <button class="button" type="submit">Fetch Token</button>
        </form>
    </div>

    <?php if (isset($accessToken)): ?>
         <!-- Button to View Token -->
         <a href="view_token.php?token=<?php echo urlencode(json_encode($responseData)); ?>" target="_blank">
            <button class="button">View Token</button>
        </a>
        <!-- Box for Make Payment (Only displayed if access token is received) -->
        <div class="box">
            <h2>Make Payment</h2>
            <form method="POST" action="make_payment.php">
                <label for="accessToken">Access Token:</label>
                <input type="text" id="accessToken" name="accessToken" value="<?php echo $accessToken; ?>" readonly><br>

                <!-- <label for="merchantOrderId">Merchant Order ID:</label>
                <input type="text" id="merchantOrderId" name="merchantOrderId" required><br> 

                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required><br> -->

                <button class="button" type="submit">Make Payment</button>
            </form>
        </div>

       
    <?php endif; ?>
</body>
</html>

