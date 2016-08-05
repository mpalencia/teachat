$(document).ready(function(){
         $('#image_inputs').change(function(){
          var myfile = $(this).val();
             var ext = myfile.split('.').pop();
             if(ext=="jpeg" || ext=="jpg" || ext=="png" || ext=="gif"){
              	$("#form_add_school").on('submit',(function(e) {
                         e.preventDefault();
                         $.ajax({
                           url: "/admin/schools/add", // Url to which the request is send
                           type: "POST",             // Type of request to be send, called as method
                           data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                           contentType: false,       // The content type used when sending data to the server.
                           cache: false,             // To unable request pages to be cached
                           processData:false,        // To send DOMDocument or non processed data file it is set to false
                           success: function(data)   // A function to be called if request succeeds
                           {
                             var msg = JSON.parse(data);
                             if(msg.result == 'success'){
                               Materialize.toast(msg.message, 7000, 'green');
                               window.location.href = "/admin/schools";
                             }else{
                              Materialize.toast(msg.message, 7000, 'red');
                             }
                           }
                         });
                  }));
             } else{
              Materialize.toast("Required file types: jpeg, jpg, png, gif", 7000, 'red');
              	$("#form_add_school").on('submit',(function(e) {

                     window.location.reload();

                  }));
             }
         });
                 
});

$(document).ready(function(){
         $('#image_inputsedit').change(function(){
          var myfile = $(this).val();
             var ext = myfile.split('.').pop();
             if(ext=="jpeg" || ext=="jpg" || ext=="png" || ext=="gif"){
              	$("#form_edit_school").on('submit',(function(e) {
                         e.preventDefault();
                         $.ajax({
                           url: "/admin/schools/update/"+$(this).find(":submit").attr('data-id'), // Url to which the request is send
                           type: "POST",             // Type of request to be send, called as method
                           data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                           contentType: false,       // The content type used when sending data to the server.
                           cache: false,             // To unable request pages to be cached
                           processData:false,        // To send DOMDocument or non processed data file it is set to false
                           success: function(data)   // A function to be called if request succeeds
                           {
                             var msg = JSON.parse(data);
                             if(msg.result == 'success'){
                               Materialize.toast(msg.message, 7000, 'green');
                               window.location.href = "/admin/schools";
                             }else{
                              Materialize.toast(msg.message, 7000, 'red');
                             }
                           }
                         });
                  }));
             } else{
              Materialize.toast("Required file types: jpeg, jpg, png, gif", 7000, 'red');
              	$("#form_edit_school").on('submit',(function(e) {

                     window.location.reload();

                  }));
             }
         });
                 
});

