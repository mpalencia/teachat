<!DOCTYPE html>
<html>
    <head>
        <title>Demo</title>
        <meta name="robots" content="index, follow">
        <meta name="description" content="DEMO"/>
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
                                <span class="card-title">Login Demo</span>
                            </div>
                            <div class="card-content black-text blue-grey lighten-5">
                                <div class="row">
                                    <div class="input-field col s12 m12 l12">
                                        <a href="/Demo/AsParent" class="btn waves-effect btn-large btn-block waves-light green" type="submit">Login as Parent</a>
                                    </div>
                                    <div class="input-field col s12 m12 l12">
                                        <a href="/Demo/AsTeacher" class="btn waves-effect btn-large btn-block waves-light blue" type="submit">Login as Teacher</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>