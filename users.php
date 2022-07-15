<?php
//Define Dirpath for hooks
define('USERS_PATH', __DIR__);
/**
 * Plugin Name: Users List
 * Version: 1.0
 * Description: Get Users list from third-party API
 * Author: Asad Maqsood
 * Author URI: 
 * Plugin URI: 
 */


require_once(USERS_PATH . '/inc/UsersList.php');

$userList = new UsersList();

$userList->action_hooks();
