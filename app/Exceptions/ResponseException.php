<?php

namespace App\Exceptions;

use Exception;

class ResponseException extends Exception
{
    private $data;

    public function __construct($message, $data = [])
    {
        $this->data = $data;
        //  $this->_data = $data;
        parent::__construct($message);
    }

    public function getData()
    {
        return $this->data;
    }
}
