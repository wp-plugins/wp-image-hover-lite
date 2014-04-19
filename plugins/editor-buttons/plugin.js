(function() {
    tinymce.create('tinymce.plugins.WpImageHover', {
        init : function(ed, url) {
            // var disabled = true;
            // Register example button


            ed.addButton('wp_image_hover', {
                title : 'Image Hover Lite',
                cmd : 'WP_IMAGE_HOVER',
                image : url + '/images/hover.png'
            });

            ed.addCommand('WP_IMAGE_HOVER', function() {
                data = ed.selection.getNode();
                // console.log(data);
                ed.windowManager.open({
                    file : url + '/hover.php',
                    title : 'Image Hover Lite',
                    width : 650,
                    height : 500,
                    inline : 1,
                    data : data
                }, {
                    plugin_url : url // Plugin absolute URL
                    // data : data
                });
            });

            ed.onNodeChange.add(function(ed, cm, node) {
                cm.setDisabled('wp_image_hover', !(node.tagName == 'IMG'))
            });
        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'wpimagehover', tinymce.plugins.WpImageHover );
})();