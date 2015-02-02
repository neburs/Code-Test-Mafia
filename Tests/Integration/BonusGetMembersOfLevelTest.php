<?php

/**
 * Test to check if the functionality for get the
 * members of a specific level works.
 *
 * @author Ruben Vasallo
 */

namespace Tests\Integration;

use Domain\Builders\BuildMembersFromArray;

class BonusGetMembersOfLevelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function testGetMembersOfLevel($dataTest, $level, $results)
    {
        $chart = BuildMembersFromArray::build($dataTest);

        $membersOfLevel = $chart->getLevelPeopleUnderControlFromTop($level);

        $arrayResult = array();
        foreach ($membersOfLevel as $member) {
            $arrayResult[] = $member->__toArray();
        }

        $this->assertEquals(
            $results,
            $arrayResult,
            'The Members level found is incorrect'
        );
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
                        )
                    ),
                ),
                3,
                array(
                    array(
                        'name' => 'boss level 3',
                        'status' => 'FREE',
                        'peopleUnderControl' => null
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
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
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
                2,
                array(
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
                        'peopleUnderControl' => null
                    ),
                    array(
                        'name' => 'boss level 2',
                        'status' => 'FREE',
                        'peopleUnderControl' => null
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
                                    'status' => 'IN JAIL',
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
                                    'peopleUnderControl' => null
                                )
                            )
                        )
                    ),
                ),
                2,
                array(
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
                        'peopleUnderControl' => null
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
                                ),
                                array(
                                    'name' => 'boss level 2',
                                    'status' => 'FREE',
                                    'peopleUnderControl' => null
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
                1,
                array(
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
                                'peopleUnderControl' => null
                            )
                        )
                    )
                )
            )
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
