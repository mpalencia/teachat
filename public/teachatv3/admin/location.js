   
    var nColNumber = -1;
    var states = $('#locations').DataTable({
        'ajax': 'location/getAll',
        'processing': true,
        'order': [[ 2, "asc" ]],
        'columnDefs': [
            { 'targets': [ ++nColNumber ], 'title':'Country', 'name': 'country_id', 'data': 'country' },
            { 'targets': [ ++nColNumber ], 'title':'State', 'name': 'state_name', 'data': 'state_name' },
            { 'targets': [ ++nColNumber ], 'title':'State Code', 'name': 'state_code', 'data': 'state_code' },
            { 'targets': [ ++nColNumber ], 'title':'Actions', 'name': 'action', 'data': 'action'},
        ]
    });

    var add = $('#add_location');
    var edit = $('#edit_location');

    function showEditLocation(id) {
           $.ajax( {
                url: "/admin/location/edit/"+id,
                type: 'GET',
                data: {},

                success: function (d) {
                    document.getElementById("state_edit").innerHTML='Region / State';
                    $('#code_edit').removeClass('hide');

                    if(d.data.country_id == 2){
                        document.getElementById("state_edit").innerHTML='Province';
                        $('#code_edit').addClass('hide');
                    }

                    $('#count').val(d.data.country_id);
                    $('#count').material_select();
                    $('#state_region_edit').val(d.data.state_name);
                    $('#state_code_edit').val(d.data.state_code);
                    $('#editing_id').val(d.data.id);

                }
            });

        $('#add_location').addClass('hide');
        $('#edit_location').removeClass('hide');
    }

    function changeCountry(country) {

        document.getElementById("state_add").innerHTML='Region / State';
        $('#code_add').removeClass('hide');

        if(country.value == 2){
            document.getElementById("state_add").innerHTML='Province';
            $('#code_add').addClass('hide');
        } 
    }


    function changeCountryEdit(country) {

        document.getElementById("state_edit").innerHTML='Region / State';
        $('#code_edit').removeClass('hide');

        if(country.value == 2){
            document.getElementById("state_edit").innerHTML='Province';
            $('#code_edit').addClass('hide');
        }
    }

    $('#add-new_state').on('submit',function(e){
        e.preventDefault();
        ajaxCall('POST', '/admin/location/store', getFormInputs(this.id), false, 'card', 'add-new_state', states);
        if($('#add_location').removeClass("hide")){
            $('#edit_location').addClass("hide");
        }
        $('#add-new_state')[0].reset();
    });

    $('#edit_location_form').submit(function(e){
        e.preventDefault();
        var data = {'country_id':$('#count').val(),'state_name':$('#state_region_edit').val(),'state_code':$('#state_code_edit').val()};
        ajaxCall('POST', '/admin/location/update/'+$('#editing_id').val(), data, false, 'card', 'edit_location_form');
        reloadTable(states);
        if($('#add_location').removeClass("hide")){
            $('#edit_location').addClass("hide");
        }
        $('#edit_location_form')[0].reset();

    });

    $('.btn_yes_delete').on('click', function() {
        $.ajax({
            url: '/admin/location/delete/'+$(this).attr('data-id'),
            type: 'DELETE',
            success: function(data) {
               Materialize.toast(data.message, 7000)
               reloadTable(states);
            }
        });
    });

    function deleteLocation(state) {
        var name = $(state).data('state');
        document.getElementById("state_n").innerHTML = name;
        $('#delete_location_modal').openModal();
        $('.btn_yes_delete').attr('data-id', $(state).attr('data-id'));
    }