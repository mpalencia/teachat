$(document).ready(function() {
    $('#form_settings').submit(function(e){
        e.preventDefault();
        if($('#email_notification').is(':checked')){
            $('#email_notification').val('1');
        } else {
            $('#email_notification').val('0');
        }
        
        ajaxCall('POST', '/teacher/myaccount/update', getFormInputs(this.id), false, 'card', 'form_settings');
    });
});

$(document).ready(function(){
    $('#frm_settings_changePassword').submit(function(e){
        e.preventDefault();
        ajaxCall('POST', '/teacher/myaccount/changePassword', getFormInputs(this.id), false, 'card', 'frm_settings_changePassword', '', 'one');
        $('#frm_settings_changePassword')[0].reset();
    });
});

        function changeCountry(country) {
                $.get('/teacher/myaccount/country/'+country.value, function(data){
                    var model = $('#state_id');
                        model.empty();
                        model.append("<option disabled selected>Select State/Province</option>");

                    if(data.result) {
                        var output = [];
                        
                        $.each(data.message, function(key, value){

                                model.append("<option value='"+ value.id +"'>" + value.state_name + "</option>");

                        });
                        model.material_select();
                                
                    }

                    else {
                        model.append("");
                        model.material_select();
                        Materialize.toast(data.message, 7000, "red");
                    }
                });
            }
