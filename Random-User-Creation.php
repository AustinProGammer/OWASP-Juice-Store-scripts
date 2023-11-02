<?php

$website = 'localhost:8080'; // Replace with your website URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the number of accounts to create from the form input
    $numAccounts = $_POST['numAccounts'];

    // Loop to create the specified number of accounts
    for ($i = 0; $i < $numAccounts; $i++) {
        // Generate a random string for the email
        $email = generateRandomString() . '@example.com';

        // Create a user object with the desired properties
        $user = array(
            'username' => $email,
            'role' => 'admin',
            'email' => $email
        );

        // Convert the user object to JSON
        $data = json_encode($user);

        // Set the HTTP headers
        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        );

        // Create a new cURL resource
        $curl = curl_init();

        // Set the cURL options
        curl_setopt($curl, CURLOPT_URL, $website);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for any errors
        if (curl_errno($curl)) {
            echo 'Error: ' . curl_error($curl);
        } else {
            echo 'User account created successfully!<br>';
        }

        // Close the cURL resource
        curl_close($curl);
    }
}

// Function to generate a random string
function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Creation</title>
</head>
<body>
    <form method="POST" action="">
        <label for="numAccounts">Number of accounts to create:</label>
        <input type="number" id="numAccounts" name="numAccounts" required>
        <input type="submit" value="Create Accounts">
    </form>
</body>
</html>
