import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class LoginForm extends React.Component {
	static slug = 'give_login_form';

	constructor( props ) {
		super( props );

		this.state = {
			fetching: false,
			content: null,
		};
	}

	getSnapshotBeforeUpdate( prevProps ) {
		if (
			prevProps.redirect !== this.props.redirect ||
			prevProps.login !== this.props.login ||
			prevProps.logout !== this.props.logout
		) {
			return true;
		}

		return null;
	}

	componentDidMount() {
		this.fetchLoginForm();
	}

	componentDidUpdate( prevProps, prevState, snapshot ) {
		if ( snapshot && ! this.state.fetching ) {
			this.fetchLoginForm();
		}
	}

	fetchLoginForm() {
		this.setState(
			{
				fetching: true,
			}
		);

		const params = {
			redirect: this.props.redirect === 'on',
			login: this.props.login,
			logout: this.props.logout,
		};

		API.post( '/render-login-form', params, { cancelToken: CancelToken.token } )
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
