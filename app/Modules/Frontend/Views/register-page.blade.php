<!DOCTYPE html>
<html>
    <head>
        @include('includes.header')

        <script type="text/javascript">
            $(document).ready(function() {
                $(".button-collapse").sideNav();
                $(".dropdown-button").dropdown({
                    hover: false,
                    inDuration: 150,
                    belowOrigin: true, // Displays dropdown below the button
                });
                $('.parallax').parallax();
            });
            $(document).ready(function() {
                $('select').material_select();
                $("select[required]").css({display: "inline", height: 0, padding: 0, width: 0});
            });
        </script>
    </head>

    <body class="">
        <main class="register_page">

            @include('includes.nav-index')

            <div class="container top-margin">
                <div class="row">
                    <div class="col s12 push-m2 m10 push-l2 l8">
                        <div class="card hoverable">
                            <div class="card-image">
                                <img src="{{asset('images/login.jpg')}}">
                                <span class="card-title">Register</span>
                            </div>
                            <div class="card-content black-text blue-grey lighten-5">
                                <div class="row">
                                    <form class="col s12">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <select required="required" aria-required="true">
                                                  <option value="" disabled selected>Choose your Country</option>
                                                  <option value="Philippines">Philippines</option>
                                                  <option value="United States">United States</option>
                                                </select>
                                                <label>Choose your Country</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <select required="" aria-required="true">
                                                  <option value="" disabled selected>Choose your Location</option>
                                                  <option value="Regions here">Regions here1</option>
                                                  <option value="Regions here">Regions here2</option>
                                                </select>
                                                <label>Choose your Region</label>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <select required="" aria-required="true">
                                                  <option value="" disabled selected>Choose your School</option>
                                                  <option value="School here">School here1</option>
                                                  <option value="School here">School here2</option>
                                                </select>
                                                <label>Choose your School</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4 m2">
                                                <select required="" aria-required="true">
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Ms.">Ms.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                    <label>Select</label>
                                                </select>
                                            </div>
                                            <div class="input-field col s8 m5">
                                                <input id="f_name" type="text" class="validate" required="" aria-required="true">
                                                <label for="f_name">First Name</label>
                                            </div>
                                            <div class="input-field col s12 m5">
                                                <input id="l_name" type="text" class="validate" required="" aria-required="true">
                                                <label for="l_name">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                <input id="email" type="email" class="validate" required="" aria-required="true">
                                                <label for="email" data-error="wrong" data-success="right">Email</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6">
                                                <input id="password" type="password" required="" aria-required="true">
                                                <label for="password">Password</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="confirm_password" type="password" required="" aria-required="true">
                                                <label for="confirm_password">Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m3">
                                                <input type="checkbox" class="filled-in" id="terms" required="" aria-required="true" checked="checked" />
                                                <label for="terms">I Agree</label>
                                            </div>
                                            <div class="input-field col s12 m9">
                                                Do you agree to the Teachat Terms and Conditions set out by this site, including our Cookie Use?
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m5 l4">
                                                <button class="btn waves-effect btn-large btn-block waves-light" type="submit" name="action">Submit
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                            <div class="input-field col s12 m5 l4">
                                                <a href="/" class="waves-effect waves-light btn btn-large red darken-1 btn-block">Cancel</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12">
                                                
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