<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $comments = trim($_POST["comments"]);

    // Validate required fields
    if (empty($name) || empty($comments) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Send error response
        http_response_code(400);
        echo "Please fill out all required fields.";
        exit;
    }

    // Define the recipient email address
    $recipient = "nathanielbn@gmail.com"; // Replace with your email

    // Set the email subject
    $subject = "New contact from $name";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    if (!empty($phone)) {
        $email_content .= "Phone: $phone\n";
    }
    $email_content .= "Message:\n$comments\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Send success response
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        // Send failure response
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }
} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
