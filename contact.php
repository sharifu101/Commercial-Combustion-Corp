<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $phone   = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $captcha = $_POST['g-recaptcha-response'];

    // Your secret key from Google reCAPTCHA
    $secretKey = "YOUR_SECRET_KEY_HERE";

    // Verify reCAPTCHA
    $verifyResponse = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}"
    );
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        // Email details
        $to      = "youremail@example.com"; // Replace with your email
        $subject = "New Contact Form Submission";
        $body    = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "Thank you! Your message has been sent.";
        } else {
            echo "Sorry, something went wrong. Please try again.";
        }
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
}
?>
