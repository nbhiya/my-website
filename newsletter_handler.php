<?php
If ($_SERVER[‘REQUEST_METHOD’] == ‘POST’) {
 // Capture form data and sanitize inputs
 $password = htmlspecialchars($_POST[‘Password’]);
 $confirmPassword = htmlspecialchars($_POST[‘confirmPassword’]);
 $firstName = htmlspecialchars($_POST[‘firstName’]);
 $lastName = htmlspecialchars($_POST[‘lastName’]);
 $email = filter_var($_POST[‘email’], FILTER_SANITIZE_EMAIL);
 $interests = [];
 If (isset($_POST[‘meals’])) $interests[] = “Menu”;
 If (isset($_POST[‘specials’])) $interests[] = “Specials”;
 If (isset($_POST[‘events’])) $interests[] = “Events”;
 $termsAccepted = isset($_POST[‘terms’]);
 // Initialize error messages
 $errors = [];
 // Validate inputs
 If (empty($password) || empty($confirmPassword)) {
 $errors[] = “Password and Confirm Password are required.”;
 } elseif ($password !== $confirmPassword) {
 $errors[] = “Passwords do not match.”;
 }
 If (empty($firstName) || empty($lastName)) {
 $errors[] = “First Name and Last Name are required.”;
 }
 If (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 $errors[] = “Invalid email format.”;
 }
 If (!$termsAccepted) {
 $errors[] = “You must accept the terms and conditions.”;
 }
 // If there are errors, display them
 If (!empty($errors)) {
 Echo “<h3>Errors:</h3><ul>”;
 Foreach ($errors as $error) {
 Echo “<li>” . $error . “</li>”;
 }
 Echo “</ul>”;
 Exit;
 }
 // Prepare email
 $to = kuyenzekabhiya.08@gmail.com; 
 $subject = “Newsletter Subscription”;
 $message = “A new user has subscribed to the newsletter:\n\n”;
 $message .= “Name: $firstName $lastName\n”;
 $message .= “Email: $email\n”;
 $message .= “Interests: “ . implode(“, “, $interests) . “\n”;
 // Send email
 $headers = “From: no-reply@sironi-restaurant.com\r\n”; // Adjust domain as needed
 $headers .= “Reply-To: $email\r\n”;
 If (mail($to, $subject, $message, $headers)) {
 Echo “<h3>Thank you for subscribing! A confirmation email has been sent to your email 
address.</h3>”;
 } else {
 Echo “<h3>Sorry, there was an error processing your request. Please try again later.</h3>”;
 }
} else {
 Echo “<h3>Invalid form submission.</h3>”;
}
?>