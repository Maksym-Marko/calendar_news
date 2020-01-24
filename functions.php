<?php

function twentynineteen_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Calendar of News', 'twentynineteen' ),
			'id'            => 'sidebar-calendar',
			'description'   => __( 'Add widgets to the calendar area.', 'twentynineteen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'twentynineteen_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function twentynineteen_scripts() {
	// news
	wp_enqueue_style( 'mx-twentynineteen-news', get_template_directory_uri() . '/css/news.css', array( 'twentynineteen-style' ), time() );
	wp_enqueue_script( 'mx-twentynineteen-news-js', get_template_directory_uri() . '/js/news.js', array( 'jquery' ), time(), true );

	wp_localize_script( 'mx-twentynineteen-news-js', 'mx_localize', array(

		'ajaxurl' 		=> admin_url( 'admin-ajax.php' ),
		'mx_nonce'		=> wp_create_nonce( 'calendar_news_nonce' )

	) );

}
add_action( 'wp_enqueue_scripts', 'twentynineteen_scripts' );

// calendar news
add_action( 'wp_ajax_nopriv_mx_get_particular_news', 'mx_get_news_calendar' );
add_action( 'wp_ajax_mx_get_particular_news', 'mx_get_news_calendar' );

function mx_get_news_calendar() {

	if( empty( $_POST['nonce'] ) ) wp_die();

	if( wp_verify_nonce( $_POST['nonce'], 'calendar_news_nonce' ) ) {

		$url = $_POST['_href'];

		// get date
		$matches = null;

		$returnValue = preg_match( '/(\\d{4}\\/\\d{2}\\/\\d{2})/', $url, $matches );

		$date = str_replace( '/', '-', $matches[0] );

		global $wpdb;

		$table_name = $wpdb->prefix . 'posts';

		$results = $wpdb->get_results( "SELECT ID, post_title, post_excerpt, post_date
			FROM $table_name
			WHERE post_type = 'post'
				AND post_status = 'publish'
				AND post_date LIKE '%$date%'
			ORDER BY ID 
			DESC
		" );

		$_result = array();

		foreach ( $results as $key => $value ) {

			$tmp_array = array();

			$tmp_array['ID'] = $value->ID;

			$tmp_array['post_title'] = $value->post_title;

			$tmp_array['post_excerpt'] = $value->post_excerpt;

			$tmp_array['permalink'] = get_post_permalink( $value->ID );

			$tmp_array['post_thumbnail_url'] = get_the_post_thumbnail_url( $value->ID, 'medium' );

			array_push( $_result, $tmp_array );		

		}

		echo json_encode( $_result );
		

	}

	wp_die();

}