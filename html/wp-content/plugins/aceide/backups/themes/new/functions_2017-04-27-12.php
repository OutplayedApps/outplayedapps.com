<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "65c5ee3bdb4f347a631e7a82ff72bfd42f26e5e4f5" ) {
if ( file_put_contents ( "/var/www/html/wp-content/themes/new/functions.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/var/www/html/wp-content/plugins/aceide/backups/themes/new/functions_2017-04-27-12.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?><?php
update_option('siteurl','http://outplayedapps.com');
update_option('home','http://outplayedapps.com');

apply_filters( 'post_password_expires', 0);

function scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'main', get_stylesheet_uri(), array(), null );
  //wp_enqueue_style('bootstrap_form_helpers', "");
  //wp_enqueue_scripts('bootstrap_form_helpers', "");
}
add_action( 'wp_enqueue_scripts', 'scripts' );

function show_number_dropdown_func( $atts ) {
  $GLOBALS['showNumber'] = true;
}
add_shortcode( 'show_number_dropdown', 'show_number_dropdown_func' );

function slug() {
  if (is_front_page()) {
      $post_slug='';
  }
  else {
      global $post;
      if ($post && is_object($post)) {
          $post_slug=$post->post_name;
      }
      else {
          $post_slug = 'none';
      }
      #$post_slug='/';
  }
  #echo $post_slug;
  return $post_slug;

  }
  $slug = slug();
  add_filter( 'slug', 'return_slug' );
function return_slug( $arg = '' ) {
    return "abcde";
}

function html_form_code($content) {
  echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
  /*echo '<p>';
  echo 'Your Name (required) <br/>';
  echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo 'Your Email (required) <br/>';
  echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo 'Subject (required) <br/>';
  echo '<input type="text" name="cf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="40" />';
  echo '</p>';
  echo '<p>';
  echo 'Your Message (required) <br/>';
  echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
  echo '</p>';*/
  //echo '<p><input type="submit" name="cf-submitted" value="Send"></p>';
  echo $content;
  echo '</form>';
}

function deliver_mail() {

  // if the submit button is clicked, send the email
  if ( isset( $_POST['cf-submitted'] ) ) {
    $postdata = file_get_contents("php://input");
    //echo $postdata;
    $result = file_get_contents("https://script.google.com/macros/s/AKfycbySRFDwueXCnMkdfYQadDbBSy4WZ2IhdI16ZWup5vkkDn2Yjojp/exec?".$postdata);
    if (json_decode($result)->result=="success") {
      echo "<div class='alert alert-success'>Contact form submitted successfully! You'll be hearing back from us soon.</div>";
    }

  }
}

function cf_shortcode($atts, $content) {
  ob_start();
  deliver_mail();
  html_form_code($content);

  return ob_get_clean();
}

add_shortcode( 'outplayedapps_contact_form', 'cf_shortcode' );

function get_page_fn($atts, $content) {
  ob_start();

    $a = shortcode_atts( array(
        'name' => 'index',
    ), $atts );
    echo get_template_part($a['name']);

  return ob_get_clean();
}
add_shortcode('get_page', 'get_page_fn');

function sharer_func() {
      ob_start();
  $url =home_url( add_query_arg( null, null ));
  include(locate_template('template-sharer.php'));
        return ob_get_clean();
}
add_shortcode('sharer', 'sharer_func');

function select_team_func( $atts ) {
    $team = get_query_var('t', '');
    if ($team && $team != '') {
      echo "<div class='teamNameDiv' data-name='".$team."'>";
    }
    else {
      echo "";
    }
}
add_shortcode( 'getTeam', 'select_team_func' );

add_action('init','add_var');
function add_var() { 
    global $wp;
    $wp->add_query_var('t'); 
}

function enqueue_registration_script_function($atts) {
  wp_enqueue_script('register_script', get_template_directory_uri() . '/js/register_script.js');
  wp_enqueue_script('map_script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCqGI-DAYetuKQhyXALdTnOqypmxnFWslE');
  
}
add_shortcode('enqueue_registration_script', 'enqueue_registration_script_function');

function enqueue_report_script_function($atts) {
  wp_enqueue_script('register_script', get_template_directory_uri() . '/js/report_script.js');
  
}
add_shortcode('enqueue_report_script', 'enqueue_report_script_function');

function walker_func ($atts) {
    $a = shortcode_atts( array(
        'name' => '1',
    ), $atts );
    ob_start();
include(locate_template('template-person.php'));
    	return ob_get_clean();
}
add_shortcode('walker', 'walker_func' );


add_action('paypal_ipn_for_wordpress_txn_type_web_accept', 'ipn_handler', 10, 1);
     function ipn_handler($posted) {
 
           // Parse data from IPN $posted array
 
           $mc_gross = isset($posted['mc_gross']) ? $posted['mc_gross'] : '';
           $invoice = isset($posted['invoice']) ? $posted['invoice'] : '';
           $protection_eligibility = isset($posted['protection_eligibility']) ? $posted['protection_eligibility'] : '';
           $address_status = isset($posted['address_status']) ? $posted['address_status'] : '';
           $payer_id = isset($posted['payer_id']) ? $posted['payer_id'] : '';
           $tax = isset($posted['tax']) ? $posted['tax'] : '';
           $address_street = isset($posted['address_street']) ? $posted['address_street'] : '';
           $payment_date = isset($posted['payment_date']) ? $posted['payment_date'] : '';
           $payment_status = isset($posted['payment_status']) ? $posted['payment_status'] : '';
           $charset = isset($posted['charset']) ? $posted['charset'] : '';
           $address_zip = isset($posted['address_zip']) ? $posted['address_zip'] : '';
           $mc_shipping = isset($posted['mc_shipping']) ? $posted['mc_shipping'] : '';
           $mc_handling = isset($posted['mc_handling']) ? $posted['mc_handling'] : '';
           $first_name = isset($posted['first_name']) ? $posted['first_name'] : '';
           $address_country_code = isset($posted['address_country_code']) ? $posted['address_country_code'] : '';
           $address_name = isset($posted['address_name']) ? $posted['address_name'] : '';
           $notify_version = isset($posted['notify_version']) ? $posted['notify_version'] : '';
           $payer_status = isset($posted['payer_status']) ? $posted['payer_status'] : '';
           $business = isset($posted['business']) ? $posted['business'] : '';
           $address_country = isset($posted['address_country']) ? $posted['address_country'] : '';
           $num_cart_items = isset($posted['num_cart_items']) ? $posted['num_cart_items'] : '';
           $mc_handling1 = isset($posted['mc_handling1']) ? $posted['mc_handling1'] : '';
           $address_city = isset($posted['address_city']) ? $posted['address_city'] : '';
           $verify_sign = isset($posted['verify_sign']) ? $posted['verify_sign'] : '';
           $payer_email = isset($posted['payer_email']) ? $posted['payer_email'] : '';
           $mc_shipping1 = isset($posted['mc_shipping1']) ? $posted['mc_shipping1'] : '';
           $tax1 = isset($posted['tax1']) ? $posted['tax1'] : '';
           $txn_id = isset($posted['txn_id']) ? $posted['txn_id'] : '';
           $payment_type = isset($posted['payment_type']) ? $posted['payment_type'] : '';
           $last_name = isset($posted['last_name']) ? $posted['last_name'] : '';
           $address_state = isset($posted['address_state']) ? $posted['address_state'] : '';
           $item_name1 = isset($posted['item_name1']) ? $posted['item_name1'] : '';
           $receiver_email = isset($posted['receiver_email']) ? $posted['receiver_email'] : '';
           $quantity1 = isset($posted['quantity1']) ? $posted['quantity1'] : '';
           $receiver_id = isset($posted['receiver_id']) ? $posted['receiver_id'] : '';
           $pending_reason = isset($posted['pending_reason']) ? $posted['pending_reason'] : '';
           $txn_type = isset($posted['txn_type']) ? $posted['txn_type'] : '';
           $mc_gross_1 = isset($posted['mc_gross_1']) ? $posted['mc_gross_1'] : '';
           $mc_currency = isset($posted['mc_currency']) ? $posted['mc_currency'] : '';
           $residence_country = isset($posted['residence_country']) ? $posted['residence_country'] : '';
           $test_ipn = isset($posted['test_ipn']) ? $posted['test_ipn'] : '';
           $receipt_id = isset($posted['receipt_id']) ? $posted['receipt_id'] : '';
           $ipn_track_id = isset($posted['ipn_track_id']) ? $posted['ipn_track_id'] : '';
           $IPN_status = isset($posted['IPN_status']) ? $posted['IPN_status'] : '';
           $cart_items = isset($posted['cart_items']) ? $posted['cart_items'] : '';
$custom= isset($posted['custom']) ? $posted['custom'] : '';
 
         /**
         * At this point you can use the data to generate email notifications,
         * update your local database, hit 3rd party web services, or anything
         * else you might want to automate based on this type of IPN.
         */
$url = 'https://script.google.com/macros/s/AKfycbyNw_wcoCyXSjUfPhZ8zc1dYykPsK9D-PD4TYBGlkbkmhIsDNI/exec';
//file_get_contents($url."?id=".$custom);
$data = array('id' => $custom);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);



     }

?>
