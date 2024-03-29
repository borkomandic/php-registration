<?php

namespace App\Service;

class EmailService
{
    public function sendWelcomeEmail($toEmail, $name)
    {
        // Placeholder for email sending logic
        $subject = 'Welcome to Our Application';
        $message = "Hello " . $name . ", welcome to our application.";
        $headers = 'From: no-reply@example.com' . "\r\n" .
            'Reply-To: no-reply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($toEmail, $subject, $message, $headers);
    }
}
