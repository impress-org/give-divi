import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class RegistrationForm extends React.Component {
    static slug = 'give_registration_form';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (prevProps.active !== this.props.active || prevProps.redirect !== this.props.redirect) {
            return true;
        }

        return null;
    }

    componentDidMount() {
        this.fetchRegistrationForm();
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchRegistrationForm();
        }
    }

    fetchRegistrationForm() {
        this.setState({
            fetching: true,
        });

        const params = {
            active: this.props.active === 'on',
            redirect: this.props.redirect,
        };

        API.post('/render-registration-form', params, {cancelToken: CancelToken.token})
            .then((response) => {
                this.setState({
                    fetching: false,
                    content: response.data.content,
                });
            })
            .catch(() => {
                CancelToken.cancel();
                this.setState({
                    fetching: false,
                    content: '',
                });
            });
    }

    render() {
        return <>{this.state.content && parse(this.state.content)}</>;
    }
}
