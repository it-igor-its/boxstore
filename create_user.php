<?php

use common\models\User;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/common/config/bootstrap.php';

$config = require __DIR__ . '/console/config/main.php';

$application = new yii\console\Application($config);

$user = new User();
$user->username = 'admin';
$user->email = 'admin@test.com';
$user->setPassword('admin');
$user->generateAuthKey();
$user->status = 10;

$user->save();

echo "User created\n";