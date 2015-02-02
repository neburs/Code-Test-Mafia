<?php

/**
 * Test to check if the functionality of jail member
 * works.
 *
 * @author Ruben Vasallo
 */

namespace Tests\Integration;

use Domain\Builders\BuildMembersFromArray;
use Domain\Handlers\JailMemberHandler;

class JailMemberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function testJailMember($dataTest, $result)
    {
        $chart = BuildMembersFromArray::build($dataTest);

        $memberToJail = $this->findMemberToJail($chart);

        JailMemberHandler::jail($memberToJail);

        if (is_null($chart->__toArray())) {
            $chart = $chart->getPeopleUnderControl()->getMember(0);
        }

        $this->assertEquals(
            $result,
            $chart->__toArray(),
            'Error to Jail A Member'
        );
    }

    /**
     * Helper to find the member to jail.
     * This function find a member with the name
     * "member to jail" in the chart graph of pertain
     * the member requested.
     *
     * @param Member $chart
     *
     * @return Member|null
     */
    private function findMemberToJail($chart)
    {
        if (is_null($chart)) {
            return null;
        } elseif ('member to jail' == $chart->getName()) {
            return $chart;
        } else {
            $membersUnderControl = $chart->getPeopleUnderControl();
            $memberFound = null;
            foreach ($membersUnderControl->keys() as $key) {
                $memberFound = $this->findMemberToJail(
                    $membersUnderControl->getMember($key)
                );

                if (!is_null($memberFound)) {
                    break;
                }
            }
            return $memberFound;
        }
    }

    public function provider()
    {
        return array(
            array(
                array(
                    'name' => 'boss level 0',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        ),
                        array(
                            'name' => 'member to jail',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => array(
                                        array(
                                            'name' => 'boss level 3',
                                            'status' => 'FREE',
                                            'peopleUnderControl' => null
                                        )
                                    )
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        )
                    ),
                ),
                array(
                    'name' => 'boss level 0',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => array(
                                        array(
                                            'name' => 'boss level 3',
                                            'status' => 'FREE',
                                            'peopleUnderControl' => null
                                        )
                                    )
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        ),
                        null
                    ),
                )
            ),
            array(
                array(
                    'name' => 'member to jail',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => array(
                                        array(
                                            'name' => 'boss level 3',
                                            'status' => 'FREE',
                                            'peopleUnderControl' => null
                                        )
                                    )
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        ),
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        )
                    ),
                ),
                array(
                    'name' => 'boss level 1',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 2',
                            'status' => 'FREE',
                            'peopleUnderControl' => null
                        ),
                        array(
                            'name' => 'boss level 2',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 3',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        ),
                        array(
                            'name' => 'boss level 2',
                            'status' => 'FREE',
                            'peopleUnderControl' => null
                        ),
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        )
                    )
                )
            ),
            array(
                array(
                    'name' => 'boss level 0',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                array(
                                    'name' => 'member to jail',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
                                )
                            )
                        )
                    ),
                ),
                array(
                    'name' => 'boss level 0',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'FREE',
                            'peopleUnderControl' => array(
                                null
                            )
                        )
                    ),
                )
            ),
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
