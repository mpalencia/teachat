
var nColNumber = -1;
var announcements = $('#announcements').DataTable({
    'ajax': 'announcements/getAll',
    'processing': true,
    'order': [[ 1, "desc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Title', 'name': 'title', 'data': 'title' },
        { 'targets': [ ++nColNumber ], 'title':'Date Created', 'name': 'created_at', 'data': 'created_at' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
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

