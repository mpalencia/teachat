
var nColNumber = -1;
var teachers = $('#teachers').DataTable({
    'ajax': 'teachers/getAll',
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Teachers', 'name': 'teachers', 'data': 'teachers' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

$('.btn-approve-yes-teachers').on('click', function() {
    $.ajax({
        url: 'teachers/'+$(this).attr('data-teachers-id'),
        type: 'PUT',
        data: {approved: 1},
        success: function(data) {
            //showAlertNotification(data.result, data.message, 'delete');
            Materialize.toast(data.message, 8000);
            reloadTable(teachers);
            $('#approve-teachers').closeModal();
        }
    });
});

$('.btn-deny-yes-teachers').on('click', function() {
    $.ajax({
        url: 'teachers/'+$(this).attr('data-teachers-id'),
        type: 'PUT',
        data: {approved: 2},
        success: function(data) {
            //showAlertNotification(data.result, data.message, 'delete');
            Materialize.toast(data.message, 8000);
            reloadTable(teachers);
            $('#deny-teachers').closeModal();
        }
    });
});


function approveTeacher(teachers) {
    $('#approve-teachers').openModal();
    $('#teacher_to_approve').html($(teachers).attr('data-teachers-name'));
    $('.btn-approve-yes-teachers').attr('data-teachers-id', $(teachers).attr('data-teachers-id'));
}

function denyTeacher(teachers) {
    $('#deny-teachers').openModal();
    $('#teacher_to_deny').html($(teachers).attr('data-teachers-name'));
    $('.btn-deny-yes-teachers').attr('data-teachers-id', $(teachers).attr('data-teachers-id'));
}

function viewTeacher(id) {
    $('#view-teachers').openModal();
    
    $.get('teachers/get/'+id, function(result){
        
        $('#teacher_name').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
        $('#teacher_email').html(result.data.email);
        $('#teacher_gender').html(result.data.gender);
        $('#teacher_address_one').html(result.data.email);
        $('#teacher_address_two').html(result.data.gender);
        $('#teacher_state').html(result.data.state.state_name);
        $('#teacher_city').html(result.data.city);
        $('#teacher_zip_code').html(result.data.zip_code);
        $('#teacher_contact_mobile').html(result.data.contact_cell);
        $('#teacher_contact_home').html(result.data.contact_home);
        $('#teacher_contact_work').html(result.data.contact_work);
    });


    $('.btn-deny-yes-teachers').attr('data-teachers-id', $(teachers).attr('data-teachers-id'));
}