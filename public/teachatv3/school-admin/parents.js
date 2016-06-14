
var nColNumber = -1;
/*var parents = $('#parents').DataTable({
    'ajax': 'parents/getAll',
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Parents', 'name': 'parents', 'data': 'parents' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});*/

$('.btn-approve-yes-parents').on('click', function() {
    $.ajax({
        url: 'parents/'+$(this).attr('data-parents-id'),
        type: 'PUT',
        data: {approved: 1},
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete');
            reloadTable(parents);
            $('#approve-parents').closeModal();
        }
    });
});

$('.btn-deny-yes-parents').on('click', function() {
    $.ajax({
        url: 'parents/'+$(this).attr('data-parents-id'),
        type: 'PUT',
        data: {approved: 2},
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete');
            reloadTable(parents);
            $('#deny-parents').closeModal();
        }
    });
});

function approveParent(parents) {
    $('#approve-parents').openModal();
    $('#parent_to_approve').html($(parents).attr('data-parents-name'));
    $('.btn-approve-yes-parents').attr('data-parents-id', $(parents).attr('data-parents-id'));
}

function denyParent(parents) {
    $('#deny-parents').openModal();
    $('#parent_to_deny').html($(parents).attr('data-parents-name'));
    $('.btn-deny-yes-parents').attr('data-parents-id', $(parents).attr('data-parents-id'));
}

function viewParent(id) {
    $('#view-parents').openModal();
    
    $.get('parents/get/'+id, function(result){
        
        $('#parent_name').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
        $('#parent_email').html(result.data.email);
        $('#parent_gender').html(result.data.gender);
        $('#parent_address_one').html(result.data.email);
        $('#parent_address_two').html(result.data.gender);
        $('#parent_state').html(result.data.state.state_name);
        $('#parent_city').html(result.data.city);
        $('#parent_zip_code').html(result.data.zip_code);
        $('#parent_contact_mobile').html(result.data.contact_cell);
        $('#parent_contact_home').html(result.data.contact_home);
        $('#parent_contact_work').html(result.data.contact_work);
    });


    //$('.btn-deny-yes-parents').attr('data-parents-id', $(parents).attr('data-parents-id'));
}
