<?php

class SendEmail
{
    public function send($user, $eventlink)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("201910432@gordoncollege.edu.ph", "GC Panel");

        $tos = [
            "$user" => "Example User1",
        ];

        $email->setSubject("Hello from GC PANEL");

        // $email->addTo("luciheartstone@gmail.com", "Example User");
        $email->addTos($tos);

        $email->addContent("text/plain", "Sample email, here is the link to the event " . $eventlink);
        $email->addContent(
            "text/html",
            "<strong>Sample email, here is the link to the event $eventlink</strong>"
        );
        $sendgrid = new \SendGrid(SENDGRID_API_KEY);

        try {
            $response = $sendgrid->send($email);
            // echo print $response->statusCode();
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}
