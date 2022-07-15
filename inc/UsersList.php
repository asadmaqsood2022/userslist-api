<?php
if (!class_exists('UsersList')) {
    class UsersList
    {
        //adding actions and filters
        public function action_hooks()
        {
            add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
            add_action('wp_ajax_nopriv_get_user_details', [$this, 'get_user_details']);
            add_action('wp_ajax_get_user_details', [$this, 'get_user_details']);
            add_action('init', [$this, 'adding_rewrite']);
            add_filter('request', [$this, 'query_var_request']);
            add_filter('template_include', [$this, 'template_include']);
        }
        //Added query var for custom endpoint
        public function query_var_request($vars)
        {
            if (isset($vars['my-lovely-users-table'])) {
                $vars['my-lovely-users-table'] = true;
            }
            return $vars;
        }
        //Adding template for showing api response data
        public function template_include($template)
        {
            if (get_query_var('my-lovely-users-table')) {
                $post = get_queried_object();
                return __DIR__ . '/add-endpoint.php';
            }
            return $template;
        }

        // Adding Rewrite
        public function adding_rewrite()
        {
            flush_rewrite_rules();
            add_rewrite_endpoint('my-lovely-users-table', EP_ALL, true);
        }
        /**
         * Get User By Id
         */
        public function get_user_details()
        {
            $id = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : '';
            $nounce = isset($_POST['nounce']) ? sanitize_text_field($_POST['nounce']) : '';
            if (empty($id) || wp_verify_nonce($nounce) == false) {
                wp_send_json_error(array('message' => 'ID not found'));
            }
            $data = get_transient('userApiData', 'apiD');
            if ($data) {
                $users = array_shift(wp_filter_object_list($data, array('id' => $id)));
            } else {
                $api = wp_remote_get('https://jsonplaceholder.typicode.com/users/');
                $users = json_decode(stripslashes($api['body']));
                set_transient('userApiData', $users, 120);
                $data = get_transient('userApiData', 'apiD');
                $users = array_shift(wp_filter_object_list($data, array('id' => $id)));
            }

            // wp_verify_nonce(sanitize_text_field($_POST['nounce']));
            $response = sprintf('<table>
                <tr>
                    <td>User ID</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>User Email</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>%s %s %s</td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td>%s</td>
                </tr>
                <tr>
                    <td>Company</td>
                    <td>%s</td>
                </tr>
            </table>', $users->id, $users->name, $users->username, $users->email, $users->address->street, $users->address->suite, $users->address->city, $users->phone, $users->website, $users->company->name);

            wp_send_json_success(array(
                'message' => $response
            ));
        }
        public  function wp_enqueue_scripts()
        {
            //wp enqueue scripts code in here
            wp_register_script('jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, true);
            wp_enqueue_script('jQuery');
            wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . '../assets/js/custom.js');
            wp_localize_script('custom-js', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));
        }
        // class end
    }
}
