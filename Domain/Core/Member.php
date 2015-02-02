<?php

/**
 * Represents a Member of the chart with all attributes
 * from him
 *
 * @author Ruben Vasallo
 */

namespace Domain\Core;

use Domain\Exceptions\MemberException;

class Member
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var Member $boss
     */
    private $boss;

    /**
     * @var Status $status
     */
    private $status;

    /**
     * @var \Domain\Core\MembersCollection $peopleUnderControl
     */
    private $peopleUnderControl;

    /**
     * @param string       $name
     * @param Status       $status
     * @param Member       $boss
     * @param array()|null $peopleUnderControl Array
     *                                         of Members
     */
    public function __construct(
        $name,
        Status $status,
        Member $boss = null,
        $peopleUnderControl = null
    ) {
        $this->name = $name;
        $this->status = $status;

        if (!is_null($boss)) {
            $this->boss = $boss;
        }

        $this->peopleUnderControl = new MembersCollection();
        if (!empty($peopleUnderControl)) {
            foreach ($peopleUnderControl as $member) {
                $this->peopleUnderControl->addMemberUnderControl($member);
            }
        }
    }

    /**
     * Returns the level of the member under the
     * organization that pertain
     *
     * @return int
     */
    public function getLevel()
    {
        $level = 0;
        if (!is_null($this->boss)) {
            $memberTmp = $this;
            while (!is_null($memberTmp = $memberTmp->getBoss())) {
                $level++;
            } ;
        }

        return $level;
    }

    /**
     * Returns all the Members of the organization that
     * they have the level specified under the
     * organization that pertain the actual member
     * (from the top)
     *
     * @param int $levelToSearch Level of search
     *
     * @return array|null Array of Members
     */
    public function getLevelPeopleUnderControlFromTop($levelToSearch)
    {
        $boss = $this->getBoss();
        if (is_null($boss)) {
            return $this->getLevelPeopleUnderControl($levelToSearch);
        } else {
            return $boss->getLevelPeopleUnderControlFromTop($levelToSearch);
        }
    }

    /**
     * Returns all the Members under control of the
     * actual member that they have the level specified
     * under the organization (from the actual Member)
     *
     * @param int $levelToSearch
     * @param int $actualLevel
     *
     * @return array|null
     */
    public function getLevelPeopleUnderControl(
        $levelToSearch,
        $actualLevel = 0
    ) {
        if (!$this->getStatus()->isFree()) {
            return null;
        } elseif ($levelToSearch == $actualLevel) {
            return array($this);
        } elseif (0 == $this->peopleUnderControl->length()) {
            return null;
        } else {
            $peopleUnderControl = array();
            foreach ($this->peopleUnderControl->keys() as $key) {
                $memberActual = $this->peopleUnderControl->getMember($key);

                $listMembers = $memberActual->getLevelPeopleUnderControl(
                    $levelToSearch,
                    $actualLevel + 1
                );

                if (!empty($listMembers)) {
                    $peopleUnderControl = array_merge(
                        $peopleUnderControl,
                        $listMembers
                    );
                }
            }
            return $peopleUnderControl;
        }
    }

    /**
     * Returns the total number of members that the
     * actual member have under control (including all
     * subordinates).
     * Only count the members of free status.
     *
     * @return int
     */
    public function totalPeopleUnderControl()
    {
        if (!$this->getStatus()->isFree()) {
            return 0;
        } elseif (0 == $this->peopleUnderControl->length()) {
            return 0;
        } else {
            $peopleUnderControl = $this->peopleUnderControl->length();
            foreach ($this->peopleUnderControl->keys() as $key) {
                $memberActual = $this->peopleUnderControl->getMember($key);

                $peopleUnderControl += $memberActual->totalPeopleUnderControl();
            }
            return $peopleUnderControl;
        }
    }

    /**
     * Adds a member under the control of the actual
     * member.
     *
     * @param Member $memberToAdd
     */
    public function addMemberUnderControl(Member $memberToAdd)
    {
        $this->peopleUnderControl->addMember($memberToAdd, $this);
    }

    /**
     * Check if exist a loop in the chart graph
     *
     * @param Member $memberToDetect
     *
     * @return bool
     */
    public function isALoop(Member $memberToDetect)
    {
        $isALoop = false;
        $boss = $this->getBoss();
        if (!is_null($boss)) {
            if ($boss === $memberToDetect) {
                $isALoop = true;
            } else {
                $isALoop = $boss->isALoop($memberToDetect);
            }
        }

        return $isALoop;
    }

    /**
     * @return \Domain\Core\Member
     */
    public function getBoss()
    {
        return $this->boss;
    }

    /**
     * Set the boss from this member.
     * Launch an exception if this assignment create
     * a loop.
     *
     * @param \Domain\Core\Member|null $boss
     *
     * @throws \Domain\Exceptions\MemberException
     */
    public function setBoss($boss)
    {
        if (!is_null($boss)) {
            if ($boss->isALoop($this)) {
                throw new MemberException(array(
                    'code' => 1,
                    'member' => $boss->getName(),
                ));
            }
        }

        $this->boss = $boss;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Domain\Core\MembersCollection
     */
    public function getPeopleUnderControl()
    {
        return $this->peopleUnderControl;
    }

    /**
     * @return \Domain\Core\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \Domain\Core\Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Returns a representation of chart graph from the
     * actual member in array format.
     * (only show the members with free status)
     *
     * @return array|null With the next structure:
     * array(
     *   'name' => 'name',
     *   'status' => 'status',
     *   'peopleUnderControl' => array(
     *       array(
     *           'name' => 'name',
     *           'status' => 'status',
     *           'peopleUnderControl' => array(...) or null
     *      ),
     *      array(...)
     *   ),
     * )
     */
    public function __toArray()
    {
        if ($this->getStatus()->isFree()) {
            return array(
                'name' => $this->name,
                'status' => (string)$this->status,
                'peopleUnderControl' => $this->peopleUnderControl->__toArray()
            );
        } else {
            return null;
        }
    }
}
