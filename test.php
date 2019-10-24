<?php

interface iUser {

}

class User implements iUser {
    public $email;
    public $phone;

    public function __construct($email,$phone)
    {
        $this->email = $email;
        $this->phone = $phone;
    }
}




class NotificationService {

    private static $notificatorsList = ['EmailNotificator','SmsNotificator'];

    public function notify(iUser $user, $text) {

        foreach (self::$notificatorsList as $notificator) {
            $notify = new $notificator($user,$text);
            $notify->send();

        }

    }

}




interface iNotificator {


    public function send();
}


class SmsNotificator implements iNotificator {

    private $phone;
    private $text;
    public function __construct(iUser $user,$text)
    {

        $this->text = $text;
        $this->phone = $user->phone;
    }

    public function send(){

        echo "send {$this->text} to phone {$this->phone}";

    }
}

class EmailNotificator implements iNotificator {

    private $email;
    private $text;
    public function __construct(iUser $user,$text)
    {

        $this->text = $text;
        $this->email = $user->email;
    }

    public function send(){

        echo "send {$this->text} to mail {$this->email}";

    }
}


$service = new NotificationService();


$users = [new User('test1','1111'),new User('test2','2222')];
$text = 'some text';
foreach ($users as $user) {
    $service->notify($user, $text);
}