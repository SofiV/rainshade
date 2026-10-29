( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps, RichText } = wp.blockEditor;
	const { __ } = wp.i18n;

	const field = ( a, set, key, className, placeholder ) => el( RichText, {
		tagName: 'span',
		className,
		value: a[ key ],
		allowedFormats: [],
		placeholder,
		onChange: ( v ) => set( { [ key ]: v } ),
	} );

	registerBlockType( 'rainshade/track', {
		edit( { attributes: a, setAttributes: set } ) {
			return el( 'div', useBlockProps( { className: 'rs-track' } ),
				field( a, set, 'title', 'rs-track__title', __( 'track title', 'rainshade' ) ),
				field( a, set, 'bpm', 'rs-track__bpm', __( 'bpm', 'rainshade' ) ),
				field( a, set, 'tears', 'rs-track__tears', __( 'tears %', 'rainshade' ) )
			);
		},
		save: () => null,
	} );
} )( window.wp );
