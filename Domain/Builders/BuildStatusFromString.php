<?php

/**
 * Builds a status object from string
 *
 * @author Ruben Vasallo
 */

namespace Domain\Builders;

use Domain\Core\Status;

class BuildStatusFromString
{
    /**
     * Builds a status object from string
     * @param string $status
     *
     * @return Status
     */
    public static function build($status)
    {
        $statusFinal = new Status();
        if ('IN JAIL' == $status) {
            $statusFinal->setInJain();
        }

        return $statusFinal;
    }
}
