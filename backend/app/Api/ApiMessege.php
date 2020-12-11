<?php
namespace App\Api;

class ApiMessege
{
    private $messeges;

    public function __construct( string $messeges, array $data = [] )
    {
        $this->messeges['messeges'] = $messeges;
        $this->messeges['error'] = $data;
    }

    public function getMessege()
    {
        return $this->messeges;
    }
}
