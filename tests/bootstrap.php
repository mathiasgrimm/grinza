<?php
error_reporting(-1);
ini_set('display_errors', 'on');

require __DIR__ . '/../vendor/autoload.php';

new MathiasGrimm\X\X();

\MathiasGrimm\ArrayPath\ArrayPath::registerClassAlias();