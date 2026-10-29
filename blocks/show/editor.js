( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps } = wp.blockEditor;
	const { TextControl } = wp.components;
	const { __ } = wp.i18n;

	registerBlockType( 'rainshade/show', {
		edit( { attributes: a, setAttributes: set } ) {
			const input = ( key, label, type ) => el( TextControl, {
				label,
				type: type || 'text',
				value: a[ key ],
				onChange: ( v ) => set( { [ key ]: v } ),
				__nextHasNoMarginBottom: true,
			} );
			const past = a.date && a.date < new Date().toISOString().slice( 0, 10 );
			return el( 'div', useBlockProps( { className: 'rs-show-edit', style: { display: 'grid', gridTemplateColumns: '160px 1fr 1fr 1fr', gap: '12px', alignItems: 'end', padding: '12px 0', opacity: past ? 0.45 : 1 } } ),
				input( 'date', past ? __( 'Date (past — hidden)', 'rainshade' ) : __( 'Date', 'rainshade' ), 'date' ),
				input( 'city', __( 'City', 'rainshade' ) ),
				input( 'venue', __( 'Venue / event', 'rainshade' ) ),
				input( 'url', __( 'Tickets link', 'rainshade' ), 'url' )
			);
		},
		save: () => null,
	} );
} )( window.wp );
