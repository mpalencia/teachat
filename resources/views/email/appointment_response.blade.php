<div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
  <div style='width:600px; margin: 0 auto; '>
    <center>
      <div style='padding: 1em 0; background: #D7E8D1;'>
        <img alt='Teachat' src='https://dev3.teachat.co/images/teachat-logo.png' style='margin-left: 1em; width: 150px;'/>
      </div>""
    </center>
    <div style='line-height: 150%;'>
      <center><img alt='Teachat' src="https://s3-ap-southeast-1.amazonaws.com/teachatco/images/{{ $data['user_image'] }}" style='margin-left: 1em; width: 150px;'/></center>
      <center><h1 style="letter-spacing: 1px;">{{ $data['title'] }}</h1></center>
      <table>
        <tbody>
          <tr>
            <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Meeting with</td>
            <td>: {{ $data['first_name'] }} {{ $data['last_name'] }}</td>
          </tr>
          <tr>
            <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Date</td>
            <td>: {{ $data['appt_date'] }}</td>
          </tr>
          <tr>
            <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Time</td>
            <td>: {{ $data['appt_stime'] }} - {{ $data['appt_etime'] }}</td>
          </tr>
        </tbody>
      </table>
      <hr/>
      <h4 style='letter-spacing: 3px; color:#ccc !important; font-weight: 100;'> ** Parent's Response **</h4>
      @if( $data['action'] === 'Accept' )
        <p style="color: green !important; font-size: 20px;">{{ ($data['role_id'] == 3) ? 'The parent accepted this appointment.' : 'The teacher accepted this appointment.'}}</p>
      @elseif( $data['action'] === 'Inperson')
        <p style="color: blue !important; font-size: 20px;">{{ ($data['role_id'] == 3) ? 'The parent will see you in person.' : 'The teacher will see you in person.'}}</p>
      @else
        <p style="color: red !important; font-size: 20px;">{{ ($data['role_id'] == 3) ? 'The parent declined this appointment.' : 'The parent declined this appointment.'}}</p>
        <small>
          <span style="color: #ccc; display: block;">Reason why the parent declined this appointment:</span>
          {{ $data['action'] }}
        </small>
      @endif

        <br/><br/>
      <a href="http://dev2.teachat.co/login" style='text-decoration: none; text-align:center;';>
        <span  style='-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 0px;font-family: Arial;color: #ffffff;font-size: 15px;background: #578548;padding: 10px 20px 10px 20px;text-decoration: none; width:20%; display:block; margin: 0 auto; margin-top: -20px;'>Login to view
        </span>
      </a>
      <br/><br/>
      <center>
        <small>
          Copyright &copy; 2015 Teachat.co
        </small>
      </center>
    </div>
  </div>
</div>
