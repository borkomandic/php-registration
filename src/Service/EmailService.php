<?php

namespace App\Service;

class EmailService
{
    public function sendWelcomeEmail($toEmail)
    {
        // Placeholder for email sending logic
        $subject = 'Dobro došli';
        $message = "Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...";
        $headers = 'From: adm@kupujemprodajem.com' . "\r\n" .
            'Reply-To: no-reply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($toEmail, $subject, $message, $headers);
    }
}
