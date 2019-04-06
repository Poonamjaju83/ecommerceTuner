<?php
  
/****************************************************************
 * DO NOT DELETE
 ****************************************************************/
if ( get_stylesheet_directory() == get_template_directory() ) {
	define('ALETHEME_PATH', get_template_directory() . '/aletheme');
	define('ALETHEME_URL', get_template_directory_uri() . '/aletheme');
} else {
    define('ALETHEME_PATH', get_theme_root() . '/delizioso/aletheme');
    define('ALETHEME_URL', get_theme_root_uri() . '/delizioso/aletheme');
}

require_once ALETHEME_PATH . '/init.php';

load_theme_textdomain( 'aletheme', get_template_directory() . '/lang' );
$locale = get_locale();
$locale_file = get_template_directory() . "/lang/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);



/****************************************************************
 * You can add your functions here.
 * 
 * BE CAREFULL! Functions will dissapear after update.
 * If you want to add custom functions you should do manual
 * updates only.
 ****************************************************************/


//code to add prefix in product title---start here---by Poonam//

remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
add_action('woocommerce_single_product_summary','woocommerce_my_single_title',5);

if ( ! function_exists( 'woocommerce_my_single_title' ) ) {
	function woocommerce_my_single_title() {
	?>
		<span><?php echo get_option('custom_plugin_product_prefix');?></span><h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
	<?php
	}
}

//code to add prefix in product title---end here---by Poonam//

//code to add metabox and update metabox value for indexing---start here---by Poonam//
add_action( 'woocommerce_product_options_advanced', 'custom_adv_product_options');
function custom_adv_product_options(){
 
	echo '<div class="options_group">';
 
	woocommerce_wp_checkbox( array(
		'id'      => 'Indexing',
		'value'   => get_post_meta( get_the_ID(), 'Indexing', true ),
		'label'   => 'Indexing',
		'desc_tip' => true,
		'description' => 'For WooCommerce products only, If field checked the product should have the robots meta HTML tag noindex',
	) );
 
	echo '</div>';
 
}
 
 
add_action( 'woocommerce_process_product_meta', 'custom_save_fields', 10, 2 );
function custom_save_fields( $id, $post ){	 
	 
	update_post_meta( $id, 'Indexing', $_POST['Indexing'] ); 
}

add_action( 'woocommerce_product_add_metatag', 'add_meta_tags', 10, 2 );
function add_meta_tags( $id, $post ){	 
	 
	update_post_meta( $id, 'Indexing', $_POST['Indexing'] ); 
}

//code to add metabox and update metabox value---end here---by Poonam//

//code to add value in metatype as per value selected ---start here---by Poonam//

add_action('wp_head', 'get_index_variable_status');

 function get_index_variable_status(){	 
	 global $post;
	 $index_variable_status = false;
	if(get_post_meta($post->ID, 'Indexing', true) == 'yes') { 
	 	
	  $index_variable_status = true;
	}

	return $index_variable_status; 
}
 
if(get_index_variable_status() == 1){ 
	add_action( 'the_seo_framework_robots_meta_array', 'my_robots_adjustments', 10, 1 );
} 
function my_robots_adjustments( $robots = array() ) {
   
	if ( ! function_exists( 'is_product' ) )
		return $robots;
  
	if ( is_product() ) {
		// Keys match the value. Legacy code.
		$robots['noindex'] = 'noindex';
		$robots['nofollow'] = 'nofollow';
	}

	return $robots;
}
//code to add value in metatype as per value selected ---start here---by Poonam//


?>