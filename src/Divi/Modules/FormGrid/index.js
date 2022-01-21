import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class FormGrid extends React.Component {
    static slug = 'give_form_grid';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.forms_per_page !== this.props.forms_per_page ||
            prevProps.ids !== this.props.ids ||
            prevProps.exclude !== this.props.exclude ||
            prevProps.orderby !== this.props.orderby ||
            prevProps.order !== this.props.order ||
            prevProps.columns !== this.props.columns ||
            prevProps.cats !== this.props.cats ||
            prevProps.tags !== this.props.tags ||
            prevProps.show_title !== this.props.show_title ||
            prevProps.show_goal !== this.props.show_goal ||
            prevProps.show_excerpt !== this.props.show_excerpt ||
            prevProps.show_featured_image !== this.props.show_featured_image ||
            prevProps.image_size !== this.props.image_size ||
            prevProps.image_height !== this.props.image_height ||
            prevProps.excerpt_length !== this.props.excerpt_length ||
            prevProps.style !== this.props.style ||
            prevProps.status !== this.props.status
        ) {
            return {
                forms_per_page: this.props.forms_per_page,
                ids: this.props.ids,
                exclude: this.props.exclude,
                orderby: this.props.orderby,
                order: this.props.order,
                columns: this.props.columns,
                cats: this.props.cats,
                tags: this.props.tags,
                show_title: this.props.show_title === 'on',
                show_goal: this.props.show_goal === 'on',
                show_excerpt: this.props.show_excerpt === 'on',
                show_featured_image: this.props.show_featured_image === 'on',
                image_size: this.props.image_size,
                image_height: this.props.image_height,
                excerpt_length: this.props.excerpt_length,
                style: this.props.style,
                status: this.props.status,
            };
        }

        return null;
    }

    componentDidMount() {
        this.fetchFormGrid({
            forms_per_page: this.props.forms_per_page,
            ids: this.props.ids,
            exclude: this.props.exclude,
            orderby: this.props.orderby,
            order: this.props.order,
            columns: this.props.columns,
            cats: this.props.cats,
            tags: this.props.tags,
            show_title: this.props.show_title === 'on',
            show_goal: this.props.show_goal === 'on',
            show_excerpt: this.props.show_excerpt === 'on',
            show_featured_image: this.props.show_featured_image === 'on',
            image_size: this.props.image_size,
            image_height: this.props.image_height,
            excerpt_length: this.props.excerpt_length,
            style: this.props.style,
            status: this.props.status,
        });
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchFormGrid(snapshot);
        }
    }

    fetchFormGrid(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-form-grid', params, {cancelToken: CancelToken.token})
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
