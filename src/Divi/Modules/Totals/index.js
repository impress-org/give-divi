import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class Totals extends React.Component {
    static slug = 'give_totals';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.total_goal !== this.props.total_goal ||
            prevProps.ids !== this.props.ids ||
            prevProps.cats !== this.props.cats ||
            prevProps.tags !== this.props.tags ||
            prevProps.message !== this.props.message ||
            prevProps.link !== this.props.link ||
            prevProps.link_text !== this.props.link_text ||
            prevProps.progress_bar !== this.props.progress_bar
        ) {
            return {
                total_goal: this.props.total_goal,
                ids: this.props.ids,
                cats: this.props.cats,
                tags: this.props.tags,
                message: this.props.message,
                link: this.props.link,
                link_text: this.props.link_text,
                progress_bar: this.props.progress_bar === 'on',
            };
        }

        return null;
    }

    componentDidMount() {
        const params = {
            total_goal: this.props.total_goal,
            ids: this.props.ids,
            cats: this.props.cats,
            tags: this.props.tags,
            message: this.props.message,
            link: this.props.link,
            link_text: this.props.link_text,
            progress_bar: this.props.progress_bar === 'on',
        };

        this.fetchDonorWall(params);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchDonorWall(snapshot);
        }
    }

    fetchDonorWall(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-totals', params, {cancelToken: CancelToken.token})
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
