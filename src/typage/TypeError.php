<?php
/** Copyright (C) 2015 Magyar Máté dev@mmagyar.com all rights reserved */


namespace mmagyar\typage;


use Exception;

class TypeError extends Exception {
    public function __construct($message, $code = -32602, Exception $previous=null) {
        parent::__construct($message, $code, $previous);
    }
}