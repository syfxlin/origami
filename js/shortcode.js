(function() {
    tinymce.create('tinymce.plugins.origami_image_add', {
        init : function(ed, url) {
            ed.addButton('origami_image_add', {
                title : '添加图片',
                text : '添加图片',
                onclick : function() {
                     ed.selection.setContent('[image alt="" is-thum="false" is-show="true"]' + ed.selection.getContent() + '[/image]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('origami_image_add', tinymce.plugins.origami_image_add);

    tinymce.create('tinymce.plugins.prism', {
        init : function(ed, url) {
            ed.addButton('prism', {
                title : 'Prism.js - 代码高亮',
                text : 'Prism.js - 代码高亮',
                onclick : function() {
                     ed.selection.setContent('<pre class="fix-back-pre">[prism lang=""]' + ed.selection.getContent() + '[/prism]</pre>');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('prism', tinymce.plugins.prism);

    tinymce.create('tinymce.plugins.notebox_yellow', {
        init : function(ed, url) {
            ed.addButton('notebox_yellow', {
                title : 'NoteBox - yellow',
                text : 'NoteBox - yellow',
                onclick : function() {
                        ed.selection.setContent('[notebox color="yellow"]' + ed.selection.getContent() + '[/notebox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('notebox_yellow', tinymce.plugins.notebox_yellow);

    tinymce.create('tinymce.plugins.notebox_blue', {
        init : function(ed, url) {
            ed.addButton('notebox_blue', {
                title : 'NoteBox - blue',
                text : 'NoteBox - blue',
                onclick : function() {
                        ed.selection.setContent('[notebox color="blue"]' + ed.selection.getContent() + '[/notebox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('notebox_blue', tinymce.plugins.notebox_blue);

    tinymce.create('tinymce.plugins.notebox_green', {
        init : function(ed, url) {
            ed.addButton('notebox_green', {
                title : 'NoteBox - green',
                text : 'NoteBox - green',
                onclick : function() {
                        ed.selection.setContent('[notebox color="green"]' + ed.selection.getContent() + '[/notebox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('notebox_green', tinymce.plugins.notebox_green);

    tinymce.create('tinymce.plugins.notebox_red', {
        init : function(ed, url) {
            ed.addButton('notebox_red', {
                title : 'NoteBox - red',
                text : 'NoteBox - red',
                onclick : function() {
                        ed.selection.setContent('[notebox color="red"]' + ed.selection.getContent() + '[/notebox]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('notebox_red', tinymce.plugins.notebox_red);
})();