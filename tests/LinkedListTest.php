<?php

require_once dirname(__FILE__) . '/../LinkedList.php';

/**
 * Test class for LinkedList.
 * Generated by PHPUnit on 2013-03-03 at 17:28:38.
 */
class LinkedListTest extends PHPUnit_Framework_TestCase {

    /**
     * @var LinkedList
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new LinkedList;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @todo Implement testInsert().
     */
    public function testInsert() {
        for($i=0;$i<100;$i++)
            $this->object->insert($i);
        $this->assertEquals(100,$this->object->getCount());
    }

    /**
     * @todo Implement testGetElement().
     */
    public function testGetElement() {
        $this->object->goBegin();
        $this->object->insert(1);
        $this->object->goBegin();
        $this->assertEquals(1,$this->object->getElement());
    }

    /**
     * @todo Implement testRemove().
     */
    public function testRemove() {
        $this->object->goBegin();
        $this->object->insert(1);
        $c = $this->object->getCount();
        $this->object->goBegin();
        $this->object->remove();
        $this->assertEquals($c-1,$this->object->getCount());
    }

    /**
     * @todo Implement testForward().
     */
    public function testForward() {
        $this->object->goBegin();
        $this->object->insert(1);
        $this->object->insert(2);
        $this->object->goBegin();
        $this->assertEquals(1,$this->object->getElement());
        $this->object->forward();
        $this->assertEquals(2,$this->object->getElement());
    }

    /**
     * @todo Implement testEnd().
     */
    public function testEnd() {
        // Remove the following lines when you implement this test.
        while(!$this->object->end())
            $this->object->forward ();
        $this->assertTrue($this->object->end());
        $this->assertFalse($this->object->getElement());
    }

    /**
     * @todo Implement testGoBegin().
     */
    public function testGoBegin() {
        $this->object->goBegin();
        $this->object->insert(1);
        $this->object->insert(2);
        $this->object->goBegin();
        $this->assertEquals(1,$this->object->getElement());
    }

    /**
     * @todo Implement testClear().
     */
    public function testClear() {
        for($i=0;$i<100;$i++)
            $this->object->insert($i);
        $this->object->clear();
        $this->assertEquals(0,$this->object->getCount());
    }

    /**
     * @todo Implement testGetCount().
     */
    public function testGetCount() {
        $this->object->goBegin();
        $this->object->insert(1);
        $c = $this->object->getCount();
        $this->object->insert(2);
        $this->assertEquals($c+1,$this->object->getCount());
    }

    /**
     * @todo Implement testFindElement().
     */
    public function testFindElement() {
        $this->assertFalse($this->object->findElement(1));
        $this->object->goBegin();
        $this->object->insert(1);
        $this->assertEquals(1,$this->object->findElement(1));
        $this->assertFalse($this->object->findElement(100));
    }

}

?>
