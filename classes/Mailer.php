<?php


class Mailer
{
    const SMTP = 'smtp.gmail.com';
    const PORT = '465';
    const USERNAME = 'anastasia.beetroot@gmail.com';
    const PASS = 'a7n7a7s7t7asiya';

    public function notifyOrder()
    {

// Create a message
       $body = $this->getBody('my-email-template');
        $message = (new Swift_Message('Заказ на сайте'))
            ->setFrom(['anastasia.beetroot@gmail.com' => 'Магазин'])
            ->setTo(['Nactaciya@gmail.com'])
            ->setBody($body, 'text/html');

// Send the message
        $result = $this->getInternalMailer()->send($message);

    }

    private function getInternalMailer(): Swift_Mailer
    {
        $transport = (new Swift_SmtpTransport(Mailer::SMTP, self::PORT, 'ssl'))
            ->setUsername(self::USERNAME)
            ->setPassword(self::PASS);;

// Create the Mailer using your created Transport
        return new Swift_Mailer($transport);

    }
    private function getBody(string $template): string
    {
        ob_start();
        require "$template.php";
        return ob_get_clean();

    }
    public function notifyFeedback()
    {

// Create a message
        $body = $this->getBody('template-feedback');
        $message = (new Swift_Message('Обращение на сайте'))
            ->setFrom(['anastasia.beetroot@gmail.com' => 'Покупатель'])
            ->setTo(['anastasia.beetroot@gmail.com'])
            ->setBody($body, 'text/html');

// Send the message
        $result = $this->getInternalMailer()->send($message);

    }
}