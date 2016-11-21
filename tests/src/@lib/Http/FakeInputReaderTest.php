<?php

use Grinza\Http\InputReaderInterface;
use Grinza\Http\FakeInputReader;

class FakeInputReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_implements_InputReaderInterface()
    {
        $ir = new FakeInputReader();
        $this->assertInstanceOf(InputReaderInterface::class, $ir);
    }

    /**
     * @test
     */
    public function getters_and_setters_work()
    {
        $ir = new FakeInputReader();
        $ir->setContent("the content");

        $this->assertEquals("the content", $ir->getContent());
        $this->assertEquals("the content", $ir->read());
    }
}