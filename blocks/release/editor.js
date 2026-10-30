( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck, RichText } = wp.blockEditor;
	const { PanelBody, Button, TextControl } = wp.components;
	const { __ } = wp.i18n;

	const text = ( a, set, key, className, placeholder, tagName ) => el( RichText, {
		tagName: tagName || 'span', className, placeholder, value: a[ key ], allowedFormats: [], onChange: ( v ) => set( { [ key ]: v } ),
	} );

	// Apple Music in Social Icons (rendered on the site by the filter in inc/blocks.php).
	wp.blocks.registerBlockVariation( 'core/social-link', {
		name: 'applemusic',
		title: 'Apple Music',
		icon: el( 'svg', { viewBox: '0 0 24 24' }, el( 'path', { d: window.rainshadeTheme.appleMusic } ) ),
		attributes: { service: 'applemusic' },
		isActive: [ 'service' ],
	} );

	registerBlockType( 'rainshade/release', {
		edit( { attributes: a, setAttributes: set } ) {
			const inner = useInnerBlocksProps( {}, {
				// Tracklist + where to listen (core Social Icons; links without a URL don't show on the site).
				allowedBlocks: [ 'rainshade/forecast', 'core/social-links' ],
				template: [
					[ 'rainshade/forecast', {}, [ [ 'rainshade/track' ] ] ],
					[ 'core/social-links', { showLabels: true, openInNewTab: true, className: 'is-style-logos-only' }, [
						[ 'core/social-link', { service: 'spotify' } ],
						[ 'core/social-link', { service: 'applemusic' } ],
						[ 'core/social-link', { service: 'youtube', label: 'youtube music' } ],
						[ 'core/social-link', { service: 'soundcloud' } ],
					] ],
				],
			} );

			const picker = ( label ) => el( MediaUploadCheck, null,
				el( MediaUpload, {
					allowedTypes: [ 'image' ],
					value: a.mediaId,
					onSelect: ( m ) => set( { mediaId: m.id, mediaUrl: m.url } ),
					render: ( { open } ) => el( Button, { variant: 'secondary', onClick: open }, label ),
				} )
			);

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Release', 'rainshade' ) },
						picker( __( 'Replace cover', 'rainshade' ) ),
						el( TextControl, { label: __( 'Link', 'rainshade' ), type: 'url', value: a.linkUrl, onChange: ( v ) => set( { linkUrl: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				el( 'section', useBlockProps( { className: 'rs-release' } ),
					el( 'div', { className: 'rs-release__cover' },
						a.mediaUrl
							? el( 'img', { src: a.mediaUrl, alt: '' } )
							: el( 'div', { className: 'rs-pick', style: { position: 'relative' } }, el( 'span', { className: 'rs-frame' } ), picker( __( 'Choose cover', 'rainshade' ) ) )
					),
					el( 'div', { className: 'rs-release__info' },
						el( 'div', { className: 'rs-release__head' },
							text( a, set, 'eyebrow', 'rs-release__eyebrow', __( 'e.g. debut album · 30.10', 'rainshade' ) ),
							text( a, set, 'title', 'rs-release__title', __( 'title', 'rainshade' ), 'h2' )
						),
						el( 'div', inner ),
						text( a, set, 'linkText', 'rs-release__link', __( 'link text', 'rainshade' ) )
					)
				)
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
