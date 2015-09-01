function wpse167402_tiny_mce_init(ed) {
    (function($) {

        var shortcutKeys = passedData.keys;

        var shortcutElems = [
            $( '#save-post' ),
            $( '#publish' ),
            $( '#post-preview' )[0],
            $( '#content-tmce' ),
            $( '#content-html' ),
            $( '#shortcut-create-new' )[0],
        ];

        ed.on('init', function () {

            var selector = this;

            $( document ).ready( function() {
                for (var i = 0, len = shortcutKeys.length; i < len; i++) {
                    // Anonymous function for correct variable scope, thanks:
                    // http://stackoverflow.com/questions/10131647/binding-listeners-inside-of-a-for-loop-variable-scope-miscomprehension
                    (function(index){  
                        var elem = shortcutElems[index];
                        var key = shortcutKeys[index];
                        selector.addShortcut(key, '', function () {});
                        selector.addShortcut( key, '', function () {
                            elem.click();

                            if ( elem === '#content-html' ) {
                                alert('Y');
                            }
                        });
                    })(i);
                };
            });
        });

    })(jQuery);
}