<?php

namespace common\tests\unit\models;

use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testEmailValidation()
    {
        $user = new User();

        $user->email = 'not-an-email';
        verify($user->validate(['email']))->false();

        $user->email = 'user@gmail.com';
        verify($user->validate(['email']))->true();
    }
}