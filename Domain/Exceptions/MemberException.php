<?php

/**
 * The exceptions for the Member Class
 *
 * @author Ruben Vasallo
 */

namespace Domain\Exceptions;

use Exception;

class MemberException extends Exception
{
    public function __construct($params = array(), Exception $previous = null)
    {
        $code = 0;

        if (!is_array($params)) {
            $message = 'Error to construct the MemberException. Please check your code';
        } else {
            if (!array_key_exists('code', $params)) {
                $params['code'] = 0;
            }

            $code = $params['code'];

            switch ($code) {
                case 1:
                    $message = "Detected loop of members. Please check the member ".$params['member'];
                    break;
                default:
                    $message = 'No code error send to construct the MemberException. Internal error on Core. Please check your code';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
