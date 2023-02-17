<?php
namespace App\Service;



class EnvoyeurEmail
{

    public function sendMail(string $to, string $subject, string $message ): void
    {
        $headers = "From: QuaiEntire@example.com\r\n";
        $headers .= "Reply-To: NOREPLY@example.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
    
        ini_set("SMTP", "localhost");
        ini_set("smtp_port", "1025");
    
        mail($to, $subject, $message, $headers);
    }
}


?>