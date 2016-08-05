<footer class="page-footer grey darken-4"><br/>
    <div class="container">
            <div class="row">
                @if(\Auth::check())
                <div class="col l3 m3 s12">
                    <h6 class="grey-text footer_header">SITEMAP</h6>
                    <ul>
                        <li><a class="grey-text text-lighten-4" href="dashboard">Dashboard</a></li>
                        <li><a class="grey-text text-lighten-4" href="myaccount">My Account</a></li>
                        <li><a class="grey-text text-lighten-4" href="messages">Messages</a></li>
                        <li><a class="grey-text text-lighten-4" href="appointments">Appointments</a></li>
                        <li><a class="grey-text text-lighten-4" href="announcements">Announcements</a></li>
                    </ul>
                </div>
                @else
                <div class="col l3 m3 s12">
                    <h6 class="grey-text footer_header">SITEMAP</h6>
                    <ul>
                        <li><a class="grey-text text-lighten-4" href="/">Home</a></li>
                        <li><a class="grey-text text-lighten-4" href="/login">Login</a></li>
                        <li><a class="grey-text text-lighten-4" href="/registration">Register</a></li>
                    </ul>
                </div>
                @endif
                <div class="col l3 m3 s12">
                    <h6 class="grey-text footer_header">ABOUT</h6>
                    <ul>
                        <li><a class="grey-text text-lighten-4" href="/privacy-policy">Privacy Policy</a></li>
                        <li><a class="grey-text text-lighten-4" href="/terms-of-use">Terms of Use</a></li>
                        <li><a class="grey-text text-lighten-4" href="/contact-us">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col l3 m3 s12">
                    <h6 class="grey-text footer_header">CONNECT</h6>
                    <ul>
                        <li><a class="grey-text text-lighten-4" href="https://www.facebook.com/teachat.co/" target="_blank">Facebook</a></li>
                        <li><a class="grey-text text-lighten-4" href="https://twitter.com/teachatco" target="_blank">Twitter</a></li>
                        <li><a class="grey-text text-lighten-4" href="https://www.crunchbase.com/organization/teachat#/entity" target="_blank">CrunchBase</a></li>
                        <li><a class="grey-text text-lighten-4" href="https://www.linkedin.com/company/teachat" target="_blank">LinkedIn</a></li>
                        <li><a class="grey-text text-lighten-4" href="https://angel.co/teachat" target="_blank">AngelList</a></li>
                    </ul>
                </div>
                <div class="col l3 m3 s12">
                    <h6 class="grey-text footer_header">TALK TO US</h6>
                    <p class="white-text">US - +1-202-817-5139</p>
                    <p class="white-text">PH - (632) 822 - 2755</p>
                </div>
            </div>
      </div>
      <div class="footer-copyright black">
        <div class="container">
            © 2016 Teachat
            <span id="siteseal"><script type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=VKH017B9Xx4HXLqlLEyrvuw0PcUqt4E1EBxE5LzUPamz0ofidXjN09YylG5y"></script></span>
        </div>
      </div>
</footer>
