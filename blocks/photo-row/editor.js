( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck, RichText } = wp.blockEditor;
	const { PanelBody, Button, RangeControl, SelectControl } = wp.components;
	const { __ } = wp.i18n;

	// No photos yet: as many empty frames as columns.
	const empty = ( n ) => Array.from( { length: n }, () => ( { url: '', alt: '', caption: '' } ) );

	registerBlockType( 'rainshade/photo-row', {
		edit( { attributes: a, setAttributes: set } ) {
			const images = a.images.length ? a.images : empty( a.columns );
			const setCaption = ( i, caption ) => set( { images: images.map( ( img, j ) => ( j === i ? { ...img, caption } : img ) ) } );

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Photos', 'rainshade' ) },
						el( MediaUploadCheck, null,
							el( MediaUpload, {
								allowedTypes: [ 'image' ],
								multiple: true,
								gallery: true,
								value: a.images.map( ( img ) => img.id ).filter( Boolean ),
								onSelect: ( list ) => set( { images: list.map( ( m ) => ( { id: m.id, url: m.url, alt: m.alt, caption: m.caption || '' } ) ) } ),
								render: ( { open } ) => el( Button, { variant: 'secondary', onClick: open }, __( 'Choose photos', 'rainshade' ) ),
							} )
						),
						el( RangeControl, { label: __( 'Columns', 'rainshade' ), min: 1, max: 6, value: a.columns, onChange: ( v ) => set( { columns: v } ) } ),
						el( SelectControl, {
							label: __( 'Shape', 'rainshade' ),
							value: a.ratio,
							options: [ { label: 'portrait 4:5', value: '4/5' }, { label: 'square', value: '1/1' }, { label: 'landscape 3:2', value: '3/2' } ],
							onChange: ( v ) => set( { ratio: v } ),
							__nextHasNoMarginBottom: true,
						} )
					)
				),
				el( 'section', useBlockProps( { className: 'rs-photos', style: { '--rs-cols': a.columns, '--rs-ratio': a.ratio } } ),
					images.map( ( img, i ) => el( 'figure', { key: i, className: 'rs-photos__item' },
						img.url ? el( 'img', { src: img.url, alt: '' } ) : el( 'span', { className: 'rs-frame' } ),
						el( RichText, { tagName: 'figcaption', value: img.caption, allowedFormats: [], placeholder: __( 'caption', 'rainshade' ), onChange: ( v ) => setCaption( i, v ) } )
					) )
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
