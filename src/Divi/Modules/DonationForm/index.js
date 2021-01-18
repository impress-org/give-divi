// External Dependencies
import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonationForm extends React.Component {
	static slug = 'give_donation_form';

	constructor( props ) {
		super( props );

		this.state = {
			fetching: false,
			content: null,
		};
	}

	getSnapshotBeforeUpdate( prevProps ) {
		if (
			prevProps.id !== this.props.id ||
			prevProps.style !== this.props.style ||
			prevProps.title !== this.props.title ||
			prevProps.goal !== this.props.goal
		) {
			return {
				id: this.props.id,
				style: this.props.style,
				title: this.props.title === 'on',
				goal: this.props.goal === 'on',
			};
		}

		return null;
	}

	componentDidMount() {
		if ( this.props.id ) {
			this.fetchDonationForm(
				{
					id: this.props.id,
					style: this.props.style,
					title: this.props.title === 'on',
					goal: this.props.goal === 'on',
				}
			);
		}
	}

	componentDidUpdate( prevProps, prevState, snapshot ) {
		if ( snapshot && ! this.state.fetching ) {
			this.fetchDonationForm( snapshot );
		}
	}

	fetchDonationForm( params ) {
		this.setState(
			{
				fetching: true,
			}
		);

		API.post( '/render-donation-form', params, { cancelToken: CancelToken.token } )
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
