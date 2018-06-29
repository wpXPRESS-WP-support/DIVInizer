( function( $ ) {
   $( document ).ready( function() {
      
   		// jQuery form :: submit settings with ajax
   		$( '#divinize_form' ).submit(function() {
   			$( '#divinize_save' ).html( "<div id='divinize_save_message'>saving...</div>" );
	   		$( this ).ajaxSubmit({
		   		success: function(){
		   			$( '#divinize_save_message' ).text( "Saved!" );
		   		}, 
		   		timeout: 5000
	   		}); 
	   		setTimeout( function(){ $( '#divinize_save_message' ).fadeOut( '3000' ); }, 5000 );
	   		return false; 
   		});

   });
})( jQuery );

