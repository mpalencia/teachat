
var nColNumber = -1;
var subject_categories = $('#subject-categories').DataTable({
    'ajax': 'subject-category/getAll',
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Subject Category', 'name': 'subject_category', 'data': 'subject_category' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

$('.btn-delete-yes-subject-category').on('click', function() {
    $.ajax({
        url: 'subject-category/delete/'+$(this).attr('data-subject-category-id'),
        type: 'DELETE',
        success: function(data) {
            Materialize.toast(data.message, 8000)
            reloadTable(subject_categories);
        }
    });
});

$('#form_add_subject_category').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'subject-category/store', getFormInputs(this.id), false, 'card', 'form_add_subject_category', subject_categories);
});

$('.form_edit_subject_category').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'subject-category/edit/'+$(this).find(":submit").attr('data-subject-category-id'), getFormInputs(this.id), false, 'edit-subject-category', 'form_edit_subject_category', subject_categories);
});

function editSubjectCategory(subjectCategory) {
    hideNotification();
    $('.ediv_notif').html('');
    $('#esubject_category').focus();
    $('#edit-subject-category').openModal();
    $('#esubject_category_id').val($(subjectCategory).attr('data-subject-category-id'));
    $('#esubject_category').val($(subjectCategory).attr('data-description'));
    $('.btn-update-subject-category').attr('data-subject-category-id', $(subjectCategory).attr('data-subject-category-id'));
}

function deleteSubjectCategory(subjectCategory) {
    $('#delete-subject-category').openModal();
    $('.btn-delete-yes-subject-category').attr('data-subject-category-id', $(subjectCategory).attr('data-subject-category-id'));
}