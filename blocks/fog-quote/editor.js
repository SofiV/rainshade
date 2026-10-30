( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
	const { PanelBody, Button, FocalPointPicker, TextareaControl } = wp.components;
	const { __ } = wp.i18n;

	registerBlockType( 'rainshade/fog-quote', {
		edit( { attributes: a, setAttributes: set } ) {
			const url = a.mediaUrl;
			const pos = `${ a.focalPoint.x * 100 }% ${ a.focalPoint.y * 100 }%`;

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Glass', 'rainshade' ) },
						el( MediaUploadCheck, null,
							el( MediaUpload, {
								allowedTypes: [ 'image' ],
								value: a.mediaId,
								onSelect: ( m ) => set( { mediaId: m.id, mediaUrl: m.url } ),
								render: ( { open } ) => el( Button, { variant: 'secondary', onClick: open }, url ? __( 'Replace photo', 'rainshade' ) : __( 'Choose photo', 'rainshade' ) ),
							} )
						),
						url && el( FocalPointPicker, { label: __( 'Focal point', 'rainshade' ), url, value: a.focalPoint, onChange: ( v ) => set( { focalPoint: v } ) } ),
						el( TextareaControl, { label: __( 'Words on the glass', 'rainshade' ), help: __( 'New line = line break.', 'rainshade' ), value: a.text, onChange: ( v ) => set( { text: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				el( 'figure', useBlockProps( { className: 'rs-fogquote' + ( url ? '' : ' is-empty' ), style: { '--rs-pos': pos } } ),
					url && el( 'img', { className: 'rs-fogquote__photo', src: url, alt: '' } ),
					url && el( 'div', { className: 'rs-fogquote__glass' }, el( 'img', { src: url, alt: '' } ) ),
					el( 'blockquote', { className: 'rs-fogquote__text', style: { backgroundImage: url ? `url(${ url })` : 'none', whiteSpace: 'pre-line' } }, a.text || __( 'Add words in the sidebar →', 'rainshade' ) )
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
