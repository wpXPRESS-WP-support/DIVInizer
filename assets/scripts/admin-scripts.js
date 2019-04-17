( function( $ ) {
   $( document ).ready( function() {
      
   		// jQuery form :: submit settings with ajax
   		$( '#divinizer_form' ).submit(function() {
   			$( '#divinizer_save' ).html( "<div id='divinizer_save_message'>saving...</div>" );
	   		$( this ).ajaxSubmit({
		   		success: function(){
		   			$( '#divinizer_save_message' ).text( "Saved!" );
		   		}, 
		   		timeout: 5000
	   		}); 
	   		setTimeout( function(){ $( '#divinizer_save_message' ).fadeOut( '3000' ); }, 5000 );
	   		return false; 
   		});

   });
})( jQuery );

