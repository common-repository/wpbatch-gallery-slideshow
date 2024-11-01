<?php 
/*
Plugin Name: WPBatch Gallery Slideshow
Plugin URI: http://dreamwebit.com
Description: This plugin will give you a shortcode to show gallery images 
Author: MTM Sujan
Version: 1.0
Author URI: http://dreamwebit.com
*/


function wpbatch_jquery_register() {
	wp_enqueue_script('jquery');
}
add_action('init', 'wpbatch_jquery_register');

add_filter('widget_text', 'do_shortcode');

function gallery_external_files() {
    wp_enqueue_script( 'pgwslideshow-js', plugins_url( '/js/pgwslideshow.min.js', __FILE__ ), array('jquery'), 1.0, false);
	
    wp_enqueue_style( 'main-gallery-css', plugins_url( '/css/main.css', __FILE__ ));
    wp_enqueue_style( 'pgwslideshow-light-css', plugins_url( '/css/pgwslideshow_light.min.css', __FILE__ ));
    wp_enqueue_style( 'pgwslideshow-min-css', plugins_url( '/css/pgwslideshow.min.css', __FILE__ ));
}

add_action('wp_enqueue_scripts','gallery_external_files');


function neccessary_codes_gallery(){
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.pgwSlideshow').pgwSlideshow();
		});
	</script>
<?php 
}
add_action('wp_head', 'neccessary_codes_gallery');



function custom_wpbatch_gallery() {
  $labels = array(
    'name'               => _x( 'WPBatch Gallery', 'wpbatchgallery' ),
    'singular_name'      => _x( 'gallery', 'wpbatchgallery' ),
    'add_new'            => _x( 'Add New', 'gallery' ),
    'add_new_item'       => __( 'Add New gallery image' ),
    'edit_item'          => __( 'Edit Gallery Image' ),
    'new_item'           => __( 'New Gallery Image' ),
    'all_items'          => __( 'All Gallery Images' ),
    'view_item'          => __( 'View Gallery Images' ),
    'search_items'       => __( 'Search Gallery Images' ),
    'not_found'          => __( 'No Gallery Images found' ),
    'not_found_in_trash' => __( 'No Gallery Images found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'WPBatch Gallery'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our products and product specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail' ),
    'has_archive'   => true,
  );
  register_post_type( 'wpbatch_gallery', $args ); 
}
add_action( 'init', 'custom_wpbatch_gallery' );


function wpbatch_gallery_shortcode($atts, $content=null){
	$query = new WP_Query( array(
        'post_type' => 'wpbatch_gallery',
        'posts_per_page' => -1
    ) );
    if ( $query->have_posts() ) { ?>
		<ul class="pgwSlideshow">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<li><?php the_post_thumbnail(); ?></li>
		<?php endwhile;
		wp_reset_postdata(); ?>
		</ul>
    <?php return $myvariable;
    }
	
		
}
add_shortcode('wpbatch_gallery', 'wpbatch_gallery_shortcode');	


?>