<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 10.03.2019
 * Time: 21:52
 */

if ($_REQUEST['method_name'] == 'login') {
    $newUser = new \classes\User();

    try {
        $result = $newUser->login($_REQUEST);
        if ($result) {
            setcookie('token', $result['token'], strtotime('+2 week'), '/');
            setcookie('verified', 1, strtotime('-2 week'), '/');
            header("Location: /");
        } else {
            setcookie('verified', 'You have to verify your email', strtotime('+2 week'), '/');
            header("Location: /");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        if ($e->getCode() == 3) {
            setcookie('verified', $e->getMessage(), strtotime('+2 week'), '/');
            header("Location: /");
        } else {
            echo $e->getMessage();
        }
    }
    exit;
}

if ($_REQUEST['method_name'] == 'confirm_email' && $_REQUEST['token']) {
    $newUser = new \classes\User();

    try {
        $result = $newUser->confirm($_REQUEST['token']);
        if ($result) {
            setcookie('token', $result['token'], strtotime('+2 week'), '/');
            setcookie('verified', 1, strtotime('-2 week'), '/');
            header("Location: /");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit;
}