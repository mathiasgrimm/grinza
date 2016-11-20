<?php

use Grinza\Http\Request;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function gets_and_sets_work()
    {
        $request = new Request([], [], []);

        $request->setFiles(['files']);
        $request->setRequest(['request']);
        $request->setServer(['server']);

        $this->assertEquals(['files'], $request->getFiles());
        $this->assertEquals(['request'], $request->getRequest());
        $this->assertEquals(['server'], $request->getServer());
    }

    /**
     * @test
     */
    public function get_works()
    {
        $request = new Request([], ['name' => 'mathias'], []);

        $this->assertEquals('mathias', $request->get('name'));
        $this->assertEquals('invalid', $request->get('surname', 'invalid'));
        $this->assertNull($request->get('surname'));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_creates_from_globals_for_non_json()
    {
        $_SERVER  = ['server_var'  => 'server_val'];
        $_REQUEST = ['request_var' => 'request_val'];
        $_FILES   = ['foles_var'   => 'request_val'];

        $request = Request::createFromGlobals();

        $this->assertEquals($_SERVER  , $request->getServer());
        $this->assertEquals($_FILES   , $request->getFiles());
        $this->assertEquals($_REQUEST , $request->getRequest());
    }

    /**
     * @test
     */
    public function it_creates_from_globals_for_json()
    {
        $_SERVER  = ['CONTENT_TYPE'  => 'application/json'];
        $_REQUEST = [];
        $_FILES   = [];

        // Create a stub for the SomeClass class.
        $stub = $this->getMockBuilder(Request::class)
            ->setMethods(['getRawInput'])
            ->getMock();

        // Configure the stub.
        $stub->method('getRawInput')
            ->willReturn('{"name":"mathias"}');

        $request = $stub->_createFromGlobals();

        $this->assertEquals($_SERVER  , $request->getServer());
        $this->assertEquals($_FILES   , $request->getFiles());

        $this->assertEquals(['name' => 'mathias'], $request->getRequest());
    }

    /**
     * @test
     */
    public function it_gets_raw_input_when_it_is_null()
    {
        $_SERVER  = ['CONTENT_TYPE'  => 'application/json'];
        $request = Request::createFromGlobals();
        $this->assertEquals([], $request->getRequest());
    }

}