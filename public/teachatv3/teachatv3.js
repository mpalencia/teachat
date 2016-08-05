$('.modal-trigger').leanModal({
    dismissible: false, // Modal can be dismissed by clicking outside of the modal
    opacity: .5, // Opacity of modal background
    in_duration: 300, // Transition in duration
    out_duration: 200, // Transition out duration
    ready: function() { hideNotification(); }, // Callback for Modal open
    complete: function() { hideNotification();} // Callback for Modal close
    }
);

$('.freakin-modal').on('click', function(){
    hideNotification();
});

function reloadTable(table)
{
	table.ajax.reload();
}

function reloadPage()
{
    location.reload()
}

function showAlertNotification(result, message, type, reload =  false) {

    var alert = '<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">error_outline</i> '+ message + '</h6></li></ul>';
    if(result) {
        alert = '<ul class="input-field col s12 m12 green lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">check</i> '+ message + '</h6></li></ul>';
        $('#edit-grades').closeModal();
    }
    if(type == 'add'){
        $('.div_notif').html(alert);
    }
    if(type == 'edit'){
        $('.ediv_notif').html(alert);
    }
    if(type == 'delete') {
        $('.ddiv_notif').html(alert);
    }

    setTimeout(function(){$('.notif').html(''); if(reload){reloadPage()} }, 5000);
}

function clearForm(form_id)
{
    document.getElementById(form_id).reset();
}

function reloadSelectField()
{
    $('.select').material_select();
}

function getFormInputs(form_id)
{
    var inputs = $('#' + form_id + ' :input');

    var values = {};

    inputs.each(function() {
        values[this.name] = $(this).val();
    });

    return values;
}

function showValidationErrorNotification(errors)
{
    var alert = '';

    Object.keys(errors).forEach(function(index){
        alert = '<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">error_outline</i> '+ errors[index] + '</h6></li></ul>';
    });

    $('.div_notif').html(alert);
}

function showErrorNotification(errors)
{
    
    var alert = '<ul class="input-field col s12 m12 red lighten-2 white-text ul_notif"><li><h6><i class="material-icons tiny">error_outline</i> '+ errors.message + '</h6></li></ul>';

    $('.div_notif').html(alert);
}

function ajaxCall(type, url, data, redirect = false, modal = 'card', form = '', table = '', changePassword = null, rurl = '1')
{
    
    disableButton();
    appendLoader(modal);    

    $.ajax({
        type: type,
        url: url,
        data: data,
        dataType: 'json',
        success: function(result) {
            
            if(! result.success) {
                //showNotification();
                //showErrorNotification(result);
                Materialize.toast(result.message, 10000, "red");
                return false;
            }

            else {
                if(changePassword == 'one'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.reload(); });
                } else if(changePassword == 'manage-parents'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/school-admin/manage-parents'; });
                } else if(changePassword == 'manage-teachers'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/school-admin/manage-teachers'; });
                } else if(changePassword == 'admin-teachers'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/admin/teachers'; });
                } else if(changePassword == 'admin-parents'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/admin/parents'; });
                } else if(changePassword == 'admin-schools'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/admin/schools'; });
                } else if(changePassword == 'admin-schooladmin'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/admin/school-admin'; });
                } else if(changePassword == 'parent-appointment'){
                    Materialize.toast(result.message, 1000, "green", function(){ window.location.href = '/parent/appointments'; });
                } else if(changePassword == 'login'){
                        window.location.href = result.message;
                }else {
                    Materialize.toast(result.message, 3000, "green");
                }
                
                return false;
            }

            if(modal != 'card') {
                $('.'+modal).closeModal();
            }

            hideNotification();

            if(redirect) {
                window.location.href = result.message;
            }
            if(form != '') {
                clearForm(form);
            }
            if(rurl == '2') {
                Materialize.toast(result.message, 2000, "green");
                window.location.href = result.url;
            }

            

            
        },
        error: function(result){

            showNotification();
            showValidationErrorNotification(result.responseJSON);

        },
        complete: function(result) {
            if(table != '') {
                reloadTable(table);
            }
            enableButton();
            removeLoader(modal);
        }
    });
}

function hideNotification()
{
    $('.div_notif').hide();
}

function showNotification()
{
    $('.div_notif').show();
}

function disableButton(id = '')
{   
    var button = 'button';
    
    if(id != '') {
        button = id;
    }

    $('button').attr('disabled', 'disabled');
}

function enableButton(id = '')
{
    var button = 'button';

    if(id != '') {
        button = id;
    }

    $(button).removeAttr('disabled');
}

function appendLoader(modal)
{
    if(modal != 'card') {
        $('#'+modal).append('<div class="progress">'+'<div class="indeterminate"></div>'+'</div>');
    }

    else {
        $('.'+modal).append('<div class="progress">'+'<div class="indeterminate"></div>'+'</div>');   
    }
}

function removeLoader(modal)
{
    if(modal != 'card') {
        $('#'+modal).find('.progress').remove();
    }

    else {
        $('.card').find('.progress').remove();
    }
}