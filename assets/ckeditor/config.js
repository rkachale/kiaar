/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.dtd.a.div = 1;
CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    //config.uiColor = '#ffffff';
    if($('html')[0].lang.length){
        config.language = $('html')[0].lang;
    }
    
    config.filebrowserImageBrowseUrl = 'https://svv.somaiya.edu/ckfinder/ckfinder.html?type=Images';
    config.filebrowserImageUploadUrl = 'https://svv.somaiya.edu/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';

    // config.filebrowserBrowseUrl = 'http://stage.somaiya.edu/browser/browse.php';
    // config.filebrowserUploadUrl = 'http://stage.somaiya.edu/uploader/upload.php';

    config.filebrowserUploadUrl = 'https://svv.somaiya.edu/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

    config.filebrowserBrowseUrl= 'https://svv.somaiya.edu/ckfinder/ckfinder.html?resourceType=Files';
    
    config.allowedContent = true;
    config.autoParagraph = false;
    config.extraAllowedContent = 'span;ul;li;table;td;style;*[id];*(*);*{*}';
    config.protectedSource.push(/<i[^>]*><\/i>/g);
};
