<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($guests)) {
        echo "Please fill in all the fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        // Prepare email message
        $to = "kuyenzekabhiya.08@gmail.com";  // Restaurant's email
        $subject = "New Reservation from $name";
        $message = "You have a new reservation request:\n\n";
        $message .= "Name: $name\n";
        $message .= "Email: $email\n";
        $message .= "Phone: $phone\n";
        $message .= "Reservation Date: $date\n";
        $message .= "Reservation Time: $time\n";
        $message .= "Number of Guests: $guests\n";

        // Send email to restaurant
        $headers = "From: no-reply@sironi-restaurant.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        if (mail($to, $subject, $message, $headers)) {
            // Confirmation email to user
            $subject_user = "Reservation Confirmation - Sironi Restaurant";
            $message_user = "Dear $name,\n\nYour reservation has been confirmed for $guests guests on $date at $time.\n\nThank you for choosing Sironi Restaurant.";
            mail($email, $subject_user, $message_user, "From: no-reply@sironi-restaurant.com");

            // Redirect to the homepage after a successful reservation
            header("Location: index.html");
            exit;
        } else {
            echo "There was an error processing your reservation. Please try again later.";
        }
    }
} else {
    echo "Invalid form submission.";
}
?>