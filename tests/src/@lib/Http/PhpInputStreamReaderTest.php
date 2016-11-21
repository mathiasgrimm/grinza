<?php

use Grinza\Http\InputReaderInterface;
use Grinza\Http\PhpInputStreamReader;

class PhpInputStreamReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_implements_InputReaderInterface()
    {
        $ir = new PhpInputStreamReader();
        $this->assertInstanceOf(InputReaderInterface::class, $ir);
    }

    /**
     * @test
     */
    public function it_does_not_fail_when_input_is_empty()
    {
        $ir = new PhpInputStreamReader();
        $actual = $ir->read();

        $this->assertEmpty($actual);
    }
}