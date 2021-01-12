// External Dependencies
import React, { Component } from 'react';

class DonationForm extends Component {

	static slug = 'donation_form';

	render() {
		const { donationFormId } = this.props;

		return (
			< h1 >
				{ donationFormId }
			< / h1 >
		);
	}
}

export default DonationForm;
