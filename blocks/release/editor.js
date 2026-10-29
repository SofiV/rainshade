( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck, RichText } = wp.blockEditor;
	const { PanelBody, Button, TextControl } = wp.components;
	const { __ } = wp.i18n;

	const text = ( a, set, key, className, tagName ) => el( RichText, {
		tagName: tagName || 'span', className, value: a[ key ], allowedFormats: [], onChange: ( v ) => set( { [ key ]: v } ),
	} );

	registerBlockType( 'rainshade/release', {
		edit( { attributes: a, setAttributes: set } ) {
			const url = a.mediaUrl || window.rainshadeTheme.images + 'fall-cover.jpg';
			const inner = useInnerBlocksProps( {}, {
				allowedBlocks: [ 'rainshade/forecast' ],
				template: [ [ 'rainshade/forecast', {}, [ [ 'rainshade/track' ] ] ] ],
				templateLock: 'insert',
			} );

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Release', 'rainshade' ) },
						el( MediaUploadCheck, null,
							el( MediaUpload, {
								allowedTypes: [ 'image' ],
								value: a.mediaId,
								onSelect: ( m ) => set( { mediaId: m.id, mediaUrl: m.url } ),
								render: ( { open } ) => el( Button, { variant: 'secondary', onClick: open }, __( 'Replace cover', 'rainshade' ) ),
							} )
						),
						el( TextControl, { label: __( 'Link', 'rainshade' ), type: 'url', value: a.linkUrl, onChange: ( v ) => set( { linkUrl: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				el( 'section', useBlockProps( { className: 'rs-release' } ),
					el( 'div', { className: 'rs-release__cover' }, el( 'img', { src: url, alt: '' } ) ),
					el( 'div', { className: 'rs-release__info' },
						el( 'div', { className: 'rs-release__head' },
							text( a, set, 'eyebrow', 'rs-release__eyebrow' ),
							text( a, set, 'title', 'rs-release__title', 'h2' )
						),
						el( 'div', inner ),
						text( a, set, 'linkText', 'rs-release__link' )
					)
				)
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
