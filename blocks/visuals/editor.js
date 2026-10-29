( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, RichText } = wp.blockEditor;
	const { PanelBody, TextControl } = wp.components;
	const { __ } = wp.i18n;

	const text = ( a, set, key, className, tagName ) => el( RichText, {
		tagName: tagName || 'span', className, value: a[ key ], allowedFormats: [], onChange: ( v ) => set( { [ key ]: v } ),
	} );

	registerBlockType( 'rainshade/visuals', {
		edit( { attributes: a, setAttributes: set } ) {
			const inner = useInnerBlocksProps( {}, {
				allowedBlocks: [ 'core/embed' ],
				template: [ [ 'core/embed', { providerNameSlug: 'vimeo' } ] ],
			} );
			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Link', 'rainshade' ) },
						el( TextControl, { label: __( 'Link', 'rainshade' ), type: 'url', value: a.linkUrl, onChange: ( v ) => set( { linkUrl: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				el( 'section', useBlockProps( { className: 'rs-visuals' } ),
					el( 'div', { className: 'rs-visuals__head' },
						text( a, set, 'heading', 'rs-visuals__heading', 'h2' ),
						text( a, set, 'note', 'rs-visuals__note' )
					),
					el( 'div', inner ),
					text( a, set, 'linkText', 'rs-visuals__link' )
				)
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
