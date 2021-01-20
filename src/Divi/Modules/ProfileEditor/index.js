import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class ProfileEditor extends React.Component {
	static slug = 'give_profile_editor';

	constructor( props ) {
		super( props );

		this.state = {
			content: null,
		};
	}

	componentDidMount() {
		API.post( '/render-profile-editor', { cancelToken: CancelToken.token } )
			.then( ( response ) => {
				this.setState( {
					content: response.data.content,
				} );
			} )
			.catch( () => {
				CancelToken.cancel();
				this.setState( {
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
