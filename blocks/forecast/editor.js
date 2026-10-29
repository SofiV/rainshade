( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps, useInnerBlocksProps, RichText, InnerBlocks } = wp.blockEditor;
	const { __ } = wp.i18n;

	registerBlockType( 'rainshade/forecast', {
		edit( { attributes: a, setAttributes: set } ) {
			const inner = useInnerBlocksProps( { className: 'rs-forecast__list' }, {
				allowedBlocks: [ 'rainshade/track' ],
				template: [ [ 'rainshade/track' ] ],
				templateLock: false, // the Release section locks its own layout; tracks stay free

				renderAppender: InnerBlocks.ButtonBlockAppender,
			} );
			return el( 'div', useBlockProps( { className: 'rs-forecast' } ),
				el( 'div', { className: 'rs-forecast__head' },
					el( RichText, { tagName: 'span', value: a.headLeft, allowedFormats: [], onChange: ( v ) => set( { headLeft: v } ), placeholder: __( 'forecast for…', 'rainshade' ) } ),
					el( RichText, { tagName: 'span', value: a.headRight, allowedFormats: [], onChange: ( v ) => set( { headRight: v } ) } )
				),
				el( 'div', inner )
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
