/**
 * rainshade — fogged glass and water drops.
 * Used by the "Fogged window" and "Words on fogged glass" blocks.
 * No dependencies. The fog is one canvas; drops are tiny lenses (a span with the same photo inside, magnified).
 */
( () => {
	const still = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	const rnd = ( i, s ) => { const x = Math.sin( i * 12.9898 + s * 78.233 ) * 43758.5453; return x - Math.floor( x ); };

	// Mostly tiny drops, a few big ones. Positions in 0..1.
	const seeds = ( n, s ) => Array.from( { length: n }, ( _, i ) => {
		const w = 4 + Math.pow( rnd( i, s + 1 ), 2.6 ) * 26;
		return { x: rnd( i, s ), y: rnd( i, s + 2 ), w, h: w * ( 1.08 + rnd( i, s + 3 ) * 0.3 ) };
	} );

	const lens = ( cls, src ) => {
		const span = document.createElement( 'span' );
		const img = document.createElement( 'img' );
		span.className = cls;
		img.src = src;
		img.alt = '';
		img.decoding = 'async';
		span.append( img );
		return span;
	};

	// Place a lens at x,y so the photo inside lines up with the photo behind the glass.
	const place = ( span, x, y, w, h, W, H, pos ) => {
		span.style.cssText = `left:${ x }px;top:${ y }px;width:${ w }px;height:${ h }px`;
		span.firstChild.style.cssText = `left:${ -x }px;top:${ -y }px;width:${ W }px;height:${ H }px;object-position:${ pos };transform-origin:${ x + w / 2 }px ${ y + h / 2 }px`;
	};

	const staticDrops = ( layer, box, src, pos, count, seed ) => {
		const list = seeds( count, seed ).map( ( d ) => ( { d, el: layer.appendChild( lens( 'rs-drop', src ) ) } ) );
		const layout = () => {
			const W = box.clientWidth, H = box.clientHeight;
			list.forEach( ( { d, el } ) => place( el, Math.round( d.x * W ), Math.round( d.y * H ), d.w, d.h, W, H, pos ) );
		};
		layout();
		return layout;
	};

	const posOf = ( el, fallback ) => getComputedStyle( el ).getPropertyValue( '--rs-pos' ).trim() || fallback;

	/* ---------- Fogged window ---------- */
	function initWindow( win ) {
		const src = win.dataset.src;
		const canvas = win.querySelector( '.rs-window__fog' );
		const layer = win.querySelector( '.rs-water' );
		if ( ! src || ! canvas ) return;

		const pos = posOf( win, '50% 40%' );
		const [ fx, fy ] = pos.split( ' ' ).map( ( v ) => parseFloat( v ) / 100 );
		const ctx = canvas.getContext( '2d' );
		const fog = document.createElement( 'canvas' );
		const img = new Image();
		let W = 0, H = 0, dpr = 1, last = null, running = false;

		const layoutDrops = staticDrops( layer, win, src, pos, 46, 31 );

		// Runners: drops that slide down in jerks and leave a clear trail.
		const runners = still ? [] : Array.from( { length: 5 }, () => ( {
			head: layer.appendChild( lens( 'rs-drop', src ) ),
			trail: layer.appendChild( lens( 'rs-trail', src ) ),
		} ) );
		const spawn = ( r, anywhere ) => {
			r.w = 7 + Math.random() * 5;
			r.x = 40 + Math.random() * Math.max( W - 80, 1 );
			r.y0 = anywhere ? Math.random() * H * 0.5 : -20;
			r.y = r.y0 + ( anywhere ? Math.random() * 200 : 0 );
			r.v = 1.5 + Math.random() * 3;
			r.pause = Math.round( Math.random() * 30 );
		};

		function paintFog() {
			W = win.clientWidth;
			H = win.clientHeight;
			dpr = Math.min( window.devicePixelRatio || 1, 1.5 );
			canvas.width = fog.width = W * dpr;
			canvas.height = fog.height = H * dpr;

			// Cheap, portable blur: draw tiny, then scale up smoothly.
			const small = document.createElement( 'canvas' );
			small.width = Math.max( 8, Math.round( W / 28 ) );
			small.height = Math.max( 8, Math.round( H / 28 ) );
			const s = Math.max( small.width / img.naturalWidth, small.height / img.naturalHeight );
			const dw = img.naturalWidth * s, dh = img.naturalHeight * s;
			small.getContext( '2d' ).drawImage( img, ( small.width - dw ) * fx, ( small.height - dh ) * fy, dw, dh );

			const f = fog.getContext( '2d' );
			f.imageSmoothingQuality = 'high';
			f.drawImage( small, 0, 0, fog.width, fog.height );
			f.fillStyle = 'rgba(186,196,212,0.28)';
			f.fillRect( 0, 0, fog.width, fog.height );

			ctx.setTransform( 1, 0, 0, 1, 0, 0 );
			ctx.globalCompositeOperation = 'source-over';
			ctx.globalAlpha = 1;
			ctx.drawImage( fog, 0, 0 );
			ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );

			// A finger already went across the eyes once, so the idea reads at first sight.
			for ( let i = 0; i <= 30; i++ ) {
				const t = i / 30;
				wipe( W * ( 0.3 + t * 0.4 ), H * ( 0.37 + Math.sin( t * Math.PI * 1.6 ) * 0.05 ), 64 );
			}
			layoutDrops();
			runners.forEach( ( r ) => spawn( r, true ) );
		}

		function wipe( x, y, r ) {
			ctx.globalCompositeOperation = 'destination-out';
			ctx.globalAlpha = 1;
			const g = ctx.createRadialGradient( x, y, r * 0.35, x, y, r );
			g.addColorStop( 0, 'rgba(0,0,0,1)' );
			g.addColorStop( 1, 'rgba(0,0,0,0)' );
			ctx.fillStyle = g;
			ctx.beginPath();
			ctx.arc( x, y, r, 0, Math.PI * 2 );
			ctx.fill();
		}

		function frame() {
			if ( ! running ) return;
			// The glass slowly fogs up again.
			ctx.globalCompositeOperation = 'source-over';
			ctx.globalAlpha = 0.012;
			ctx.drawImage( fog, 0, 0, W, H );

			runners.forEach( ( r ) => {
				if ( r.y > H + 30 ) spawn( r, false );
				else if ( r.pause > 0 ) r.pause--;
				else {
					r.y += r.v * ( 0.6 + Math.random() * 0.8 );
					r.x += ( Math.random() - 0.5 ) * 0.6;
					if ( Math.random() < 0.025 ) r.pause = 8 + Math.round( Math.random() * 30 );
				}
				const x = Math.round( r.x ), y = Math.round( r.y );
				place( r.head, x, y, r.w, r.w * 1.25, W, H, pos );
				const tx = Math.round( r.x + r.w / 2 - 1.5 ), ty = Math.round( r.y0 );
				place( r.trail, tx, ty, 3, Math.max( 0, y - ty ), W, H, pos );
			} );
			requestAnimationFrame( frame );
		}

		const point = ( e ) => {
			const rect = win.getBoundingClientRect();
			const p = { x: e.clientX - rect.left, y: e.clientY - rect.top };
			if ( last ) {
				const steps = Math.ceil( Math.hypot( p.x - last.x, p.y - last.y ) / 12 );
				for ( let i = 1; i <= steps; i++ ) wipe( last.x + ( p.x - last.x ) * i / steps, last.y + ( p.y - last.y ) * i / steps, 80 );
			} else {
				wipe( p.x, p.y, 80 );
			}
			last = p;
		};
		win.addEventListener( 'pointermove', point );
		win.addEventListener( 'pointerleave', () => { last = null; } );

		new IntersectionObserver( ( [ entry ] ) => {
			const was = running;
			running = entry.isIntersecting;
			if ( running && ! was ) requestAnimationFrame( frame );
		} ).observe( win );

		let resizeTimer;
		new ResizeObserver( () => {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( () => img.complete && paintFog(), 150 );
		} ).observe( win );

		img.src = src;
		img.decode().then( paintFog ).catch( () => {} );
	}

	/* ---------- Words on fogged glass ---------- */
	function initQuote( box ) {
		const src = box.dataset.src;
		const layer = box.querySelector( '.rs-water' );
		if ( ! src || ! layer ) return;
		const layout = staticDrops( layer, box, src, posOf( box, '45% 40%' ), 34, 71 );
		new ResizeObserver( layout ).observe( box );
	}

	const start = () => {
		document.querySelectorAll( '.rs-window' ).forEach( initWindow );
		document.querySelectorAll( '.rs-fogquote' ).forEach( initQuote );
	};
	if ( document.readyState === 'loading' ) document.addEventListener( 'DOMContentLoaded', start );
	else start();
} )();
