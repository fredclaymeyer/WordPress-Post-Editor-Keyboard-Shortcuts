(function($) {
	$( document ).ready( function() {

		// Give new page an ID to go for
		$( '.add-new-h2' ).attr('id', 'shortcut-create-new');

		var shortcutKeys = passedData.keys;

		var shortcutElems = [
			$( '#save-post' ),
			$( '#publish' ),
			$( '#post-preview' )[0],
			$( '#content-tmce' ),
			$( '#content-html' ),
			$( '.page-title-action' )[0],
		];


		function bindKeyboardShortcuts( selector ) {
			for (var i = 0, len = shortcutKeys.length; i < len; i++) {
				
				// Anonymous function for correct variable scope, thanks:
				// http://stackoverflow.com/questions/10131647/binding-listeners-inside-of-a-for-loop-variable-scope-miscomprehension
			    (function(index){  
			    	var elem = shortcutElems[index];
					var key = shortcutKeys[index];
					$( selector ).bind( 'keydown', key, function(event) {
						event.preventDefault();
						elem.click();
						event.stopPropagation();
						var elemId = $( elem ).attr( 'id' );
                        if ( elemId === 'content-html' ) {
                            setTimeout(function(){
								$( '#' + elemId + ' .wp-editor-area' ).focus();
                            	console.log('a');
							}, 1000);
                        }
					});
			    })(i);
			};
		}

		var doc = $( document );
		bindKeyboardShortcuts( doc );

		var input = $( 'input' );
		bindKeyboardShortcuts( input );

		var textarea = $( 'textarea' );
		bindKeyboardShortcuts( textarea );

		var div = $( 'div' );
		bindKeyboardShortcuts( div );	
	});
})(jQuery);