<?php
namespace GiveDivi\Divi\Repositories;

/**
 * Class Donation
 * @package GiveDivi\Divi\Repositories
 */
class Donation {

	/**
	 * Get last donation id from the revenue table
	 * @return int
	 */
	public function getLastDonationId() {
		global $wpdb;

		return $wpdb->get_var(
			"
			SELECT donation_id 
			FROM {$wpdb->prefix}give_revenue
			ORDER BY donation_id DESC 
			LIMIT 1
			"
		);

	}

	/**
	 * Get donation receipt preview
	 *
	 * @param array $attributes
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getReceiptPreview( $attributes ) {
		global $give_receipt_args, $donation;

		$donation          = $this->getLastDonationId();
		$give_receipt_args = $attributes;

		ob_start();
		give_get_template_part( 'shortcode', 'receipt' );
		return ob_get_clean();
	}
}
