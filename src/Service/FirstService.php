<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class FirstService
{
    public function __construct(private $devName, private LoggerInterface $logger) {}
    public function getRandomString($nb = 5): string {
        $char = 'azertyuiopqsdfghjklmwxcvbn0123456789';
        $this->logger->info("Dévellopé par : ".$this->devName.' '.$char);
        $chaine = str_shuffle($char);
        return substr($chaine,0,$nb);
    }
    public function sayHello(): void {
        echo "Hello";
    }

}