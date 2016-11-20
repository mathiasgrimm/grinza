<?php

use Grinza\Http\Response;

class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function default_constructor_works()
    {
        $resp = new Response();

        $this->assertEquals(200          , $resp->getHttpStatus());
        $this->assertEquals(''           , $resp->getContent());
        $this->assertEquals('text/plain' , $resp->getContentType());
        $this->assertEquals('1.1'        , $resp->getHttpVersion());
        $this->assertEquals([]           , $resp->getHeaders());
    }

    /**
     * @test
     */
    public function constructor_sets_values()
    {
        $resp = new Response('[content]', 'application/json', 503, '1.0', ['X-Custom-Header: 1']);

        $this->assertEquals(503                    , $resp->getHttpStatus());
        $this->assertEquals('[content]'            , $resp->getContent());
        $this->assertEquals('application/json'     , $resp->getContentType());
        $this->assertEquals('1.0'                  , $resp->getHttpVersion());
        $this->assertEquals(['X-Custom-Header: 1'] , $resp->getHeaders());
    }

    /**
     * @test
     */
    public function get_and_setters_work()
    {
        $resp = new Response();

        $resp->setHttpStatus(503);
        $resp->setContent('[content]');
        $resp->setContentType('application/json');
        $resp->setHttpVersion('1.0');
        $resp->setHeaders(['X-Custom-Header: 1']);

        $this->assertEquals(503                    , $resp->getHttpStatus());
        $this->assertEquals('[content]'            , $resp->getContent());
        $this->assertEquals('application/json'     , $resp->getContentType());
        $this->assertEquals('1.0'                  , $resp->getHttpVersion());
        $this->assertEquals(['X-Custom-Header: 1'] , $resp->getHeaders());
    }

    /**
     * @runInSeparateProcess
     * @test
     */
    public function send_headers_works()
    {
        ob_start();
        $resp = new Response('[content]', 'application/json', 503, '1.0', ['X-Custom-Header: 1']);
        $resp->sendHeaders();
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEmpty($contents);

        $this->assertEquals(['Content-Type: application/json', 'X-Custom-Header: 1'], xdebug_get_headers());
        $this->assertEquals(503, http_response_code());
    }

    /**
     * @runInSeparateProcess
     * @test
     */
    public function send_works()
    {
        ob_start();
        $resp = new Response('[content]', 'application/json', 503, '1.0', ['X-Custom-Header: 1']);
        $resp->send();
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('[content]', $contents);

        $this->assertEquals(['Content-Type: application/json', 'X-Custom-Header: 1'], xdebug_get_headers());
        $this->assertEquals(503, http_response_code());
    }


}