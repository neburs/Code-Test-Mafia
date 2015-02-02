<?php

/**
 * The strategy for jail a member. This strategy is
 * possible to expand using the Strategy pattern.
 *
 * @author Ruben Vasallo
 */

namespace Domain\Handlers;

use Domain\Core\Member;
use Domain\Core\Status;

class JailMemberHandler
{
    /**
     * Jail the member requested and reorder the
     * organization using the next indications:
     * All the members under control are immediately
     * relocated and now work for the oldest remaining
     * boss at the same level as their previous boss.
     * If there is no such possible alternative boss the
     * oldest direct subordinate of the previous boss is
     * promoted to be the boss of the others.
     *
     * @param Member $member
     *
     * @return Member Returns the Member Requested with
     *                the status changed
     */
    public static function jail(Member $member)
    {
        $status = new Status();
        $status->setInJain();
        $member->setStatus($status);

        self::relocateMembers($member);

        return $member;
    }

    /**
     * @param Member $member
     */
    private function relocateMembers(Member $member)
    {
        $levelOfMember = $member->getLevel();
        $membersUnderControl = $member->getPeopleUnderControl();

        if (0 == $levelOfMember) {
            $memberNewBoss = $membersUnderControl->getMember(0);
            for ($i=1; $i < $membersUnderControl->length(); $i++) {
                self::setMemberBoss(
                    $membersUnderControl,
                    $memberNewBoss,
                    $i
                );
            }
            $memberNewBoss->setBoss(null);
        } else {
            $membersOfSameLevel = $member->getLevelPeopleUnderControlFromTop(
                $levelOfMember
            );
            if (!empty($membersOfSameLevel)) {
                $memberNewBoss = $membersOfSameLevel[0];
                foreach ($membersUnderControl->keys() as $key) {
                    self::setMemberBoss(
                        $membersUnderControl,
                        $memberNewBoss,
                        $key
                    );
                }
            }
        }
    }

    /**
     * @param MembersCollection $membersUnderControl
     * @param Member            $memberNewBoss
     * @param int               $key
     */
    private function setMemberBoss(
        $membersUnderControl,
        $memberNewBoss,
        $key
    ) {
        $memberToAdd = $membersUnderControl->getMember($key);
        $memberNewBoss->addMemberUnderControl(
            $memberToAdd
        );
    }
}
