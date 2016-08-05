
/*var nColNumber = -1;
var teachers_subjects = $('#teachers_subjects').DataTable({
    'order': [[ 1, "asc" ]],
});*/

var ch_id = $('#child_id').val();

$(document).ready(function() {
     $("#form_child_add").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
          url: "/parent/child/store", // Url to which the request is send
          type: "POST",             // Type of request to be send, called as method
          data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,        // To send DOMDocument or non processed data file it is set to false
          success: function(data)   // A function to be called if request succeeds
          {
            var msg = JSON.parse(data);
            if(msg.result == 'success'){
              window.location = "/parent/child";
              Materialize.toast(msg.message, 7000, 'green');
            }else{
              Materialize.toast(msg.message, 7000, 'red');
            }
          }
        });
    }));
});

$("#form_child_edit").on('submit',(function(e) {
  e.preventDefault();
  $.ajax({
    url: "/parent/child/"+$('#child_id').val()+"/update", // Url to which the request is send
    type: "POST",             // Type of request to be send, called as method
    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,        // To send DOMDocument or non processed data file it is set to false
    success: function(data)   // A function to be called if request succeeds
    {
      var msg = JSON.parse(data);
      if(msg.result == 'success'){
          window.location = "/parent/child";
          Materialize.toast(msg.message, 7000, 'green');
      }else{
          Materialize.toast(msg.message, 7000, 'red');
      }
    }
  });
}));

$('#form_add_teacher').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/parent/children/teachers/store', getFormInputs(this.id), false, 'card', 'form_add_teacher');
    window.location.href= "/parent/children/teachers/"+ch_id;
});

$('.btn_yes_delete').on('click', function() {
    $.ajax({
        url: '/parent/child/delete/'+$(this).attr('data-child-id'),
        type: 'DELETE',
        success: function(data) {
           // showAlertNotification(data.result, data.message, 'delete');
           $('.delete_child_modal').closeModal();
           window.location.reload();
           Materialize.toast(data.message, 7000)
        }
    });
});

function deleteChild(child) {
    var name = $(child).data('name');
    document.getElementById("child_n").innerHTML = name;
    $('#delete_child_modal').openModal();
    $('.btn_yes_delete').attr('data-child-id', $(child).attr('data-child-id'));
}