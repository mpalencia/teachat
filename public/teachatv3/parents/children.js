
$('#form_child_add').on('submit',function(e){
    e.preventDefault();
    ajaxCall('POST', 'store', getFormInputs(this.id), false, 'card', 'form_child_add');
});

$('#form_child_edit').on('submit',function(e){
    e.preventDefault();
    ajaxCall('PUT', 'store', getFormInputs(this.id), false, 'card', 'form_child_edit');
});