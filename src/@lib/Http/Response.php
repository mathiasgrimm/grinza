<?php namespace Grinza\Http;

class Response
{
    private $httpStatus;
    private $content;
    private $contentType;
    private $headers;
    private $httpVersion;

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     * @return Response
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return Response
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return Response
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getHttpVersion()
    {
        return $this->httpVersion;
    }

    /**
     * @param string $httpVersion
     * @return Response
     */
    public function setHttpVersion(string $httpVersion)
    {
        $this->httpVersion = $httpVersion;
        return $this;
    }

    /**
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @param int $httpStatus
     * @return Response
     */
    public function setHttpStatus(int $httpStatus)
    {
        $this->httpStatus = $httpStatus;
        return $this;
    }

    public function __construct(
        $content      = '',
        $contentType  = 'text/plain',
        $httpStatus   = 200,
        $httpVersion  = '1.1',
        $headers      = []
    )
    {
        $this->content     = $content;
        $this->httpStatus  = $httpStatus;
        $this->httpVersion = $httpVersion;
        $this->contentType = $contentType;
        $this->headers     = $headers;
    }

    public function sendHeaders()
    {
        header("HTTP/{$this->httpVersion} {$this->httpStatus}");

        if ($this->contentType) {
            header('Content-Type: ' . $this->contentType);
        }

        foreach ($this->headers as $header) {
            header($header);
        }
    }

    public function send()
    {
        $this->sendHeaders();

        if ($this->content) {
            echo $this->content;
        }
    }
}