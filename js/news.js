jQuery( document ).ready( function( $ ) {

	$( '#wp-calendar' ).on( 'click', 'a', function( e ) {

		var _href = $( this ).attr( 'href' );

		// console.log( _href );

		var data = {

			'action': 'mx_get_particular_news',
			'nonce': mx_localize.mx_nonce,
			'_href': _href

		};

		jQuery.post(
			mx_localize.ajaxurl,
			data,
			function( response ) {

				var _json = JSON.parse( response );

				if( !_json ) return;

				$( '.mx-news-content' ).empty();

				$.each( _json, function( i, v ) {

					var el = $( '#mx_one_news_template' ).clone().appendTo( '.mx-news-content' );

					// set data
					$( '.mx-news-content #mx_one_news_template' ).find( 'h3' ).text( v.post_title );

					$( '.mx-news-content #mx_one_news_template' ).find( 'a' ).attr( 'href', v.permalink );

					$( '.mx-news-content #mx_one_news_template' ).find( 'img' ).attr( 'src', v.post_thumbnail_url );

					$( '.mx-news-content #mx_one_news_template' ).find( '.mx-excerpt-wrap p' ).text( v.post_excerpt );

					$( '.mx-news-content #mx_one_news_template' ).show();

					$( '.mx-news-content #mx_one_news_template' ).attr( 'id', '' );

					// console.log( i, v );

				} );				

			}
		);



		e.preventDefault();

	} );	

} );