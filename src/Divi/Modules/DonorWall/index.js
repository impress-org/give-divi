import React from 'react';
import API, { CancelToken } from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonorWall extends React.Component {
	static slug = 'give_donor_wall';

	getSnapshotBeforeUpdate() {
		// TODO: check props

		return null;
	}

	componentDidMount() {
		if ( this.state.id ) {
			this.fetchDonorWall(
				{
					// TODO: add attributes
				}
			);
		}
	}

	componentDidUpdate( prevProps, prevState, snapshot ) {
		if ( snapshot && ! this.state.fetching ) {
			this.fetchDonorWall( snapshot );
		}
	}

	fetchDonorWall( params ) {
		this.setState(
			{
				fetching: true,
			}
		);

		API.get( '/render-donor-wall', { params }, { cancelToken: CancelToken.token } )
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
