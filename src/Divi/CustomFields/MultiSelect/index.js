import { Component } from 'react';
// eslint-disable-next-line no-unused-vars
import MultiSelect from '@khanacademy/react-multi-select';

import './style.css';

class MultiSelectField extends Component {
	static slug = 'give_multi_select';

	options = Object.entries( this.props.fieldDefinition.options ).map( ( [ value, label ] ) => ( { label, value } ) );
	selectedOptions = ( this.props.value.length > 0 )
		? this.props.value.split( ',' )
		: [];

	state = {
		selected: this.selectedOptions,
	}

	_onChange = ( selected ) => {
		this.setState( { selected } );

		const selectedOptions = selected.filter( ( option ) => option.length > 0 );
		const filteredOptions = ( selectedOptions.length > 1 )
			? selectedOptions.join( ',' )
			: selectedOptions[ 0 ];

		this.props._onChange( this.props.name, filteredOptions );
	}

	render() {
		return (
			<MultiSelect
				options={ this.options }
				selected={ this.state.selected }
				onSelectedChanged={ this._onChange }
				value={ this.props.value }
			/>
		);
	}
}

export default MultiSelectField;
