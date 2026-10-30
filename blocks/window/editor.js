( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck, RichText } = wp.blockEditor;
	const { PanelBody, Button, FocalPointPicker, TextControl, RangeControl } = wp.components;
	const { useSelect } = wp.data;
	const { __ } = wp.i18n;

	const text = ( a, set, key, className, placeholder, tagName ) => el( RichText, {
		tagName: tagName || 'span', className, placeholder, value: a[ key ], allowedFormats: [], onChange: ( v ) => set( { [ key ]: v } ),
	} );

	registerBlockType( 'rainshade/window', {
		edit( { attributes: a, setAttributes: set } ) {
			const url = a.mediaUrl || window.rainshadeTheme.images + 'night.jpg';
			const pos = `${ a.focalPoint.x * 100 }% ${ a.focalPoint.y * 100 }%`;
			const name = useSelect( ( select ) => ( select( 'core' ).getEntityRecord( 'root', 'site' ) || {} ).title, [] ) || 'rainshade';

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Photo', 'rainshade' ) },
						el( MediaUploadCheck, null,
							el( MediaUpload, {
								allowedTypes: [ 'image' ],
								value: a.mediaId,
								onSelect: ( m ) => set( { mediaId: m.id, mediaUrl: m.url } ),
								render: ( { open } ) => el( Button, { variant: 'secondary', onClick: open }, __( 'Replace photo', 'rainshade' ) ),
							} )
						),
						el( FocalPointPicker, { label: __( 'Focal point', 'rainshade' ), url, value: a.focalPoint, onChange: ( v ) => set( { focalPoint: v } ) } ),
						el( RangeControl, { label: __( 'Height (px)', 'rainshade' ), min: 560, max: 1200, step: 10, value: a.height, onChange: ( v ) => set( { height: v } ) } ),
						el( TextControl, { label: __( 'Link', 'rainshade' ), type: 'url', value: a.linkUrl, onChange: ( v ) => set( { linkUrl: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				// Static preview: the fog itself only runs on the site.
				el( 'section', useBlockProps( { className: 'rs-window', style: { height: a.height + 'px', '--rs-pos': pos, cursor: 'default' } } ),
					el( 'img', { className: 'rs-window__photo', src: url, alt: '' } ),
					el( 'div', { className: 'rs-window__name' }, el( 'span', { style: { backgroundImage: `url(${ url })` } }, name ) ),
					el( 'div', { className: 'rs-window__bar' },
						el( 'div', { className: 'rs-window__release' },
							text( a, set, 'eyebrow', 'rs-window__eyebrow', __( 'e.g. debut album · out 30.10', 'rainshade' ) ),
							el( 'span', { className: 'rs-window__cta' },
								text( a, set, 'release', 'rs-window__title', __( 'release title', 'rainshade' ) ),
								text( a, set, 'linkText', 'rs-window__link', __( 'link text', 'rainshade' ) )
							)
						),
						text( a, set, 'hint', 'rs-window__hint', __( 'hint', 'rainshade' ) )
					)
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
