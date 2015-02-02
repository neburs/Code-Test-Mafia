<?php

/**
 * Unit test for MembersCollection
 *
 * @author Ruben Vasallo
 */

namespace Tests\Unit\Core;

use Domain\Core\MembersCollection;

class MembersCollectionTest extends \PHPUnit_Framework_TestCase
{
    private $dummyMember;
    private $dummyMemberBoss;

    public function setUp()
    {
        $this->dummyMember = $this->getMockBuilder('Domain\Core\Member')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->dummyMemberBoss = $this->getMockBuilder('Domain\Core\Member')
            ->disableOriginalConstructor()
            ->setMethods(array('getBoss'))
            ->getMock();
    }

    /**
     * @test
     */
    public function testAddMember()
    {
        $collection = new MembersCollection();
        $collection->addMember($this->dummyMember, $this->dummyMemberBoss);

        $this->assertEquals(
            $this->dummyMember,
            $collection->getMember(0),
            'Fail to add Member 0 in MembersCollection'
        );

        $dummyMember2 = $this->getMockBuilder('Domain\Core\Member')
            ->disableOriginalConstructor()
            ->getMock();

        $collection->addMember($dummyMember2, $this->dummyMemberBoss);

        $this->assertEquals(
            $dummyMember2,
            $collection->getMember(1),
            'Fail to add the Member 1 in MembersCollection'
        );
    }

    /**
     * Test for sure to throw exception when add a
     * member two times
     *
     * @test
     * @expectedException \Domain\Exceptions\MembersCollectionException
     * @expectedExceptionCode 1
     */
    public function testAddMemberTwoTimes()
    {
        $collection = new MembersCollection();
        $collection->addMember($this->dummyMember, $this->dummyMemberBoss);
        $collection->addMember($this->dummyMember, $this->dummyMemberBoss);
    }

    /**
     * Test for sure to throw exception when detect
     * a loop
     *
     * @test
     * @expectedException \Domain\Exceptions\MemberException
     * @expectedExceptionCode 1
     */
    public function testDetectLoopOfMembers()
    {
        $this->dummyMemberBoss->expects($this->any())
            ->method('getBoss')
            ->will($this->returnValue($this->dummyMember));

        $collection = new MembersCollection();
        $collection->addMember($this->dummyMember, $this->dummyMemberBoss);
    }

    /**
     * Test for sure to throw exception when request
     * a undefined member
     *
     * @test
     * @expectedException \Domain\Exceptions\MembersCollectionException
     * @expectedExceptionCode 2
     */
    public function testGetMemberUndefined()
    {
        $collection = new MembersCollection();
        $collection->getMember(0);
    }

    /**
     * Test for sure to throw exception when delete
     * a undefined member
     *
     * @test
     * @expectedException \Domain\Exceptions\MembersCollectionException
     * @expectedExceptionCode 2
     */
    public function testDeleteMemberUndefined()
    {
        $collection = new MembersCollection();
        $collection->deleteMember(0);
    }

    public function tearDown()
    {
        unset(
            $this->dummyMember,
            $this->dummyMemberBoss
        );

        parent::tearDown();
    }
}
