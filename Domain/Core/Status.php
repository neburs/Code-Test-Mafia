<?php

/**
 * Build a Status Object
 *
 * @author Ruben Vasallo
 */

namespace Domain\Core;

class Status
{
    /**
     * For indicate the status free
     */
    const FREE = 'FREE';
    /**
     * For indicate the status in jail
     */
    const IN_JAIL = 'IN JAIL';

    /**
     * @var string $status
     */
    private $status;

    /**
     * Build a Status Object and set by default the
     * status to free
     */
    public function __construct()
    {
        $this->setFree();
    }

    /**
     * Set the status to free
     */
    public function setFree()
    {
        $this->status = self::FREE;
    }

    /**
     * Set the status to in jail
     */
    public function setInJain()
    {
        $this->status = self::IN_JAIL;
    }

    /**
     * @return bool
     */
    public function isFree()
    {
        return self::FREE == $this->status;
    }

    /**
     * @return bool
     */
    public function isInJail()
    {
        return self::IN_JAIL == $this->status;
    }

    public function __toString()
    {
        return $this->status;
    }
}
