// External Dependencies
import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonationReceipt extends React.Component {
	static slug = 'give_donation_receipt';

	constructor( props ) {
		super( props );

		this.state = {
			fetching: false,
			content: null,
		};
	}

	getSnapshotBeforeUpdate( prevProps ) {
		if (
			prevProps.donor !== this.props.donor ||
			prevProps.price !== this.props.price ||
			prevProps.date !== this.props.date ||
			prevProps.date !== this.props.date ||
			prevProps.payment_method !== this.props.payment_method ||
			prevProps.payment_id !== this.props.payment_id ||
			prevProps.payment_status !== this.props.payment_status ||
			prevProps.company_name !== this.props.company_name ||
			prevProps.status_notice !== this.props.status_notice ||
			prevProps.error !== this.props.error
		) {
			return true;
		}

		return null;
	}

	componentDidMount() {
		this.fetchDonationReceipt();
	}

	componentDidUpdate( prevProps, prevState, snapshot ) {
		if ( snapshot && ! this.state.fetching ) {
			this.fetchDonationReceipt();
		}
	}

	fetchDonationReceipt() {
		this.setState(
			{
				fetching: true,
			}
		);

		const params = {
			donor: this.props.donor === 'on',
			price: this.props.price === 'on',
			date: this.props.date === 'on',
			payment_method: this.props.payment_method === 'on',
			payment_id: this.props.payment_id === 'on',
			payment_status: this.props.payment_status === 'on',
			company_name: this.props.company_name === 'on',
			status_notice: this.props.status_notice === 'on',
			error: this.props.error,
		};

		const delimiter = ( this.props.pretty_urls === 'on' ) ? '?' : '&';

		API.post( `/render-donation-receipt${ delimiter }donation_id=${ this.props.donation_id }`, params, { cancelToken: CancelToken.token } )
			.then( ( response ) => {
				this.setState( {
					fetching: false,
					content: response.data.content,
				} );
			} )
			.catch( () => {
				CancelToken.cancel();
				this.setState( {
					fetching: false,
					content: '',
				} );
			} );
	}

	render() {
		return (
			<>{ this.state.content && parse( this.state.content ) }</>
		);
	}
}
