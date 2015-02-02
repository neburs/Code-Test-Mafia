<?php

/**
 * Builds a collection of members
 *
 * @author Ruben Vasallo
 */

namespace Domain\Core;

use Domain\Exceptions\MembersCollectionException;

class MembersCollection
{
    private $members = array();

    /**
     * Adds a member in the collection and set the boss
     * member indicated to him.
     * This function return an exception if the member
     * is already in the collection.
     *
     * @param Member $memberToAdd
     * @param Member $memberBoss
     *
     * @throws \Domain\Exceptions\MembersCollectionException
     */
    public function addMember(Member $memberToAdd, Member $memberBoss)
    {
        if ($this->checkIfMemberIsInCollection($memberToAdd)) {
            throw new MembersCollectionException(array(
                'code' => 1,
                'member' => $memberToAdd->getName(),
                'memberUnderControl' => $memberBoss->getName()
            ));
        }
        $memberToAdd->setBoss($memberBoss);
        $this->members[] = $memberToAdd;
    }

    /**
     * Returns a Member identified with the number
     * requested in the collection. (0 to the most old)
     * This function throw a exception if in the
     * requested number not exist a member.
     *
     * @param int $key
     *
     * @return \Domain\Core\Member
     * @throws \Domain\Exceptions\MembersCollectionException
     */
    public function getMember($key)
    {
        if (isset($this->members[$key])) {
            return $this->members[$key];
        } else {
            throw new MembersCollectionException(array(
                'code' => 2,
                'key' => $key
            ));
        }
    }

    /**
     * Delete the member identified in the collection
     * and reorder the collection for avoid empty keys.
     *
     * @param int $key
     *
     * @throws \Domain\Exceptions\MembersCollectionException
     */
    public function deleteMember($key)
    {
        if (isset($this->members[$key])) {
            unset($this->members[$key]);
            $this->members = array_values($this->members);
        } else {
            throw new MembersCollectionException(array(
                'code' => 2,
                'key' => $key
            ));
        }
    }

    /**
     * Return an array with the identification (keys)
     * of members in the collection.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->members);
    }

    /**
     * Returns the total of members in the collection
     *
     * @return int
     */
    public function length()
    {
        return count($this->members);
    }

    /**
     * Returns an array with the representation of
     * chart graph from all the members in the
     * collection.
     * (only show the members with free status)
     *
     * @see \Domain\Core\Member::__toArray()
     *
     * @return array|null
     */
    public function __toArray()
    {
        if (!empty($this->members)) {
            $members = array();
            foreach ($this->members as $member) {
                $members[] = $member->__toArray();
            }
            return $members;
        } else {
            return null;
        }
    }

    /**
     * @param Member $memberToCheck
     *
     * @return bool
     */
    private function checkIfMemberIsInCollection(Member $memberToCheck)
    {
        $found = false;
        foreach ($this->members as $member) {
            if ($memberToCheck === $member) {
                $found = true;
                break;
            }
        }

        return $found;
    }
}
