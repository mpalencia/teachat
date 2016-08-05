
var nColNumber = -1;
var curriculum = $('#curriculum').DataTable({
    'ajax': 'curriculum/getAll',
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Grades', 'name': 'grades', 'data': 'grades' },
        { 'targets': [ ++nColNumber ], 'title':'Subject Category', 'name': 'subject_category', 'data': 'subject_category' },
        { 'targets': [ ++nColNumber ], 'title':'Subject', 'name': 'subject', 'data': 'subject' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

$('#form_add_curriculum').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'curriculum', getFormInputs(this.id), false, 'card', 'form_add_curriculum', curriculum);
    $('#form_add_curriculum')[0].reset();
    setTimeout(function(){$('.notif').html(''); }, 3000);
});

$('.form_edit_curriculum').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'curriculum/'+$(this).find(":submit").attr('data-curriculum-id'), getFormInputs(this.id), false, 'edit-curriculum', 'form_edit_curriculum', curriculum);
});

$('.btn-delete-yes-curriculum').on('click', function() {
    $.ajax({
        url: 'curriculum/'+$(this).attr('data-curriculum-id'),
        type: 'DELETE',
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete');
            reloadTable(curriculum);
            $('#delete-curriculum').closeModal();
        }
    });
});


function editCurriculum(curriculum) {
    console.log($(curriculum).attr('data-grade-id'));
    $('.ediv_notif').html('');
    $('#ecurriculum').focus();
    $('#edit-curriculum').openModal();
    $('#egrade_id').val($(curriculum).attr('data-grade-id'));
    $('#esubject_category_id').val($(curriculum).attr('data-subject-category-id'));
    $('#esubject').val($(curriculum).attr('data-subject'));
    $('.data_curriculum_id').val($(curriculum).attr('data-curriculum-id'));
    $('.btn-update-curriculum').attr('data-curriculum-id', $(curriculum).attr('data-curriculum-id'));
    reloadSelectField();
}

function deleteCurriculum(curriculum) {
    $('#delete-curriculum').openModal();
    $('.btn-delete-yes-curriculum').attr('data-curriculum-id', $(curriculum).attr('data-curriculum-id'));
}

