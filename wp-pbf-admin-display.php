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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

require_once(ABSPATH . 'wp-config.php');
include(ABSPATH.'wp-content/plugins/wp-pbf/includes/wp-pbf-functions.php');
echo systemsCheck();
?>
<h1>WordPress Print Basic Facts</h1>
<div class="container col-xs-6">
	<div class="panel panel-default">
		<div class="panel-heading">Display System Resource Usage</div>
		<div class="panel-body"><pre><?php echo shell_exec('ps aux')?></pre></div>

		<div class="panel-heading">Basic Facts</div>
		<div class="panel-body"><?php echo wpBasicFacts()?></div>

		<div class="panel-heading">Display File System for: <?php echo ABSPATH?></div>
		<div class="panel-body"><pre><?php echo fileSystemShell()?></pre></div>

<div class="panel-heading">Functions</div>
    <div class="panel-body">
      <form action="" method="Post">
    
  <input type="submit" name="inodes" value="Display Inodes Usage"><br>
</form>
<?php 
if(!is_callable('shell_exec')||(strpos(ini_get('disable_functions'), 'shell_exec') === true)){
      return '<h3>Shell Features Are Disabled. No Inode Count Functionality!</h3>';
    } else {
if (isset($_POST['inodes'])&&!empty($_POST['inodes'])){
  ?>
  <pre><?php
  $safepath=getcwd();
  chdir(ABSPATH);
  echo shellInodes();
  chdir($safepath);
  ?></pre>
  <?php
  }
  }
?>
    </div>




</div>
</div>
<div class="container col-xs-6">
<div class="panel panel-default">
    <div class="panel-heading">Display Current .htaccess File</div>
  <div class="panel-body"><pre><?php echo file_get_contents(ABSPATH.'.htaccess');?></pre></div>



  <div class="panel-heading">Page List</div>
  <div class="panel-body"><?php echo pageIds()?></div>


  <div class="panel-heading">Post List</div>
  <div class="panel-body"><?php echo postIds()?></div>


  <div class="panel-heading">Admin Users List</div>
  <div class="panel-body"><?php echo adminUsers()?></div>



  <div class="panel-heading">Current Active Plugins</div>
  <div class="panel-body"><?php echo activePlugins()?></div>
  
  



  <div class="panel-heading">Display Inode Count for: <?php echo ABSPATH?></div>
  <div class="panel-body"><pre><?php phpInodes();
echo returnAllDirs();

  ?></pre></div>

  <pre><h3>Total Size of Install Directory</h3><?php 
echo dataSize();
?></pre>

<pre><?php 
$Mydir = ABSPATH;

foreach(glob($Mydir.'*', GLOB_ONLYDIR) as $dir) {
    $dir = str_replace($Mydir, '', $dir);
    echo $dir.'<br>';
}
?></pre>

<pre><h3>Beta area for testing new php</h3>
<?php echo fileArray()?>

<h3>Database Information - WPDB Object</h3>
<?php echo userCount()?>


<h3>New Dirs Function</h3>
<?php echo newDirs()?>
<br><br><br>
<?php print_r(dirToArray(ABSPATH))?>

</pre>
  
</div>
</div>



