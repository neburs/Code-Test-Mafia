<?php

/**
 * The strategy for release a member. This strategy is
 * possible to expand using the Strategy pattern.
 *
 * @author Ruben Vasallo
 */

namespace Domain\Handlers;

use Domain\Core\Member;
use Domain\Core\Status;

class ReleaseMemberHandler
{
    /**
     * Release the member requested and immediately
     * recovers his old position in the organization
     * (meaning that he will have the same boss that he
     * had at the moment of being imprisoned). All his
     * former direct subordinates are transferred to
     * work for the recently released member, even if
     * they were previously promoted or have a
     * different boss now.
     *
     * @param Member $member
     *
     * @return Member Returns the Member Requested with
     *                the status changed
     */
    public static function release(Member $member)
    {
        $status = new Status();
        $status->setFree();
        $member->setStatus($status);

        self::relocateMembers($member);

        return $member;
    }

    /**
     * @param Member $member
     */
    private function relocateMembers(Member $member)
    {
        $membersUnderControl = $member->getPeopleUnderControl();

        foreach ($membersUnderControl->keys() as $key) {
            $memberTmp = $membersUnderControl->getMember($key);
            $memberTmpBoss = $memberTmp->getBoss();
            if (!is_null($memberTmpBoss)) {
                self::deleteMember(
                    $memberTmpBoss->getPeopleUnderControl(),
                    $memberTmp
                );
            }

            $memberTmp->setBoss($member);
        }
    }

    /**
     * @param MembersCollection $membersUnderControl
     * @param Member            $memberToDelete
     */
    private function deleteMember(
        $membersUnderControl,
        $memberToDelete
    ) {
        foreach ($membersUnderControl->keys() as $key) {
            $memberTmp = $membersUnderControl->getMember($key);

            if ($memberTmp === $memberToDelete) {
                $membersUnderControl->deleteMember($key);
                break;
            }
        }
    }
}
