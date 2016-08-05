
var nColNumber = -1;


var children = $('#children').DataTable({
    'ajax': 'child/'+parent_id,
    'processing': true,
    'order': [[ 0, "asc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Children', 'name': 'students', 'data': 'students' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});

function viewChild(id) {
	$('#view-students').openModal();

	$.get('/school-admin/manage-parents/getChildById/'+id, function(result){

        $('#student_name').html(result.data[0][0]);
        $('#student_grade_description').html(result.data[0][3]);
        $('#student_gender').html(result.data[0][1]);
        $('#student_birthdate').html(result.data[0][2]);
        $('#student_state').html(result.data[0][4]);
        $('#student_section').html(result.data[0][5]);
    });

 }
 student_section