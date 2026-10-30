( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, useInnerBlocksProps, InnerBlocks, InspectorControls, RichText } = wp.blockEditor;
	const { PanelBody, TextControl } = wp.components;
	const { useSelect } = wp.data;
	const { __ } = wp.i18n;

	const text = ( a, set, key, className, placeholder, tagName ) => el( RichText, {
		tagName: tagName || 'span', className, placeholder, value: a[ key ], allowedFormats: [], onChange: ( v ) => set( { [ key ]: v } ),
	} );

	registerBlockType( 'rainshade/visuals', {
		edit( { attributes: a, setAttributes: set, clientId } ) {
			const empty = useSelect( ( select ) => ! select( 'core/block-editor' ).getBlockCount( clientId ), [ clientId ] );
			const inner = useInnerBlocksProps( { className: 'rs-visuals__media' + ( empty ? ' rs-frame rs-visuals__empty' : '' ) }, {
				// YouTube/Vimeo link (Embed) or a file from the media library (Video). Can stay empty.
				allowedBlocks: [ 'core/embed', 'core/video' ],
				renderAppender: InnerBlocks.ButtonBlockAppender,
			} );

			return el( Fragment, null,
				el( InspectorControls, null,
					el( PanelBody, { title: __( 'Link', 'rainshade' ) },
						el( TextControl, { label: __( 'Link', 'rainshade' ), type: 'url', value: a.linkUrl, onChange: ( v ) => set( { linkUrl: v } ), __nextHasNoMarginBottom: true } )
					)
				),
				el( 'section', useBlockProps( { className: 'rs-visuals' } ),
					el( 'div', inner ),
					el( 'div', { className: 'rs-visuals__info' },
						el( 'div', { className: 'rs-visuals__head' },
							text( a, set, 'note', 'rs-visuals__note', __( 'small note', 'rainshade' ) ),
							text( a, set, 'heading', 'rs-visuals__title', __( 'heading', 'rainshade' ), 'h2' )
						),
						text( a, set, 'linkText', 'rs-visuals__link', __( 'link text', 'rainshade' ) )
					)
				)
			);
		},
		save: () => el( InnerBlocks.Content ),
	} );
} )( window.wp );
