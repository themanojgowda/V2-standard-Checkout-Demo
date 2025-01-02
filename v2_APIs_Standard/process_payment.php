<?php
session_start();

print_r($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $accessToken = $_POST['accessToken'];
    $merchantOrderId = $_POST['merchantOrderId'];
    $amount = $_POST['amount'];
    $udf1 = $_POST['udf1'];
    $udf2 = $_POST['udf2'];
    $udf3 = $_POST['udf3'];
    $udf4 = $_POST['udf4'];
    $udf5 = $_POST['udf5'];
    $redirectUrl = $_POST['redirectUrl'];
 
    // Prepare the metaInfo array from the user input values
    $metaInfo = [
        'udf1' => $udf1,
        'udf2' => $udf2,
        'udf3' => $udf3,
        'udf4' => $udf4,
        'udf5' => $udf5
    ];

    // Prepare the cURL request data
    $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay';
    $data = [
        'merchantOrderId' => $merchantOrderId,
        'amount' => $amount,
        'metaInfo' => $metaInfo,
        'paymentFlow' => [
            'type' => 'PG_CHECKOUT',
            'message' => 'Secure payment request',
            'merchantUrls' => [
                'redirectUrl' => $redirectUrl
            ]
        ]
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: O-Bearer ' . $accessToken
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
    //print_r($responseData);
    $_SESSION['tes']= $responseData;
    // Check if the payment state is PENDING
    if (isset($responseData['state']) && $responseData['state'] === 'PENDING') {
        // Redirect user to the PhonePe payment page
        if (isset($responseData['redirectUrl'])) {
            header("Location: " . $responseData['redirectUrl']);
            exit();
        }
    } else {
        echo 'Payment failed or already completed';
    }

    // Optional: Display the response for debugging
    echo '<h2>Payment Response</h2>';
    echo '<pre>';
    print_r($responseData);
    echo '</pre>';
}
?>
