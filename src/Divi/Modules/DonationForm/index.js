// External Dependencies
import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonationForm extends React.Component {
	static slug = 'give_donation_form';

	constructor( props ) {
		super( props );
		this.state = {
			id: props.id,
			displayStyle: props.displayStyle,
			showTitle: props.showTitle,
			showGoal: props.showGoal,
			fetching: false,
			content: null,
		};
	}

	getSnapshotBeforeUpdate( prevProps ) {
		const { id, displayStyle, showTitle, showGoal } = this.props;

		if (
			prevProps.id !== id ||
			prevProps.displayStyle !== displayStyle ||
			prevProps.showTitle !== showTitle ||
			prevProps.showGoal !== showGoal
		) {
			return {
				id,
				displayStyle,
				showTitle: showTitle === 'on',
				showGoal: showGoal === 'on',
			};
		}

		return null;
	}

	componentDidMount() {
		if ( this.state.id ) {
			this.fetchDonationForm(
				{
					id: this.state.id,
					displayStyle: this.state.displayStyle,
					showTitle: this.state.showTitle === 'on',
					showGoal: this.state.showGoal === 'on',
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
