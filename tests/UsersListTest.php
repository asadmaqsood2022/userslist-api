<?php
//namespace users;
use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Actions;
use Brain\Monkey\Filters;

echo __DIR__ . '/../inc/UsersList.php';
require_once(__DIR__ . '/../inc/UsersList.php');
class UsersListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }
    public function test_hooks_and_filters_added()
    {
        $obj = new UsersList;
        self::assertTrue(has_action('init', $obj->action_hooks()));
        self::assertTrue(has_action('wp_enqueue_scripts', $obj->action_hooks()));
        self::assertTrue(has_action('wp_ajax_nopriv_get_user_details', $obj->action_hooks()));
        self::assertTrue(has_action('wp_ajax_get_user_details', $obj->action_hooks()));
        self::assertTrue(has_filter('request', $obj->action_hooks()));
        self::assertTrue(has_filter('template_include', $obj->action_hooks()));
    }
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}
