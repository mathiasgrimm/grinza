<?php

use Grinza\Http\FakeInputReader;
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
        $request->setInputReader($ir = new FakeInputReader());

        $this->assertEquals(['files'], $request->getFiles());
        $this->assertEquals(['request'], $request->getRequest());
        $this->assertEquals(['server'], $request->getServer());
        $this->assertEquals($ir, $request->getInputReader());
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
     * @backupGlobals
     */
    public function it_creates_from_globals_for_non_json()
    {
        $_SERVER  = ['server_var'  => 'server_val'];
        $_REQUEST = ['request_var' => 'request_val'];
        $_FILES   = ['foles_var'   => 'request_val'];

        $request = new Request();
        $request->loadFromGlobals();

        $this->assertEquals($_SERVER  , $request->getServer());
        $this->assertEquals($_FILES   , $request->getFiles());
        $this->assertEquals($_REQUEST , $request->getRequest());
    }

    /**
     * @test
     * @runInSeparateProcess
     * @backupGlobals
     */
    public function it_creates_from_globals_for_json()
    {
        $_SERVER  = ['CONTENT_TYPE'  => 'application/json'];
        $_REQUEST = [];
        $_FILES   = [];

        $inputReader = new FakeInputReader();
        $inputReader->setContent('{"name":"mathias"}');

        $request = new Request();
        $request->setInputReader($inputReader);
        $request->loadFromGlobals();

        $this->assertEquals($_SERVER  , $request->getServer());
        $this->assertEquals($_FILES   , $request->getFiles());

        $this->assertEquals(['name' => 'mathias'], $request->getRequest());
    }

    /**
     * @test
     * @backupGlobals
     * @runInSeparateProcess
     */
    public function it_gets_raw_input_when_it_is_null()
    {
        $_SERVER  = ['CONTENT_TYPE'  => 'application/json'];

        $inputReader = new FakeInputReader();
        $request = new Request();
        $request->setInputReader($inputReader);
        $request->loadFromGlobals();

        $this->assertEquals([], $request->getRequest());
    }

    /**
     * @test
     */
    public function is_json_works()
    {
        $request = new Request();
        $this->assertFalse($request->isJson());

        $request = new Request(['CONTENT_TYPE' => 'application/json']);
        $this->assertTrue($request->isJson());

        $request = new Request(['CONTENT_TYPE' => 'json']);
        $this->assertTrue($request->isJson());
    }
}