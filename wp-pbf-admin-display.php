
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

<div class="wrap">
<h2>Display System Resource Usage</h2>
        <?php $output = shell_exec('ps aux');
        echo "<pre>$output</pre>";
        require_once(ABSPATH . 'wp-config.php');
        ?>
<br><h2>Connection Strings</h2>
        <?php echo "Database Name: "; echo DB_NAME;?>
<br>
        <?php echo "Database User: "; echo DB_USER;?>
<br>
        <?php echo "Database Password: "; echo DB_PASSWORD;?>
<br>
        <?php echo "Database Host: "; echo DB_HOST;?>
<br>
        <?php echo "WP Debug Enabled: "; echo WP_DEBUG;?>
<br>



</div>
