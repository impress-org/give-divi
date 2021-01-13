// External Dependencies
import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonationForm extends React.Component {
	static slug = 'give_donation_form';

	constructor( props ) {
		super( props );

		const { id, style, title, goal } = props;

		this.state = {
			id,
			style,
			title,
			goal,
			fetching: false,
			content: null,
		};
	}

	getSnapshotBeforeUpdate( prevProps ) {
		const { id, style, title, goal } = this.props;

		if (
			prevProps.id !== id ||
			prevProps.style !== style ||
			prevProps.title !== title ||
			prevProps.goal !== goal
		) {
			return {
				id,
				style,
				title: title === 'on',
				goal: goal === 'on',
			};
		}

		return null;
	}

	componentDidMount() {
		if ( this.state.id ) {
			this.fetchDonationForm(
				{
					id: this.state.id,
					style: this.state.style,
					title: this.state.title === 'on',
					goal: this.state.goal === 'on',
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

		API.get( '/render-donation-form', { params }, { cancelToken: CancelToken.token } )
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
