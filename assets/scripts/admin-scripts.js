( function( $ ) {
   $( document ).ready( function() {
      
   		// jQuery form :: submit settings with ajax
   		$( '#expand_divi_form' ).submit(function() {
   			$( '#expand_divi_save' ).html( "<div id='expand_divi_save_message'>saving...</div>" );
	   		$( this ).ajaxSubmit({
		   		success: function(){
		   			$( '#expand_divi_save_message' ).text( "Saved!" );
		   		}, 
		   		timeout: 5000
	   		}); 
	   		setTimeout( function(){ $( '#expand_divi_save_message' ).fadeOut( '3000' ); }, 5000 );
	   		return false; 
   		});

   });
})( jQuery );

