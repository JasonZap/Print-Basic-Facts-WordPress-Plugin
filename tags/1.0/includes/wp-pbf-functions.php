<?php
function pbf_active_plugins_list() { // Function will return a query of database using get_option and a foreach loop,
	$activeplugs = get_option('active_plugins'); // to number and list the contentes of the array. 
	$total = 0;
    foreach ($activeplugs as $key => $value) {
        $total++;
        echo $total.' = '.$value.'<br />';
    }
    echo '<hr>Total Active Plugin(s) = '.$total;
}

function pbf_admin_users() { // The Query for admin users
    $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) ); // User Loop - to pull all active users.
    if ( ! empty( $user_query->results ) ) { //When it returns data, proceed to foreach loop
	    foreach ( $user_query->results as $user ) { //Using foreach to echo each user.
			echo ($user->display_name.'<br />'); //Echo with line breaks
		}
	} else { //When no data is found by query.
		echo 'No users found.';
	}
}

function pbf_page_ids() { // This function will retreive all pages identified by WordPress 
    $page_ids=get_all_page_ids();
    foreach($page_ids as $page){ //For each to loop through array.
	    $uri = get_page_uri($page); //URI should give the URL for a specific page.
	    switch ($uri) {
		case '': //When the uri has no value.
		    echo get_the_title($page).' - No Link (Page is not public)<br />';
		break;
		default: //When the URI returns a real something.
		    echo get_the_title($page).'<a href="'. $uri .'"> - Link to page</a><br />';
		break;
	    }
	}
}

function pbf_post_ids() { // Similar to pageIds() this function will use WP defined get_posts function to request specifics
    $post_ids = get_posts(array( // In this case we are looking for published status and returning the post IDs. 
        'posts_per_page'=> -1, //This is effectively saying (any) posts per page.
        'post_status' => 'publish', //Return only published posts. Alternate can cause unexpected results.
        'fields'        => 'ids', // Only get post IDs
    ));
    foreach($post_ids as $post){ // foreach iteration will take all values of the given array and act on each value.
        $puri = get_page_uri($post); // $puri is a holder for the URI for the specific Post ID as set in each iteration. 
        switch ($puri) {
        case '':
            echo get_the_title($post).' - No Link (Page is not public)<br />'; //If we get an empty string on the URI then we report as such.
        break;
        default: 
            echo get_the_title($post).'<a href="'. $puri .'"> - Link to page</a><br />'; //Otherwise this will show the actual link to the page. 
        break;
        }	
    }
}

function pbf_php_info(){
	ob_start();
	phpinfo();
	$pinfo = ob_get_contents();
	ob_end_clean();
	// Using preg_replace to remove exsiting elements. 
	$pinfo = preg_replace("/^.*?\<body\>/is", "", $pinfo); //Removes all content up till the end of the starting body tag
    $pinfo = preg_replace("/<\/body\>.*?$/is", "", $pinfo); //Removes all starting with close of body and all after
    $pinfo = preg_replace("/\<a\shref.*?\<\/a\>/is", "", $pinfo); //Removes an a href link its closing tag and the contents between
   	//Setting styles to be used in the buffered output
	echo $pinfo;
}

function pbf_software_versions(){ // Function will display the predefined values for connection strings. 
	global $wp_db_version;
	global $wp_version;
	global $wpdb;
	echo ('<p class="card-heading"><b>Software</b></p><br />
		<b>Current PHP Version:</b> '.phpversion().'<br />
		<b>Current WP Version: </b>'.$wp_version.'<br />
		<b>Current DB Version: </b>'.esc_textarea($wpdb->get_var( "SELECT version()" )).'<br />
		<b>PHP Specified OS:</b> '.PHP_OS.'<br /><br />');
}

function pbf_install_defined(){
    $uploadpath = get_option('upload_path');
	if ($uploadpath != NULL){define('PBF_UP_PATH', $uploadpath);} else {define('PBF_UP_PATH', "Not Set");}
	if (FORCE_SSL_ADMIN != 1) {define('PBF_FORCESSL', "Disabled");} else {define('PBF_FORCESSL', "Enabled");}
	if (WP_DEBUG != 1) {define('PBF_BUGSTAT', "Disabled");} else {define('PBF_BUGSTAT', "Enabled");}
	if (DISALLOW_FILE_EDIT != 1) {define('PBF_FILEEDIT', "Disabled - Editor is accessible");} else {define('PBF_FILEEDIT', "Enabled - Editor is <u>not</u> accesible");}
	echo (
	   '<p class="card-heading"><b>WordPress Defined</b></p><br />
		<b>WP Defined Absolute Path:</b> '.ABSPATH.'<br />
		<b>Current Upload_Path is:</b> '.PBF_UP_PATH.'<br />
		<b>Current Wp-Content Dir:</b> '.WP_CONTENT_DIR.'<br />
		<b>Current Template (Theme):</b> '.(substr(TEMPLATEPATH, strrpos(TEMPLATEPATH, "/") +1)).'<br />
		<b>Current Stylesheet (Child):</b> '.(substr(STYLESHEETPATH, strrpos(STYLESHEETPATH, "/") +1)).'<br />
		<b>Force_Ssl_Admin Status is:</b> '.PBF_FORCESSL.'<br />
		<b>Wp_Debug Status is:</b> '.PBF_BUGSTAT.'<br />
		<b>Disallow_File_Edit Status is:</b> '.PBF_FILEEDIT.'<br />
		<b>Admin_Email is:</b> '.get_option('admin_email').'<br />'
	);	
}

function pbf_connection_strings(){
	if (strpos(DB_HOST, ":") === false) {define('PBF_DBHOST', DB_HOST);define('PBF_DBPORT', '3306');} 
	else {define('PBF_DBHOST', substr(DB_HOST, 0 ,strpos(DB_HOST, ":")));	define('PBF_DBPORT', substr(DB_HOST, strpos(DB_HOST, ":") + 1));}
	echo (
		'<p class="card-heading"><b>Connection Strings</b></p><br />
		<b>Database Name:</b> '.esc_textarea(DB_NAME).'<br />
		<b>Database User:</b> '.esc_textarea(DB_USER).'<br />
		<b>Database Password:</b> <span style="display: none;" id="passSpan">'.esc_textarea(DB_PASSWORD).'</span><span id="fassSpan"> ******** </span><br />
		<b>Database Host:</b> '.esc_textarea(PBF_DBHOST).'<br />
		<b>Database Port:</b> '.esc_textarea(PBF_DBPORT).'<br />'
	);
}

function pbf_active_plugins_value() {
    global $wpdb; // The following 4 lines are setting the necessary variables. 
    $tableName = $wpdb->prefix . "options"; //setting for any custom prefix
    $sqlString = "active_plugins";  //Retreiving active plugins - string to be sanitized aka practice
    $raw = "SELECT option_value FROM ".$tableName." WHERE option_name = %s"; //%s to insert string in next query
    $dbPrepared = $wpdb->prepare( $raw, $sqlString ); // Using wpdb->prepare to ensure all queries are clean
    echo ($wpdb->get_var( $dbPrepared ).'<br />'); //Simply echo the get_var using the prepared query.
}

function pbf_database_size_query() {
    global $wpdb; // The following 4 lines are setting the necessary variables. 
    $sqlString1 = "DBName";
 	$sqlString2 = "DBSizeinMB";
    $raw = "SELECT table_schema %s, Round(Sum(data_length + index_length) / 1024 / 1024, 1) %s FROM information_schema.tables GROUP BY table_schema"; //Using Query to gather information schema and database information.
    $dbPrepared = $wpdb->prepare( $raw, $sqlString1, $sqlString2 ); // Using wpdb->prepare to ensure all queries are clean
    $returnRows = ($wpdb->get_results( $dbPrepared )); //Simply echo the get_results using the prepared query.
    $rowIterator = 0; //Row iterator will take place of the array[key] used in my foreach statement.
    echo ("<table class='tableclass' style='width:100%'><tr class='tablerow'><th class='tablehead'>Database Name</th><th class='tablehead'>Database Size In Megabytes</th></tr>"); // Lenghty echo to prepare the aesthetics of DB table
        foreach ($returnRows as $returnRow) { // This way we can return results regardless of availability of information schema or multiple databases. 
            echo ("<tr class='tablerow'><td class='tablevar'>".$returnRows[$rowIterator]->DBName."</td><td class='tablevalue'>".$returnRows[$rowIterator]->DBSizeinMB."</td></tr>"); //Using classes already defined in plugin css intended for use on phpinfo. 
    $rowIterator += 1;
    }
    echo ("</table>");  // closing the table outside of the loop. 
}

function pbf_ends_with($haystack, $needle){ //Always seems needed.
	return strrpos($haystack, $needle) === strlen($haystack)-strlen($needle);
}

function pbf_user_count(){ //Should not require preperation. 
    global $wpdb;
    echo ('Total User Count is '.$wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->users" ));
}

function pbf_read_install_dir(){
    $safepath = getcwd(); //Saving the cwd as the path so that we can swtich back at the end.
    chdir(ABSPATH); //Moving php execution to the installation directory.
    $inodes = 0; //Starting filecount
    $directories = 0; //Starting the directory acount.
    foreach (glob('{,.}[!.,!..]*',GLOB_MARK|GLOB_BRACE) as $filename) {//Will work with typical naming conventions.
        if (pbf_ends_with($filename, "/")){ //Mark directores in red text if the / is located.
            echo $filename.'<span style="color: red;">  -  Is A Directory</span><br />';
            $directories++; // Adding to directores count so we can remove from total file count.
        } else { //Display the item as a file when not detected as a directory.
            echo $filename.'<br />';
            $inodes++; //File count itterator. 
        }
    }
    chdir($safepath); //Switching back to safe path for php execution. 
}

function pbf_get_file_size($path) {  //Seems to be accurate. Unfortunate part is RecursiveIteratorIterator is a little hard to read. 
	$dirsCount = 0; //Keeping tack of idDots count. Helps to keep count accurate by removing non-inodes from count.
	$totalSizeBytes = 0; //Empty place holder, will hold the total bytes of all files combined.
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path),RecursiveIteratorIterator::LEAVES_ONLY);
//Objects is an array. using RDI on the specified path to map all directory contents, Leaves only to ensure we go into sub-directories.
	foreach($objects as $name => $object){ //Breaking apart objects array to calculate 
		$filesize = filesize($name); //Counting each items filesize
		$totalSizeBytes += $filesize; //Adding each items filesize into a single vairable fro tracking. 
		if ($objects->isDot()) {$dirsCount++;} //counting total isDot instances.
	}
	$totalSize = round($totalSizeBytes / 1024 / 1024, 2); // megabytes with 2 digits)
	$count = iterator_count($objects); //Count of all items including isDots
	$count-=$dirsCount;  //removing isDots from the total count. 

	echo ("<tr class='tablerow'><td class='tablevar'>".$path."</td><td class='tablevalue'>".number_format($count)."</td><td class='tablevalue'>".$totalSize."</td></tr>");
}

function pbf_highlight_number($file) {
	$code = substr(highlight_file($file, true), 36, -15); //Strip code and first span
	$lines = explode('<br />', $code); //Split lines
	$lineCount = count($lines); //line count after explosion
	$docLength = strlen($lineCount); //Calculate document length
	echo "<code><span style=\"color: #000000\">"; //Re-Print the code and span tags
	foreach($lines as $i => $line) { //Loop through the lines
		$lineNumber = str_pad($i + 1,  $docLength, '0', STR_PAD_LEFT); //Create line number by adding padding on the left and incrementing up.
		echo sprintf('<br /><span style="color: #999999"> %s | </span>%s', $lineNumber, $line); //Print line
	}
	echo "</span></code>"; //Close span and code tags
}
?>