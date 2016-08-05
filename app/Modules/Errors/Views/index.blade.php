
    @extends('theme')
    @section('title_tag')
        <title>Teachat: Page not found</title>
        <meta name="robots" content="index, nofollow">
    @stop

    @section('body_content')
        <nav class="blue-grey darken-4">
            <div class="nav-wrapper container">
                <a href="/" class="brand-logo"><img src="{{asset('images/teachat-logo.png')}}" alt="Teachat"></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li>
                        <a href="/" class="waves-effect blue-grey darken-2"><i class="material-icons">home</i></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container center error_">
            <h1 class="engraved">404</h1>
            <h4>
                The page you are looking for is either <br/>missing or doesn't exist.
            </h4>
        </div>
    @stop