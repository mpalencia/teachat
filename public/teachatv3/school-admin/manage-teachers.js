function viewTeacher(id) {
    $('#view-teachers').openModal();
    
    $.get('teachers/get/'+id, function(result){
        
        $('#teacher_name').html(result.data.first_name + ' ' + result.data.last_name);
        $('#teacher_email').html(result.data.email);
        $('#teacher_gender').html(result.data.gender);
        $('#teacher_address_one').html(result.data.address_one);
        $('#teacher_address_two').html(result.data.address_two);
        $('#teacher_state').html(result.data.state.state_name);
        $('#teacher_city').html(result.data.city);
        $('#teacher_zip_code').html(result.data.zip_code);
        $('#teacher_contact_mobile').html(result.data.contact_cell);
        $('#teacher_contact_home').html(result.data.contact_home);
        $('#teacher_contact_work').html(result.data.contact_work);
    });


    //$('.btn-deny-yes-parents').attr('data-parents-id', $(parents).attr('data-parents-id'));
}


$('#form_add_teachers').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/school-admin/manage-teachers', getFormInputs(this.id), false, 'card', 'form_add_teachers', '', 'manage-teachers');    
});

$('#form_update_teachers').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/school-admin/manage-teachers/'+$('#teacher_id').val()+'/update', getFormInputs(this.id), false, 'card', 'form_update_teachers', '', 'manage-teachers');
});

$('.btn_yes_delete').on('click', function() {
    $.ajax({
        url: '/school-admin/manage-teachers/delete/'+$(this).attr('data-teacher-id'),
        type: 'DELETE',
        success: function(data) {
           // showAlertNotification(data.result, data.message, 'delete');
           $('.delete_teacher_modal').closeModal();
           window.location.reload();
           Materialize.toast(data.message, 7000)
        }
    });
});

function deleteTeacher(teacher) {
    var name = $(teacher).data('name');
    document.getElementById("teacher_n").innerHTML = name;
    $('#delete_teacher_modal').openModal();
    $('.btn_yes_delete').attr('data-teacher-id', $(teacher).attr('data-teacher-id'));
}

$('.switch_in_active').change(function(){
    var changeTo = $(this).is(':checked');

    if(changeTo == true){
        changeTo = 1;
    }

    else {
        changeTo = 0;
    }
    var id = $(this).attr('id');
    var param = {
        active: changeTo,
    };

    $.ajax({
        url: '/school-admin/manage-teachers/update/'+id,
        data: param,
        type: 'PUT',
        success: function(data) {

           Materialize.toast("Succesfully updated.", 2000,'green',function(){})
        }
    });
});

$('.switch_in_suspend').change(function(){
    var changeTo = $(this).is(':checked');

    if(changeTo == true){
        changeTo = 1;
    }

    else {
        changeTo = 0;
    }
    var id = $(this).attr('id');
    var param = {
        suspend: changeTo,
    };

    $.ajax({
        url: '/school-admin/manage-teachers/update/'+id,
        data: param,
        type: 'PUT',
        success: function(data) {

           Materialize.toast("Succesfully updated.", 2000,'green',function(){})
        }
    });
});

var teachers = $('#teachers_table').DataTable({
    'processing': true,
    'order': [[ 1, "asc" ]],
});

$('#teachers_filter').material_select();
$('#teachers_filter').on('change',function(){

    if(this.value == "") {
        teachers.columns(2).search("").draw();
    }
    else {
        teachers.columns(2).search(this.value).draw();
    }
});

$('#filled-in-box').change(function(){
        var changeTo = $(this).is(':checked');

        if(changeTo == true){
            changeTo = 1;
            $('.divactive').addClass("hide");
        }

        else {
            changeTo = 0;
            $('.divactive').removeClass("hide");
        }
});

$('#filled-in-box2').change(function(){
    var changeTo = $(this).is(':checked');

    if(changeTo == true){
        changeTo = 1;
        $('.suspendactive').addClass("hide");
    }

    else {
        changeTo = 0;
        $('.suspendactive').removeClass("hide");
    }
});