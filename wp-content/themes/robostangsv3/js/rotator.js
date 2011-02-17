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
	/**
	 * Current Slide Index
	 */
	current_slide : 0,

	/**
	 * The collection of slides
	 */
    slides: new Array(),

	/**
	 * Initiator Function
	 *
	 * Controls our main logic, gathers the slides, finds the next one.
	 * Sets the event handlers. Whatever needs to be done.
	 * @param {object} options The options to over-ride the default.
	 * @return {object} The jQuery object for chainability
	 * @member jTater
	*/
	init : function( options ) { 
		var settings = {
			'direction' : 'up'
		};

		if( options ) {
			$.extend( settings, options );
		}


		return this.each(function() {
			/**
			 * Not sure what this does.
			 */
			var $this = $(this);
            
			/**
			 * Start Here
			 */


			methods.get_slides( $this );

			console.log( methods.slides );

		} );

	},

	get_slides : function(slides_ul) {
		$('li', slides_ul).each( function() {
			methods.slides[ methods.slides.length ] = $(this);
		} );
	}
	
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

