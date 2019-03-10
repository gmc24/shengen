<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 10.03.2019
 * Time: 17:47
 */

namespace tests;

require_once "../../settings.php";

use classes\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testLogin() {
        $result = (new User())->login([
            "email" => "test@te.st",
            "pass" => 123
        ]);

        $this->assertTrue(is_array($result) || is_bool($result));
    }

    public function testConfirm() {
        $result = (new User())->confirm("fa0e466270f0ca893859cb692945384e");

        $this->assertTrue(is_array($result) || is_null($result));
    }
}
