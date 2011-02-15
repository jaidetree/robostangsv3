(function ($) {
  $.fn.rotator = function (options) {
     var settings = {
		'animation' 	: 	'slide-right',
	};

	return this.each(function () {
    	if( options )
		{
			$.extend( settings, options );
		}
    });
  };
})(jQuery);

