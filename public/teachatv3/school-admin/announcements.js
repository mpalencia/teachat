
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

$('#form_add_announcements').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'announcements', getFormInputs(this.id), false, 'card', 'form_add_announcements', announcements);
});

$('.form_edit_announcements').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'announcements/'+$(this).find(":submit").attr('data-announcements-id'), getFormInputs(this.id), false, 'edit-announcements', 'form_edit_announcements', announcements);
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
}

function editAnnouncements(announcements) {
    $('.ediv_notif').html('');
    $('#egrade').focus();
    $('#edit-announcements').openModal();
    $('#eannounce_to').val($(announcements).attr('data-announce-to'));
    $('#etitle').val($(announcements).attr('data-title'));
    $('#eannouncement').val($(announcements).attr('data-announcement'));
    $('.btn-update-announcements').attr('data-announcements-id', $(announcements).attr('data-announcements-id'));
    reloadSelectField();
}

function deleteAnnouncements(announcements) {
    $('#delete-announcements').openModal();
    $('.btn-delete-yes-announcements').attr('data-announcements-id', $(announcements).attr('data-announcements-id'));
}

