<?php

require __DIR__ . '/../../vendor/autoload.php';

new MathiasGrimm\X\X();

\MathiasGrimm\ArrayPath\ArrayPath::registerClassAlias();

$response = new \Grinza\Http\Response();

$response->setContent('<h1>oi</h1>');
$response->setContentType('text/html');
$response->setHttpStatus(200);
//$response->setHttpVersion('2.0');
//$response->setHeaders([
//    'Mathias: 1',
//    'Karine: 1'
//]);

//ob_start();

$response->send();

//pd(http_response_code());
//pd(headers_list());

//$content = ob_get_contents();

//ob_end_clean();



