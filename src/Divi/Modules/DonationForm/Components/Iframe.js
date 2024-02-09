import React, {createRef} from 'react';
/**
 * @since 2.0.0
 */
export default function Iframe({dataSrc}) {
    const iframe = createRef();

    return (
        <iframe
            ref={iframe}
            src={dataSrc}
            style={{
                width: '1px',
                minWidth: '100%',
                border: '0',
            }}
            onLoad={() => {
                iframe.current.height = iframe.current.contentWindow.document.body.scrollHeight;
            }}
        />
    );
}
