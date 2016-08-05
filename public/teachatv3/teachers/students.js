var nColNumber = -1;
var students = $('#students').DataTable({
    'ajax': 'students/get',
    'processing': true,
    'order': [[ 2, "desc" ]],
    'columnDefs': [
        { 'targets': [ ++nColNumber ], 'title':'Name', 'name': 'name', 'data': 'name' },
        { 'targets': [ ++nColNumber ], 'title':'Grade', 'name': 'grade', 'data': 'grade' },
        { 'targets': [ ++nColNumber ], 'title':'Subject', 'name': 'subject', 'data': 'subject' },
        { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
    ]
});