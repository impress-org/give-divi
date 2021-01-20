<?php
namespace GiveDivi\Divi\Repositories;

/**
 * Class Donation
 * @package GiveDivi\Divi\Repositories
 */
class Donation {

	/**
	 * Get Donor's last donation id
	 *
	 * @param int $donorId
	 *
	 * @return int
	 */
	public function getLastDonationId( $donorId ) {
		if ( ! $donorId ) {
			return 0;
		}

		$post = get_posts(
			[
				'post_type'   => 'give_payment',
				'post_status' => 'publish',
				'author'      => $donorId,
				'numberposts' => 1,
			]
		);

		if ( empty( $post ) ) {
			return 0;
		}

		return $post[0]->ID;
	}
}
