<?php

/**
 * Unit test for Member
 *
 * @author Ruben Vasallo
 */

namespace Tests\Unit\Core;

use Domain\Core\Member;
use Domain\Core\Status;

class MemberTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test for sure to throw exception when detect
     * a loop
     * @test
     * @expectedException \Domain\Exceptions\MemberException
     * @expectedExceptionCode 1
     */
    public function testDetectLoopOfMembers()
    {
        $dummyMember = new Member(
            'test',
            new Status()
        );

        $dummyMemberBoss = $this->getMockBuilder('Domain\Core\Member')
            ->disableOriginalConstructor()
            ->setMethods(array('getBoss'))
            ->getMock();

        $dummyMemberBoss->expects($this->any())
            ->method('getBoss')
            ->will($this->returnValue($dummyMember));

        $dummyMember->setBoss($dummyMemberBoss);
    }

    public function tearDown()
    {

        parent::tearDown();
    }
}
