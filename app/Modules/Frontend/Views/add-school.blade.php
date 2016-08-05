<!DOCTYPE html>
<html>
    <head>
        <title>Teachat: Request</title>
        <meta name="robots" content="index, follow">
        <meta name="description" content="Request to Teachat. Make a request to add your school in our list!"/>
        @include('includes.header')
    </head>

    <body class="">
        <main class="register_page">

            @include('includes.nav-index')

            <div class="container top-margin">
                <div class="row">
                    <div class="col s12 push-m2 m10 push-l2 l8">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img src="{{asset('images/schools/bg.jpg')}}">
                                <span class="card-title">Add my School</span>
                            </div>
                            <div class="card-content black-text blue-grey lighten-5">
                                <div class="row">
                                    <form class="col s12" id="frm_add-school">
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <input id="school_name" type="text" required="required" aria-required="true" name="school_name">
                                                <label for="school_name">School Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6">
                                                <input id="school_region" type="text" required="required" aria-required="true" name="school_region">
                                                <label for="school_region">City / Town, State / Province</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="school_ctry" type="text" required="required" aria-required="true" name="school_ctry">
                                                <label for="school_ctry">Country</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                              <input id="c_person" type="text" class="validate" required="required" aria-required="true" name="c_person">
                                              <label for="c_person" data-error="wrong" data-success="right">Contact Person</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6">
                                              <input id="email" type="email" class="validate" required="required" aria-required="true" name="email">
                                              <label for="email" data-error="wrong" data-success="right">Email Address</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                              <input id="c_number" type="number" class="validate" required="required" aria-required="true" name="c_number">
                                              <label for="c_number" data-error="wrong" data-success="right">Contact Number</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <textarea id="desc" class="materialize-textarea" class="validate" required="required" name="description" aria-required="true"></textarea>
                                                <label for="desc">Description / Additional Message</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l12">
                                                <button class="btn waves-effect btn-large btn-block waves-light" type="submit">Request to Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){

        $('#frm_add-school').on('submit',function(e){
            e.preventDefault();
            var param = new FormData(this);
            var url = '/api/email/addSchool';
            $.ajax({
                type: "POST",
                url: url,
                processData:false,
                contentType:false,
                cache:false,
                data: param,
                success: function (data) {
                    var json = JSON.parse(data);
                    if(json.code == 1){
                        $('#frm_add-school').append('<ul class="input-field col s12 m12 green lighten-2 white-text ul_notif">'+
                                                '<li>'+
                                                    '<h6><i class="material-icons tiny">check</i> '+json.message+'</h6>'+
                                                '</li>'+
                                            '</ul>');
                    }
                }
            });
        });
    });
</script>