import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class MultiFormGoal extends React.Component {
    static slug = 'give_multi_form_goal';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.ids !== this.props.ids ||
            prevProps.tags !== this.props.tags ||
            prevProps.categories !== this.props.categories ||
            prevProps.goal !== this.props.goal ||
            prevProps.enddate !== this.props.enddate ||
            prevProps.color !== this.props.color ||
            prevProps.heading !== this.props.heading ||
            prevProps.image !== this.props.image ||
            prevProps.summary !== this.props.summary
        ) {
            return {
                ids: this.props.ids,
                tags: this.props.tags,
                categories: this.props.categories,
                goal: this.props.goal,
                enddate: this.props.enddate,
                color: this.props.color,
                heading: this.props.heading,
                image: this.props.image,
                summary: this.props.summary,
            };
        }

        return null;
    }

    componentDidMount() {
        const params = {
            ids: this.props.ids,
            tags: this.props.tags,
            categories: this.props.categories,
            goal: this.props.goal,
            enddate: this.props.enddate,
            color: this.props.color,
            heading: this.props.heading,
            image: this.props.image,
            summary: this.props.summary,
        };

        this.fetchMultiFormGoal(params);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchMultiFormGoal(snapshot);
        }
    }

    fetchMultiFormGoal(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-multi-form-goal', params, {cancelToken: CancelToken.token})
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
