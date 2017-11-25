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

<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> -->

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php 
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

require_once(ABSPATH . 'wp-config.php');
include(WP_PLUGIN_DIR.'/wp-pbf/includes/wp-pbf-functions.php');
echo systemsCheck();
?>

<!--Master div start-->
<div class="wrap" style=>
	<span>
	<img src="https://jawordpressorg.github.io/wapuu/wapuu-archive/basile-wapuu.png" height="120px" width="120px" alt="Wapu" style="float: left;" caption="WordPress Print Basic Facts">
  <h1 style="position: relative;padding: 49px 0px 20px;">WordPress Print Basic Facts</h1>
</span>
<!--Any content above this block is likely permanenet.-->

<!--Here we have a table block that I intend to use for all display features moving forward. -->
<div class="container">

  <div class="row">
    <div class="col s4">
      <div class="function-block-container card hoverable z-depth-3">
        <?php echo wpBasicFacts()?>
      </div>
    </div>
    <div class="col s4">
      <div class="function-block-container card hoverable z-depth-3">
      
    </div>
    </div>
    <div class="col s4">
      <div class="function-block-container card hoverable z-depth-3">
      
    </div>
    </div>
  </div>

  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
    <li>
    <div class="collapsible-header"> .htaccess</div>
    <div class="collapsible-body"><span><pre><?php echo file_get_contents(ABSPATH.'.htaccess');?></pre></span></div>
    </li>
    <li>
    <div class="collapsible-header"> Post/Pages</div>
    <div class="collapsible-body"><span>
      <div class="row">
      <div class="col s6">
        <?php echo pageIds()?>
      </div>
      <div class="col s6">
        <?php echo postIds()?>
      </div>
      </div>
    </span></div>
    </li>
    <li>
    <div class="collapsible-header"> Admin Users</div>
    <div class="collapsible-body"><span><?php echo adminUsers()?></span></div>
    </li>
    <li>
    <div class="collapsible-header"> Admin Users</div>
    <div class="collapsible-body"><span><?php echo activePlugins()?></span></div>
    </li>



    </ul>
  </div>





<!--End of table block customizations. -->

  <div class="col-sm-6">
	<div class="panel panel-primary">
    <div class="panel-heading">Retreive File Count / Inodes Usage</div>
    <div class="panel-body"><?php 
// 3rd line down from the start 
    if(!is_callable('shell_exec')||(strpos(ini_get('disable_functions'), 'shell_exec') === true)){
      return '<h3>Shell Features Are Disabled. No Inode Count Functionality!</h3>';
    } else { ?>
    <form action="" method="Post">
      <input type="submit" class="btn btn-primary" name="inodesAboveRoot" value="Above Install Dir">
      <input type="submit" class="btn btn-primary" name="inodesRoot" value="Install Dir">
      <input type="submit" class="btn btn-primary" name="inodesContent" value="Content Dir">
      <input type="submit" class="btn btn-primary" name="inodesPlugins" value="Plugins Dir">
      <input type="submit" class="btn btn-primary" name="inodesThemes" value="Themes Dir"><br>
    </form><?php } ?>
   <?php 
    switch(true){
    case isset($_POST['inodesAboveRoot'])&&!empty($_POST['inodesAboveRoot']):
      $safepath=getcwd();
  chdir(ABSPATH);
  chdir('../');
  echo shellInodes();
  chdir($safepath);
    break;
    case isset($_POST['inodesContent'])&&!empty($_POST['inodesContent']):
      $safepath=getcwd();
  chdir(WP_CONTENT_DIR);
  echo shellInodes();
  chdir($safepath);
    break;
    case isset($_POST['inodesRoot'])&&!empty($_POST['inodesRoot']):
      $safepath=getcwd();
  chdir(ABSPATH);
  echo shellInodes();
  chdir($safepath);
    break;
    case isset($_POST['inodesPlugins'])&&!empty($_POST['inodesPlugins']):
      $safepath=getcwd();
  chdir(WP_PLUGIN_DIR);
  echo shellInodes();
  chdir($safepath);
    break;
    case isset($_POST['inodesThemes'])&&!empty($_POST['inodesThemes']):
      $safepath=getcwd();
  chdir(WP_CONTENT_DIR.DIRECTORY_SEPARATOR.'themes');
  echo shellInodes();
  chdir($safepath);
    break;
}

?>
</div>
    </div>
 </div>
 <div class="col-sm-6">
<div class="panel panel-primary">
    <div class="panel-heading">Basic Facts</div>
    <div class="panel-body"><?php echo wpBasicFacts()?></div>
  </div>
</div>



<div class="container-fluid row">
  <div class="col-sm-3">
<div class="panel panel-info" style="background-color: lightblue;">
    <div class="panel-heading">Display Current .htaccess File</div>
  <div class="panel-body"><pre><?php echo file_get_contents(ABSPATH.'.htaccess');?></pre></div>
</div>
</div>
<div class="col-sm-3">
<div class="panel panel-info" style="background-color: lightblue;">
  <div class="panel-heading">Page List</div>
  <div class="panel-body"><?php echo pageIds()?></div>
</div>
</div>
<div class="col-sm-3">
<div class="panel panel-info " style="background-color: lightblue;">
  <div class="panel-heading">Post List</div>
  <div class="panel-body"><?php echo postIds()?></div>
</div>
</div>
<div class="col-sm-3">
<div class="panel panel-info" style="background-color: lightblue;">
  <div class="panel-heading">Admin Users List</div>
  <div class="panel-body"><?php echo adminUsers()?></div>
</div>
</div>
</div>



<div class="container-fluid">
  <div class="panel panel-caution">
  <div class="panel-heading">Current Active Plugins</div>
  <div class="panel-body"><?php echo activePlugins()?></div>
</div>
  
  <div class="panel panel-caution">
  <div class="panel-heading">Display Inode Count for: <?php echo ABSPATH?></div>
  <div class="panel-body"><pre><?php phpInodes();
echo returnAllDirs();
  ?></pre></div></div>
</div>
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
</pre>


  

<!--Master div close-->
</div>


