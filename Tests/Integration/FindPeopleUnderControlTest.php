<?php

/**
 * Test to check if the functionality for get the
 * total members under control works.
 *
 * @author Ruben Vasallo
 */

namespace Tests\Integration;

use Domain\Builders\BuildMembersFromArray;

class FindPeopleUnderControlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provider
     */
    public function testGetTotalMembersUnderControl($dataTest, $numMembers)
    {
        $chart = BuildMembersFromArray::build($dataTest);

        $this->assertEquals(
            $numMembers,
            $chart->totalPeopleUnderControl(),
            'The number of People Under Control is incorrect'
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
                            'peopleUnderControl' => null
                        )
                    )
                ),
                3
            ),
            array(
                array(
                    'name' => 'boss level 0',
                    'status' => 'FREE',
                    'peopleUnderControl' => array(
                        array(
                            'name' => 'boss level 1',
                            'status' => 'IN JAIL',
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
                            'peopleUnderControl' => null
                        )
                    )
                ),
                2
            ),
            array(
                array(
                    'name' => 'boss level 0',
                    'status' => 'IN JAIL',
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
                            'peopleUnderControl' => null
                        )
                    )
                ),
                0
            )
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
