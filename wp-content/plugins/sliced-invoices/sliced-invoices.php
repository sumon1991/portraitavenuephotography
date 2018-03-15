<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Sliced Invoices
 * Plugin URI:        http://slicedinvoices.com/
 * Description:       Create professional Quotes & Invoices that clients can pay for online.
 * Version:           3.6.6
 * Author:            Sliced Invoices
 * Author URI:        http://slicedinvoices.com/
 * Text Domain:       sliced-invoices
 * Domain Path:       /languages
 */

if ( ! defined('ABSPATH') ) {
	exit;
}

define( 'SLICED_VERSION', '3.6.6' );
define( 'SLICED_DB_VERSION', '6' );
define( 'SLICED_PATH', plugin_dir_path( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sliced-activator.php
 */
function activate_sliced_invoices() {
	require_once SLICED_PATH . 'core/class-sliced-activator.php';
	Sliced_Activator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sliced-deactivator.php
 */
function deactivate_sliced_invoices() {
	require_once SLICED_PATH . 'core/class-sliced-deactivator.php';
	Sliced_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sliced_invoices' );
register_deactivation_hook( __FILE__, 'deactivate_sliced_invoices' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require SLICED_PATH . 'core/class-sliced.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since   2.0.0
 */
function run_sliced_invoices() {
	define( 'SLICED_TIMEZONE', (get_option( 'timezone_string' ) ? get_option( 'timezone_string' ) : date_default_timezone_get() ) );
	$plugin = new Sliced_Invoices();
	$plugin->run();
 }
add_action( 'plugins_loaded', 'run_sliced_invoices' ); // wait until 'plugins_loaded' hook fires, for WP Multisite compatibility




/* ==============================================================================
 * DATABASE UPDATES
 * ==============================================================================
 *
 * History:
 * 2017-11-03 -- update DB from 5 to 6, for Sliced Invoices versions < 3.6.1
 * 2017-10-16 -- update DB from 4 to 5, for Sliced Invoices versions < 3.6.0
 * 2017-06-06 -- update DB from 3 to 4, for Sliced Invoices versions < 3.4.0
 * 2016-08-30 -- update DB from 2 to 3, for Sliced Invoices versions < 2.873
 */
function sliced_invoices_db_update() {
	
	global $post, $wpdb;
	
	$sliced_db_check = get_option('sliced_general');
	
	if ( isset( $sliced_db_check['db_version'] ) && $sliced_db_check['db_version'] >= SLICED_DB_VERSION ) {
		// all good
		return;
	}
	
	// upgrade from v5 to 6
	if ( ! isset( $sliced_db_check['db_version'] ) || $sliced_db_check['db_version'] < 6 ) {
		$args = array(
			'post_type' => 'sliced_invoice',
			'posts_per_page' => -1,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) { 
			while ( $query->have_posts() ) {
				$query->the_post();
				$old_payments = get_post_meta( $post->ID, 'sliced_invoice_paid', true );
				$new_payments = get_post_meta( $post->ID, '_sliced_payment', true );
				if ( $old_payments && ! $new_payments ) {
					if ( update_post_meta( $post->ID, '_sliced_payment', array( array(
						'amount'     => $old_payments,
						'status'     => 'success',
					) ) ) ) {
						delete_post_meta( $post->ID, 'sliced_invoice_paid' );
					}
				}
			}
		}
		wp_reset_postdata();
	}
	
	// upgrade from v4 to 5
	if ( ! isset( $sliced_db_check['db_version'] ) || $sliced_db_check['db_version'] < 5 ) {
		$args = array(
			'post_type' => array( 'sliced_quote', 'sliced_invoice' ),
			'posts_per_page' => -1,
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) { 
			while ( $query->have_posts() ) {
				$query->the_post();
				$line_items = get_post_meta( $post->ID, '_sliced_items', true );
				if ( ! is_array( $line_items ) ) {
					continue;
				}
				foreach ( $line_items as &$line_item ) {
					$line_item['taxable'] = 'on';
					$line_item['second_taxable'] = 'on';
				}
				update_post_meta( $post->ID, '_sliced_items', $line_items );
			}
		}
		wp_reset_postdata();
	}
	
	// upgrade from v3 to 4
	if ( ! isset( $sliced_db_check['db_version'] ) || $sliced_db_check['db_version'] < 4 ) {
		// check semaphore options
		$results = $wpdb->get_results("
			SELECT option_id
			  FROM $wpdb->options
			 WHERE option_name IN ('sliced_locked', 'sliced_unlocked')
		");
		if (!count($results)) {
			update_option('sliced_unlocked', '1');
			update_option('sliced_last_lock_time', current_time('mysql', 1));
			update_option('sliced_semaphore', '0');
		}
	}
	
	// upgrade from < v3
	if ( ! isset( $sliced_db_check['db_version'] ) || $sliced_db_check['db_version'] < 3 ) {
		// quotes:
		$args = array(
			'post_type' => 'sliced_quote',
			'posts_per_page' => -1,
			'meta_query' =>
				array(
					array(
						'key'     => '_sliced_quote_created',
						'compare' => 'NOT EXISTS'
					)
				)
			);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) { 
			while ( $query->have_posts() ) {
				$query->the_post();
				update_post_meta( $post->ID, '_sliced_quote_created', strtotime( $post->post_date ) > 0 ? strtotime( $post->post_date ) : strtotime( $post->post_date_gmt ) );
			}
		}
		wp_reset_postdata();

		// invoices:
		$args = array(
			'post_type' => 'sliced_invoice',
			'posts_per_page' => -1,
			'meta_query' =>
				array(
					array(
						'key'     => '_sliced_invoice_created',
						'compare' => 'NOT EXISTS'
					)
				)
			);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) { 
			while ( $query->have_posts() ) {
				$query->the_post();
				update_post_meta( $post->ID, '_sliced_invoice_created', strtotime( $post->post_date ) > 0 ? strtotime( $post->post_date ) : strtotime( $post->post_date_gmt ) );
			}
		}
		wp_reset_postdata();
	}
	
	// Done
	$sliced_db_check['db_version'] = SLICED_DB_VERSION;
	update_option( 'sliced_general', $sliced_db_check );
	
}
add_action( 'init', 'sliced_invoices_db_update' );




/* ==============================================================================
 * FILTERS AND ACTIONS TO AVOID PLUGIN AND THEME CONFLICTS
 * ============================================================================== */

// Ignore autoptimize plugin
function sliced_filter_for_autoptimize() {
	return (bool) sliced_get_the_type();
}
add_filter('autoptimize_filter_noptimize','sliced_filter_for_autoptimize',10,0);

// Kill DAPP, if it's in use. (all of DAPP's features are now built-in as of v3.6.0)
function sliced_no_dapp() {
	global $wp_filter;
	$tag = 'init';
	$class_name = 'Sliced_Discounts_And_Partial_Payment';
	$method_name = 'init';
	$priority = 10;
	if ( ! isset( $wp_filter[ $tag ] ) ) {
		return FALSE;
	}
	if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
		$fob       = $wp_filter[ $tag ];
		$callbacks = &$wp_filter[ $tag ]->callbacks;
	} else {
		$callbacks = &$wp_filter[ $tag ];
	}
	if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) {
		return FALSE;
	}
	foreach ( (array) $callbacks[ $priority ] as $filter_id => $filter ) {
		if ( ! isset( $filter['function'] ) || ! is_array( $filter['function'] ) ) {
			continue;
		}
		if ( ! is_object( $filter['function'][0] ) ) {
			continue;
		}
		if ( $filter['function'][1] !== $method_name ) {
			continue;
		}
		if ( get_class( $filter['function'][0] ) === $class_name ) {
			if ( isset( $fob ) ) {
				$fob->remove_filter( $tag, $filter['function'], $priority );
			} else {
				unset( $callbacks[ $priority ][ $filter_id ] );
				if ( empty( $callbacks[ $priority ] ) ) {
					unset( $callbacks[ $priority ] );
				}
				if ( empty( $callbacks ) ) {
					$callbacks = array();
				}
				unset( $GLOBALS['merged_filters'][ $tag ] );
			}
			return TRUE;
		}
	}
	return FALSE;
}
if ( class_exists( 'Sliced_Discounts_And_Partial_Payment' ) ) {
	add_action( 'init', 'sliced_no_dapp', 9 );
}

// Patch for Sage-based themes
function sliced_patch_for_sage_based_themes() {
	// The following is our own solution to the problem of Sage-based themes
	// which force their own "wrapper", injecting code into our templates where
	// it is not wanted, breaking them.
	// i.e.: https://discourse.roots.io/t/single-template-filter-from-plugins/6637
	global $wp_filter;
	$tag = 'template_include';
	$priority = 99;
	if ( ! isset( $wp_filter[ $tag ] ) ) {
		return FALSE;
	}
	if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
		$fob       = $wp_filter[ $tag ];
		$callbacks = &$wp_filter[ $tag ]->callbacks;
	} else {
		$callbacks = &$wp_filter[ $tag ];
	}
	if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) {
		return FALSE;
	}
	foreach ( (array) $callbacks[ $priority ] as $filter_id => $filter ) {
		if ( ! isset( $filter['function'] ) || ! is_array( $filter['function'] ) ) {
			continue;
		}
		if ( $filter['function'][1] !== 'wrap' ) {
			continue;
		}
		if ( isset( $fob ) ) {
			$fob->remove_filter( $tag, $filter['function'], $priority );
		} else {
			unset( $callbacks[ $priority ][ $filter_id ] );
			if ( empty( $callbacks[ $priority ] ) ) {
				unset( $callbacks[ $priority ] );
			}
			if ( empty( $callbacks ) ) {
				$callbacks = array();
			}
			unset( $GLOBALS['merged_filters'][ $tag ] );
		}
		return TRUE;
	}
	return FALSE;
}
add_action( 'get_template_part_sliced-invoice-display', 'sliced_patch_for_sage_based_themes' );
add_action( 'get_template_part_sliced-quote-display', 'sliced_patch_for_sage_based_themes' );
add_action( 'get_template_part_sliced-payment-display', 'sliced_patch_for_sage_based_themes' );




/* That's all folks. Happy invoicing! */
