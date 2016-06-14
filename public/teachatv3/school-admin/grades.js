
var nColNumber = -1;
var grades = $('#grades').DataTable({
    'ajax': 'grades/getAll',
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Grades', 'name': 'grades', 'data': 'grades' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

$('#form_add_grades').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'grades/store', getFormInputs(this.id), false, 'card', 'form_add_grades', grades);
});

$('.form_edit_grades').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'grades/edit/'+$(this).find(":submit").attr('data-grades-id'), getFormInputs(this.id), false, 'edit-grades', 'form_edit_grades', grades);
});

$('.btn-delete-yes-grades').on('click', function() {
    $.ajax({
        url: 'grades/delete/'+$(this).attr('data-grades-id'),
        type: 'DELETE',
        success: function(data) {
            Materialize.toast(data.message, 8000)
            reloadTable(grades);
        }
    });
});


function editGrades(grades) {
    hideNotification();
    $('.ediv_notif').html('');
    $('#egrade').focus();
    $('#edit-grades').openModal();
    $('#egrade_id').val($(grades).attr('data-grades-id'));
    $('#egrade').val($(grades).attr('data-description'));
    $('.btn-update-grades').attr('data-grades-id', $(grades).attr('data-grades-id'));
}

function deleteGrades(grades) {
    $('#delete-grades').openModal();
    $('.btn-delete-yes-grades').attr('data-grades-id', $(grades).attr('data-grades-id'));
}

