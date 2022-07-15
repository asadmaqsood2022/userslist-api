<?php
get_header();

$users = "";
if (get_transient('userApiData', 'apiD', true)) {
    $users = get_transient('userApiData', 'apiD');
    //$users = json_decode(stripslashes($api['body']));
} else {
    $api = wp_remote_get("https://jsonplaceholder.typicode.com/users/");
    $users = json_decode(stripslashes($api['body']));
    set_transient('userApiData', $users, 120);
}
?>
<?php
wp_nonce_field();
?>
<table class="user_table">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Username</th>
        <th>More Details</th>
    </tr>
    <?php
    foreach ($users as $user) {
    ?>
        <tr>
            <td><?php echo $user->id ?></td>
            <td><?php echo $user->name ?></td>
            <td><?php echo $user->username ?></td>
            <td> <a class=" button view-detials" data-id="<?php echo $user->id ?>">View</a> </td>

        </tr>
    <?php
    }
    ?>
</table>
<div id="show-details"></div>
<?php
get_footer();
