<?php

require_once dirname(__FILE__) . '/init.php';

$di = \PhalApi\DI();

$di->request = new \Core\Request\StaticRequest();

$di->response = new \Core\Response\WechatResponse();

$pai = new \PhalApi\PhalApi();

$pai->response()->output();
