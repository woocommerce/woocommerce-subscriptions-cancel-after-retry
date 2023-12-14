<?php
/*
 * Plugin Name: WooCommerce Subscriptions - Cancel After Failed Retries
 * Plugin URI: https://github.com/Prospress/woocommerce-subscriptions-cancel-after-retry
 * Description: Cancel an order and associated subscriptions after all automatic failed payment retry attempts have failed.
 * Author: Prospress Inc.
 * Author URI: https://prospress.com/
 * License: GPLv3
 * Version: 1.0.0
 * Requires at least: 4.0
 * Tested up to: 5.0.0
 * WC tested up to: 3.5.1
 *
 * GitHub Plugin URI: Prospress/{plugin_slug}
 * GitHub Branch: master
 *
 * Copyright 2018 Prospress, Inc.  (email : freedoms@prospress.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		WooCommerce Subscriptions - Cancel After Failed Retries
 * @author		Prospress Inc.
 * @since		1.0
 */

require_once( 'includes/class-pp-dependencies.php' );

if ( false === PP_Dependencies::is_woocommerce_active( '3.0' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'WooCommerce Subscriptions - Cancel After Failed Retries', 'WooCommerce', '3.0' );
	return;
}

if ( false === PP_Dependencies::is_subscriptions_active( '2.1' ) ) {
	PP_Dependencies::enqueue_admin_notice( 'WooCommerce Subscriptions - Cancel After Failed Retries', 'WooCommerce Subscriptions', '2.1' );
	return;
}

/**
 * After a payment retry is processed, if the payment failed and there are no more retry
 * rules, transition the order and associated subscriptions to cancelled status.
 *
 * @param WCS_Retry $retry Details of the retry just processed
 * @param WC_Order The order on which the failed payment retry attempt was processed
 */
function wcscar_after_payment_retry( $retry, $order ) {

	// If payment completed, nothing to do
	if ( ! $order->needs_payment() ) {
		return;
	}

	$order_note    = __( 'All payment retry attempts failed:', 'woocommerce-subscriptions-cancel-after-retry' );
	$cancel_order  = false;
	$subscriptions = wcs_get_subscriptions_for_renewal_order( $order );

	foreach ( $subscriptions as $subscription ) {
		// The subscription will only have retry date in future if this isn't the last retry
		if ( $subscription->get_time( 'payment_retry' ) <= gmdate( 'U' ) ) {
			$subscription->update_status( 'cancelled', $order_note );
			$cancel_order = true;
		}
	}

	if ( $cancel_order ) {
		$order->update_status( 'cancelled', $order_note );
		do_action( 'woocommerce_subscriptions_cancelled_after_retry', $order, $subscription, $retry );
	}
}
add_filter( 'woocommerce_subscriptions_after_payment_retry', 'wcscar_after_payment_retry', 10, 2 );
