<?php

/**
 * Builds a tree chart of Members from an array
 *
 * @author Ruben Vasallo
 *
 */

namespace Domain\Builders;

use Domain\Core\Member;

class BuildMembersFromArray
{
    /**
     * Builds a tree chart of Members from an array and return
     * The Member with the most level of the organization.
     * The array must follow the next structure:
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
     *
     * @param array $data
     *
     * @return Member|null
     */
    public static function build($data)
    {
        return self::buildMember($data);
    }

    /**
     * @param array       $data
     * @param Member|null $boss
     *
     * @return Member|null
     */
    private function buildMember($data, $boss = null)
    {
        $member = null;
        if (!empty($data)) {
            $member = new Member(
                $data['name'],
                BuildStatusFromString::build($data['status']),
                $boss
            );
            if (array_key_exists('peopleUnderControl', $data)
                && !is_null($data['peopleUnderControl'])
            ) {
                foreach ($data['peopleUnderControl'] as $memberUnderControl) {
                    $memberTmp = self::buildMember(
                        $memberUnderControl,
                        $member
                    );
                    if (!is_null($memberTmp)) {
                        $member->addMemberUnderControl(
                            $memberTmp
                        );
                    }
                }
            }
        }

        return $member;
    }
}
