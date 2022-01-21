import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class FormGoal extends React.Component {
    static slug = 'give_form_goal';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (prevProps.id !== this.props.id || prevProps.text !== this.props.text || prevProps.bar !== this.props.bar) {
            return true;
        }

        return null;
    }

    componentDidMount() {
        if (this.props.id) {
            this.fetchFormGoal();
        }
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchFormGoal();
        }
    }

    fetchFormGoal() {
        this.setState({
            fetching: true,
        });

        const params = {
            id: this.props.id,
            text: this.props.text === 'on',
            bar: this.props.bar === 'on',
        };

        API.post('/render-form-goal', params, {cancelToken: CancelToken.token})
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
