/*
        Event listener for file input.
 */

$(document).ready(function () {
   $('label[for="avatar"]').click(function () {

       $('#avatar').change(function () {
           if(document.getElementById('avatar').files.length == 0) {
               $(this).prev()
                   .html('Choose file&nbsp;&nbsp;<i class="fa fa-upload" aria-hidden="true"></i>');
           } else {
               $(this).prev()
                   .html('File chosen&nbsp;&nbsp;<i class="fa fa-upload" aria-hidden="true"></i>');
           }
       });

   });
});