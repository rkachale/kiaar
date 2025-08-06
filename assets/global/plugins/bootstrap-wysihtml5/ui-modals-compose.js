// var UIModals = function () {
    
//     var initModals = function () {
       
//         $.fn.modalmanager.defaults.resize = true;
//     $.fn.modalmanager.defaults.spinner = '';
//     var $modal = $('#ajax-modal');
 
//     $('#modal_ajax_demo_btn').on('click', function(){
//     // create the backdrop and wait for next modal to be triggered
//          $('body').modalmanager('loading');      
//          setTimeout(function(){
//               $modal.load('inbox_compose.html', '', function () {
//                $modal.modal();
//                        // call Wysihtml5 here
//                initWysihtml5();      
//           });
//              }, 1000);
//     }); 
//     }
//     var initWysihtml5 = function () {
//         $('.inbox-wysihtml5').wysihtml5({
//             "stylesheets": ["wysiwyg-color.css"]
//         });
//     }
//     return {
//         //main function to initiate the module
//         init: function () {
//             initModals();      
//         }
//     };
// }();
// $("#data[description]").on('click', function(){
  // alert('hi');
   $("#summernote").summernote();
// });

$('#summerNote').on('summernote.paste', function (customEvent, nativeEvent) {
setTimeout(function () {
$('.note-editable').selectText();
$("#summerNote").summernote("removeFormat");
}, 100);
});