( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps, useInnerBlocksProps, InnerBlocks, RichText } = wp.blockEditor;
	const { __ } = wp.i18n;

	registerBlockType( 'rainshade/shows', {
		edit( { attributes: a, setAttributes: set } ) {
			const inner = useInnerBlocksProps( {}, {
				allowedBlocks: [ 'rainshade/show' ],
				renderAppender: InnerBlocks.ButtonBlockAppender,
			} );
			return el( 'section', useBlockProps( { className: 'rs-shows' } ),
				el( RichText, { tagName: 'h2', className: 'rs-shows__heading', value: a.heading, allowedFormats: [], onChange: ( v ) => set( { heading: v } ) } ),
				el( 'div', { className: 'rs-shows__list' },
					el( 'div', inner ),
					el( RichText, {
						tagName: 'p',
						className: 'rs-shows__empty',
						value: a.emptyText,
						allowedFormats: [],
						onChange: ( v ) => set( { emptyText: v } ),
						'aria-label': __( 'Text when there are no upcoming dates', 'rainshade' ),
					} )
				)
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
