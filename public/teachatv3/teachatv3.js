
$('select').material_select();


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
    $('select').material_select();
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

function ajaxCall(type, url, data, redirect = false, modal = 'card', form = '', table = '')
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
                showNotification();
                showErrorNotification(result);
                return false;
            }

            if(modal != 'card') {
                $('.'+modal).closeModal();
            }

            hideNotification();

            if(redirect) {
                window.location.href = result.message;
            }

            else {
                Materialize.toast(result.message, 12000)
            }

            if(form != '') {
                clearForm(form);
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