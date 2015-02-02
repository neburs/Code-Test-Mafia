<?php

/**
 * The exceptions for the MembersCollection Class
 *
 * @author Ruben Vasallo
 */

namespace Domain\Exceptions;

use Exception;

class MembersCollectionException extends Exception
{
    public function __construct($params = array(), Exception $previous = null)
    {
        $code = 0;

        if (!is_array($params)) {
            $message = 'Error to construct the MembersCollectionException. Please check your code';
        } else {
            if (!array_key_exists('code', $params)) {
                $params['code'] = 0;
            }

            $code = $params['code'];

            switch ($code) {
                case 1:
                    $message = "The member ".$params['memberUnderControl']." is already under control of ".$params['member'];
                    break;
                case 2:
                    $message = "Undefined member with key ".$params['key'];
                    break;
                default:
                    $message = 'No code error send to construct the MembersCollectionException. Internal error on Core. Please check your code';
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
