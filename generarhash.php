<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ianed\JwtApi\AuthService;

$auth = new AuthService();

echo $auth->hashPassword('admin123');
