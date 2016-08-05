
var nColNumber = -1;
var announcements = $('#announcements').DataTable({
    'ajax': 'announcements/getAll',
    'processing': true,
    'order': [[ 2, "desc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Title', 'name': 'title', 'data': 'title' },
        { 'targets': [ ++nColNumber ], 'title':'Announced To', 'name': 'announce_to', 'data': 'announce_to' },
        { 'targets': [ ++nColNumber ], 'title':'Date Created', 'name': 'created_at', 'data': 'created_at' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

var selectAnnounce = $('#eannounce_to').val();

$('#form_add_announcements').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'announcements', getFormInputs(this.id), false, 'card', 'form_add_announcements', announcements);
    $('#form_add_announcements')[0].reset();
});

$('.form_edit_announcements').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'announcements/'+$(this).find(":submit").attr('data-announcements-id'), getFormInputs(this.id), false, 'edit-announcements', 'form_edit_announcements', announcements);
    $('#edit-announcements').closeModal();
});

$('.btn-delete-yes-announcements').on('click', function() {
    $.ajax({
        url: 'announcements/'+$(this).attr('data-announcements-id'),
        type: 'DELETE',
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete');
            reloadTable(announcements);
        }
    });
});

function viewAnnouncements(announcements) {
    $('#view-announcements').openModal();
    $('#view_announce_to').html($(announcements).attr('data-announce-to'));
    $('#view_title').html($(announcements).attr('data-title'));
    $('#view_announcement').html($(announcements).attr('data-announcement'));
    $('#view_created_at').html($(announcements).attr('data-created-at'));
    $('#view_from').html($(announcements).attr('data-from'));
    $('#view_school').html($(announcements).attr('data-school'));
    $('#view_publish').html($(announcements).attr('data-publish'));
    $('#view_exp').html($(announcements).attr('data-exp'));
}

function editAnnouncements(announcements) {
    $('.ediv_notif').html('');
    $('#egrade').focus();
    $('#eannounce_to').val($(announcements).attr('data-announce-to'));
    $('#eannounce_to').material_select();
    $('#etitle').val($(announcements).attr('data-title'));
    $('#epublish_on').val($(announcements).attr('data-publish'));
    $('#eexpiration_date').val($(announcements).attr('data-exp'));
    $('#eannouncement').val($(announcements).attr('data-announcement'));
    $('.btn-update-announcements').attr('data-announcements-id', $(announcements).attr('data-announcements-id'));
    $('#edit-announcements').openModal();
}

function deleteAnnouncements(announcements) {
    $('#delete-announcements').openModal();
    $('.btn-delete-yes-announcements').attr('data-announcements-id', $(announcements).attr('data-announcements-id'));
}

/* Add Announcement's Date */
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth();
    var yyyy = today.getFullYear();
    var exp_dd = today.getDate()+7;

    var publish = $('#publish_on').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

    var picker_pub = publish.pickadate('picker');
    picker_pub.set('select', [yyyy, mm, dd])

    var expired = $('#expiration_date').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

    var picker_exp = expired.pickadate('picker');
    picker_exp.set('select', [yyyy, mm, exp_dd])

    $("#publish_on").on("change",function(){
        var selected = $(this).val();
        var newdate = new Date(selected);
        var exp_dd = newdate.getDate()+7;
        var mm = newdate.getMonth();
        var yyyy = newdate.getFullYear();

        var expired = $('#expiration_date').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

        var picker_exp = expired.pickadate('picker');
        picker_exp.set('select', [yyyy, mm, exp_dd])
    });


/* Edit Announcement's Date */
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth();
    var yyyy = today.getFullYear();
    var exp_dd = today.getDate()+7;

    var publish = $('#epublish_on').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

    var picker_pub = publish.pickadate('picker');
    picker_pub.set('select', [yyyy, mm, dd])

    var expired = $('#eexpiration_date').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

    var picker_exp = expired.pickadate('picker');
    picker_exp.set('select', [yyyy, mm, exp_dd])

    $("#epublish_on").on("change",function(){
        var selected = $(this).val();
        var newdate = new Date(selected);
        var exp_dd = newdate.getDate()+7;
        var mm = newdate.getMonth();
        var yyyy = newdate.getFullYear();

        var expired = $('#eexpiration_date').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year 
        });

        var picker_exp = expired.pickadate('picker');
        picker_exp.set('select', [yyyy, mm, exp_dd])
    });

