/**
 * A jQuery Rotator Plugin
 *
 * Made to play nicely with my WordPress theme framework.
 * Hopefully.
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @version 1.0
 */
(function( $ ){

  var methods = {
    init : function( options ) { 
		var settings = {
			'direction' : 'up'
		};

		if( options ) {
			$.extend( settings, options );
		}


		return this.each(function() {

		} );

	},
    show : function( ) { // IS   },
    hide : function( ) { // GOOD },
    update : function( content ) { // !!! }
  };

  $.fn.jTater = function( method ) {
    
    // Method calling logic
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
    }    
  
  };

})( jQuery );

