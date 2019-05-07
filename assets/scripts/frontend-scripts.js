( function( $ ) {
   $( document ).ready( function() {

   		// move tags after the post meta
         if ( $( '.divinizer-above-tags' ) ) {
            var post_meta = $( '.single-post .et_post_meta_wrapper .post-meta' );
            $( '.divinizer-above-tags' ).insertAfter(post_meta);
            post_meta.css({
               'margin-right': '5px',
               'display': 'inline',
               'margin-bottom': '0',
               'padding-bottom': '0',
               'float': 'left'
            });
         }

   });
})( jQuery );