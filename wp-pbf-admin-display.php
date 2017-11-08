
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/paranoia1906/
 * @since      1.0.0
 *
 * @package    Wp_Pbf
 * @subpackage Wp_Pbf/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
?>
<?php require_once(ABSPATH . 'wp-config.php');?>

<div class="wrap">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<h1>WordPress Print Basic Facts</h1>
<div class="col-xs-6">

<pre><h3>Display System Resource Usage</h3>
<?php $output = shell_exec('ps aux');echo $output?></pre>
<pre><h3>Connection Facts</h3>
<?php echo "Database Name: "; echo DB_NAME;?><br>
<?php echo "Database User: "; echo DB_USER;?><br>
<?php echo "Database Password: "; echo DB_PASSWORD;?><br>
<?php echo "Database Host: "; echo DB_HOST;?><br>
<?php echo "WP Debug Enabled: "; echo WP_DEBUG;?><br>
<?php echo "Site URL: ";echo site_url();?><br>
<?php echo "Number of Database Queries: ";echo get_num_queries();?><br>
<?php echo "Current PHP Version: ";echo phpversion()?><br>
<?php echo "Current WP Version: ";global $wp_version;echo $wp_version?><br>
<?php echo "Current DB Version: ";global $wp_db_version;echo $wp_db_version?><br>
</pre>

    
// Shell exec tool to show the contents for WP Install dir. 
// Will show permissions and hidden files.
<div class="col-xs-6">
<pre><h3>Display File System for: <?php $pwd = shell_exec('cd .. && pwd');echo $pwd?></h3>
<?php $list = shell_exec('cd .. && ls -la');echo $list?></pre>
//Ending the shell exec tool for listing dir.    
    
// This block uses WordPress functions to show all pages and return links for the returned pages.
    //Still to fix - Links not functional for posts still in draft/not published. - Should null these.
<pre><?php $page_ids=get_all_page_ids();echo '<h3>My Page List :</h3>';foreach($page_ids as $page){$uri = get_pageuri($page);echo '<br/>'.get_the_title($page);echo '<a href="'. $uri .'"> - Link to page</a>';} ?></pre>
// This block is ended. 
    
// Here we have a block dedicated to showing all admin users.
<pre><h3>Admin Users List</h3><?php
// The Query for admin users
$user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
// User Loop - to pull all active users.
if ( ! empty( $user_query->results ) ) {
        foreach ( $user_query->results as $user ) {
                echo '<p>' . $user->display_name . '</p>';
        }
} else {
        echo 'No users found.';
}?></pre>
// End block to show admin users.
    
</div>
</div>

