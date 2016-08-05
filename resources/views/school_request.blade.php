<div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
    <div style='width:600px; margin: 0 auto; '>
        <center>
            <div style='padding: 1em 0; background: #D7E8D1;'>
                <img alt='Teachat' src='http://dev.teachat.co/assets/img/teachat2.png' style='margin-left: 1em; width: 150px;'/>
            </div>
        </center>
        <h2 style='letter-spacing: 3px; color:#000 !important;'> Someone reached us to add a School</h2>
        <div style='line-height: 150%;'>
            <br>
            <table>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">School Name</td>
                    <td style="padding-left: 1em;">: {{ $data['school_name'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Region</td>
                    <td style="padding-left: 1em;">: {{ $data['school_region'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Country</td>
                    <td style="padding-left: 1em;">: {{ $data['school_ctry'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Contact Person</td>
                    <td style="padding-left: 1em;">: {{ $data['c_person'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Email Address</td>
                    <td style="padding-left: 1em;">: {{ $data['email'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Contact Number</td>
                    <td style="padding-left: 1em;">: {{ $data['c_number'] }}</td>
                </tr>
                <tr>
                    <td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Additional Message</td>
                    <td style="padding-left: 1em;">: {{ $data['description'] }}</td>
                </tr>
            </table>
            <br/><br/><br/>
            <center>
                <small>
                Copyright &copy 2015 Teachat.co 
                </small>
            </center>
        </div>
    </div>
</div>