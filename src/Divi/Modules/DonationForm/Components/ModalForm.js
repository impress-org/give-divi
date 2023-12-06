import React from 'react';
import {createPortal} from 'react-dom';
import Iframe from './Iframe'

/**
 * @unreleased
 */
export default class ModalForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            isOpen: false
        }
    }
    toggleModal = () => {
        this.setState({
            isOpen: !this.state.isOpen
        });
    };
    render() {
        return (
            <div className={'givewp-donation-form-modal'}>
                <button className={'givewp-donation-form-modal__open'} onClick={this.toggleModal}>
                    Donate
                </button>
                {this.state.isOpen &&
                    createPortal(
                        <dialog className={'givewp-donation-form-modal__dialog'}>
                            <button
                                className="givewp-donation-form-modal__close"
                                type="button"
                                aria-label="Close"
                                onClick={this.toggleModal}
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    aria-hidden="true"
                                    focusable="false"
                                >
                                    <path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path>
                                </svg>
                            </button>
                            <Iframe dataSrc={dataSrc} />
                        </dialog>,
                        document.body
                    )}
            </div>
        )
    }
}
