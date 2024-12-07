<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yahoo Email Verifier</title>
</head>
<body>
    <h1>Yahoo Email Verifier</h1>
    <form method="post" action="">
        <label for="email">Enter Yahoo Email:</label>
        <input type="email" name="email" id="email" required placeholder="example@yahoo.com">
        <button type="submit">Verify</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        // Python Flask server URL
        $url = 'http://127.0.0.1:5000/check_email'; // Python Flask endpoint
        $data = ['email' => $email];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo "<p>Error: Unable to contact Python script.</p>";
        } else {
            // Decode JSON response
            $response = json_decode($result, true);
            echo "<p>Status: " . htmlspecialchars($response['status']) . "</p>";
            echo "<p>Message: " . htmlspecialchars($response['message']) . "</p>";
        }
    }
    ?>
</body>
</html>
