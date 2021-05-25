<?php
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

class SMTPClient {

    private $mailer;

    public function __construct(){
        $transport = (new Swift_SmtpTransport(Config::SMTP_HOST(), Config::SMTP_PORT, 'tls'))
            ->setUsername(Config::SMTP_USER())
            ->setPassword(Config::SMTP_PASSWORD());

        $this->mailer = new Swift_Mailer($transport);
    }

    public function send_register_user_token($user){
        $domain = 'http';

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $host = 'localhost/azra-sudoku';
        } else {
            $domain = 'https';
            $host = $_SERVER['HTTP_HOST'];
        }

        $message = (new Swift_Message('Confirm your account'))
            ->setFrom(['azra.intj@gmail.com' => 'Sudoku Game'])
            ->setTo([$user['email']])
            ->setBody('Here is the confirmation link: '.$domain.'://'.$host.'/login.html?confirmation_token='.$user['token']);

        $this->mailer->send($message);
    }

    public function send_user_recovery_token($user){
        $domain = 'http';

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $host = 'localhost/azra-sudoku';
        } else {
            $domain = 'https';
            $host = $_SERVER['HTTP_HOST'];
        }

        $message = (new Swift_Message('Reset Your Password'))
            ->setFrom(['azra.intj@gmail.com' => 'Sudoku Game'])
            ->setTo([$user['email']])
            ->setBody('Here is the recovery token: '.$domain.'://'.$host.'/login.html?recovery_token='.$user['token']);
        $this->mailer->send($message);
    }
}