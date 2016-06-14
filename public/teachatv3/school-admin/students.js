
var nColNumber = -1;


var students = $('#students').DataTable({
    'ajax': 'students/getAllChildren/'+parent_id,
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Students', 'name': 'students', 'data': 'students' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

$('.btn-approve-yes-students').on('click', function() {
    $.ajax({
        url: 'students/updateChild/'+$(this).attr('data-students-id'),
        type: 'PUT',
        data: {approved: 1},
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete', true);
            reloadTable(students);
            $('#approve-students').closeModal();
        }
    });
});

$('.btn-deny-yes-students').on('click', function() {
    $.ajax({
        url: 'students/updateChild/'+$(this).attr('data-students-id'),
        type: 'PUT',
        data: {approved: 2},
        success: function(data) {
            showAlertNotification(data.result, data.message, 'delete', true);
            reloadTable(students);
            $('#deny-students').closeModal();
        }
    });
});

function approveStudent(students) {
    $('#approve-students').openModal();
    $('#student_to_approve').html($(students).attr('data-students-name'));
    $('.btn-approve-yes-students').attr('data-students-id', $(students).attr('data-students-id'));
}

function denyStudent(students) {
    $('#deny-students').openModal();
    $('#student_to_deny').html($(students).attr('data-students-name'));
    $('.btn-deny-yes-students').attr('data-students-id', $(students).attr('data-students-id'));
}

function viewStudent(id) {
    $('#view-students').openModal();
    
    $.get('students/getChild/'+id, function(result){

        $('#student_name').html(result.data.first_name + ' ' + result.data.middle_name + ' ' + result.data.last_name);
        $('#student_grade_description').html(result.data.grade.description);
        $('#student_gender').html(result.data.gender);
        $('#student_birthdate').html(result.data.birthdate);
        $('#student_state').html(result.data.state.state_name);
        $('#student_city').html(result.data.city);
    });


    //$('.btn-deny-yes-students').attr('data-students-id', $(students).attr('data-students-id'));
}
