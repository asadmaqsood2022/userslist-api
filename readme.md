
# Users List Plugin

 * Plugin Name: Users List
 * Version: 1.0
 * Description: Get Users list from third-party API
 * Author: Faran Shah
 * Author URI: https://faran.work/

## Requirements

1. PHP Version required 7.4 or above
2. Wordpress Version 5.8
3. Required Composer for unit testing and PHPCS dependencies
4. API for getting users data 
 

##  Installation & Usage instructions

1. Upload `users.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Open https://domain.com/my-lovely-users-table/



## Testing 

 * For unit testing, first you need to install composer then run 'composer install' in cmd (Command Prompt) in main plugin directory, this will install the required dependencies. 
 * We are using Brain Monkey and php unit for unit testing. After installation you can run this command 'vendor\bin\phpunit tests\UsersListTest.php', This command will execute tests/UsersListTest.php and will return the test results.
 * Test is written in this file UsersListTest.php is a unit test of the main plugin class which is located at nic/userslist.php. 
