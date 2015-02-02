<?php

/**
 * Unit test for BuildMembersFromArray
 *
 * @author Ruben Vasallo
 */

namespace Tests\Unit\Builders;

use Domain\Builders\BuildMembersFromArray;

class BuildMembersFromArrayTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @dataProvider provider
     */
    public function testBuildMembersFromArray($data)
    {
        $chart = BuildMembersFromArray::build($data);

        $this->assertEquals(
            $data,
            $chart->__toArray(),
            'The Build Member From Array was not built correctly'
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
                )
            )
        );
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
