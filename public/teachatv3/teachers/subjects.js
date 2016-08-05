
var nColNumber = -1;
var subjects = $('#subjects').DataTable({
    'ajax': 'subjects/getAll',
    'processing': true,
    'order': [],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Grade', 'name': 'grade', 'data': 'grade' },
        { 'targets': [ ++nColNumber ], 'title':'Subject Category', 'name': 'subject_category', 'data': 'subject_category' },
        { 'targets': [ ++nColNumber ], 'title':'Subject', 'name': 'subject', 'data': 'subject' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});


$('#form_add_subjects').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'subjects', getFormInputs(this.id), false, 'card', 'form_add_subjects', subjects);
    window.location.reload();
});

/*$('.form_edit_subjects').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'subjects/edit/'+$(this).find(":submit").attr('data-subjects-id'), getFormInputs(this.id), false, 'edit-subjects', 'form_edit_subjects', subjects);
});*/

$('.btn-delete-yes-subjects').on('click', function() {
    $.ajax({
        url: 'subjects/'+$(this).attr('data-subjects-id'),
        type: 'DELETE',
        success: function(data) {
            Materialize.toast(data.message, 8000)
            reloadTable(subjects);
            window.location.reload();
        }
    });
});


function editSubject(subjects) {
    hideNotification();
    $('.ediv_notif').html('');
    $('#esubject').focus();
    $('#edit-subjects').openModal();
    $('#esubject_id').val($(subjects).attr('data-subjects-id'));
    $('#esubject').val($(subjects).attr('data-description'));
    $('.btn-update-subjects').attr('data-subjects-id', $(subjects).attr('data-subjects-id'));
}

function deleteSubject(subjects) {
    $('#delete-subjects').openModal();
    $('.btn-delete-yes-subjects').attr('data-subjects-id', $(subjects).attr('data-subjects-id'));
}

