<?php

/*

Plugin Name: Simple From Email Change

Plugin URI: http://woogang.com

Description: Simplest way to change the default from email name and/or address for emails sent from WordPress.

Version: 1.0

Author: WooGang

Author URI: http://woogang.com

*/



if ( !function_exists('add_action') ) {

	header('Status: 403 Forbidden');

	header('HTTP/1.1 403 Forbidden');

	exit();

}



function show_wp_change_email_details_options ()

{

	$wp_change_email_details_version = "1.0";

    if (isset($_POST['info_update']))

    {

        update_option('customize_email_details_name', ($_POST['customize_email_details_name']!='') ? 'checked="checked"':'' );

        update_option('email_details_from_name', (string)$_POST["email_details_from_name"]);

        update_option('customize_email_details_email', ($_POST['customize_email_details_email']!='') ? 'checked="checked"':'' );

        update_option('email_details_from_email', (string)$_POST["email_details_from_email"]);



        echo '<div id="message" class="updated fade">';

        echo '<p><strong>Options Updated!</strong></p></div>';

    }



    if (get_option('customize_email_details_name'))

        $customize_email_details_name = 'checked="checked"';

    else

        $customize_email_details_name = '';



    $from_name = get_option('email_details_from_name');



    if (get_option('customize_email_details_email'))

        $customize_email_details_email = 'checked="checked"';

    else

        $customize_email_details_email = '';

        

    $from_email = get_option('email_details_from_email');

                              

	?>

 	<h2>Simple From Email Change Settings v <?php echo $wp_change_email_details_version; ?></h2>

 	 	    

    <fieldset class="options">

    <legend>Usage:</legend>



    <p>1. Check the appropriate checkbox for the options that you want to customize.</p>

	<p>2. Enter the customized text in the appropriate field.</p>

    </fieldset>



    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

    <input type="hidden" name="info_update" id="info_update" value="true" />    

 	<?php

echo '

	<div class="postbox">

	<h3><label for="title">Customization Settings</label></h3>

	<div class="inside">';



echo '

<table class="form-table">



<tr valign="top">

<th scope="row">Customize the From Name</th>

<td><input type="checkbox" name="customize_email_details_name" value="1" '.$customize_email_details_name.' /><br />If checked the from name on all outgoing emails from WordPress will use the customized name.</td>

</tr>



<tr valign="top">

<th scope="row">From Name</th>

<td><input type="text" name="email_details_from_name" value="'.$from_name.'" size="30" /><br />This name will appear in the From Name column of all your emails sent from WordPress.</td>

</tr>



<tr valign="top">

<th scope="row">Customize the From Email Address</th>

<td><input type="checkbox" name="customize_email_details_email" value="1" '.$customize_email_details_email.' /><br />If checked the from email address on all outgoing emails from WordPress will use the customized email address.</td>

</tr>



<tr valign="top">

<th scope="row">From Email Address</th>

<td><input type="text" name="email_details_from_email" value="'.$from_email.'" size="30" />This email address will appear in the From email address field of all your emails sent from WordPress.</td>

</tr>



</table>



</div></div>

    <div class="submit">

        <input type="submit" name="info_update" value="Update Options &raquo;" />

    </div>						

 </form>

 ';

}



function wp_change_email_details_options()

{

     echo '<div class="wrap"><h2>Simple From Email Change Options</h2>';

     echo '<div id="poststuff"><div id="post-body">';

     show_wp_change_email_details_options();

     echo '</div></div>';

     echo '</div>';

}



// Display The Options Page

function wp_change_email_details_options_page ()

{

     add_options_page('Simple Email Change', 'Simple EMail Change', 'manage_options', __FILE__, 'wp_change_email_details_options');

}



if ( !class_exists('wp_mail_from') ) {

	class wp_mail_from {

 

		function wp_mail_from() 

        {

            if (get_option('customize_email_details_email'))

            {

	            add_filter( 'wp_mail_from', array(&$this, 'fb_mail_from') );

            }

            if (get_option('customize_email_details_name'))

            {

			    add_filter( 'wp_mail_from_name', array(&$this, 'fb_mail_from_name') );

            }

		}

 

		// new name

		function fb_mail_from_name() {

			$name =  get_option('email_details_from_name');

			$name = esc_attr($name);

			return $name;

		}

 

		// new email-adress

		function fb_mail_from() {

			$email = get_option('email_details_from_email');

			$email = is_email($email);

			return $email;

		}

 

	}

	$wp_mail_from = new wp_mail_from();

}



// Insert the options page to the admin menu

add_action('admin_menu','wp_change_email_details_options_page');

?>
