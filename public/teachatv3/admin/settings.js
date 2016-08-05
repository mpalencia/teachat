$(document).ready(function() {
    $('#form_settings_admin').submit(function(e){
        e.preventDefault();
        ajaxCall('POST', '/admin/settings/update', getFormInputs(this.id), false, 'card', 'form_settings_admin');
    });
});

$(document).ready(function(){
    $('#frm_settings_changePassword').submit(function(e){
        e.preventDefault();
        ajaxCall('POST', '/admin/settings/changePassword', getFormInputs(this.id), false, 'card', 'frm_settings_changePassword', '', 'one');
        $('#frm_settings_changePassword')[0].reset();
    });
});