
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

function viewParent(id) {
    $('#view-parents').openModal();
    
    $.get('parents/get/'+id, function(result){
        
        $('#parent_name').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
        $('#parent_email').html(result.data.email);
        $('#parent_gender').html(result.data.gender);
        $('#parent_address_one').html(result.data.address_one);
        $('#parent_address_two').html(result.data.address_two);
        $('#parent_state').html(result.data.state.state_name);
        $('#parent_city').html(result.data.city);
        $('#parent_zip_code').html(result.data.zip_code);
        $('#parent_contact_mobile').html(result.data.contact_cell);
        $('#parent_contact_home').html(result.data.contact_home);
        $('#parent_contact_work').html(result.data.contact_work);
    });


    //$('.btn-deny-yes-parents').attr('data-parents-id', $(parents).attr('data-parents-id'));
}

function deleteParent(id) {
    $.get('parents/get/'+id, function(result){
        $('#parent_to_delete').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
        $('.btn-delete-yes-parent').attr('data-parent-id', id);
    });
    $('#delete-parent').openModal();
}

$('.btn-delete-yes-parent').on('click', function() {
    $.ajax({
        url: '/school-admin/manage-parents/'+$(this).attr('data-parent-id'),
        type: 'DELETE',
        success: function(data) {
           $('#delete-parent').closeModal();
           Materialize.toast("Succesfully deleted.", 7000);
           window.location.reload();
        }
    });
});

$('#form_add_parent').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', '/school-admin/manage-parents', getFormInputs(this.id), false, 'card', 'form_add_parent', '', 'manage-parents');
});

$('#form_update_parent').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', '/school-admin/manage-parents/'+$(this).find(":submit").attr('data-parent-id'), getFormInputs(this.id), false, 'card', 'form_update_parent', '', 'manage-parents');
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
            url: '/school-admin/manage-parents/updateField/'+id,
            data: param,
            type: 'POST',
            success: function(data) {

               Materialize.toast("Succesfully updated.", 2000,'green',function(){})
            }
        });
    });


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
            url: '/school-admin/manage-parents/updateField/'+id,
            data: param,
            type: 'POST',
            success: function(data) {

               Materialize.toast("Succesfully updated.", 2000,'green',function(){})
            }
        });
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