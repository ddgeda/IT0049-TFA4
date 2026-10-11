<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class AuthAccessTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testAccountRoutesRedirectWhenLoggedOut(): void
    {
        $getRoutes = [
            '/customers', '/customers/new', '/customers/edit/1',
            '/users', '/users/new', '/users/edit/1',
        ];
        $postRoutes = [
            '/customers/create', '/customers/update/1',
            '/users/create', '/users/update/1',
        ];

        foreach ($getRoutes as $route) {
            $this->withSession([])->get($route)->assertRedirectTo('/login');
        }

        foreach ($postRoutes as $route) {
            $this->withSession([])->post($route)->assertRedirectTo('/login');
        }
    }

    public function testLoggedInUserCanOpenNewAccountForms(): void
    {
        $session = ['isLoggedIn' => true, 'username' => 'test-user'];

        $this->withSession($session)->get('/customers/new')->assertOK();
        $this->withSession($session)->get('/users/new')->assertOK();
    }

    public function testLogoutRedirectsToLogin(): void
    {
        $this->withSession(['isLoggedIn' => true])->get('/logout')->assertRedirectTo('/login');
    }
}