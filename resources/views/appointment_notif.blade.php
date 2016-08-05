  <div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
    <div style='width:600px; margin: 0 auto; '>
      <center>
        <div style='padding: 1em 0; background: #D7E8D1;'>
          <img alt='Teachat' src='http://dev.teachat.co/assets/img/teachat2.png' style='margin-left: 1em; width: 150px;'/>
        </div>
      </center>
      <h4 style='letter-spacing: 3px; color:#ccc !important; font-weight: 100;'> ** You have a new appointment **</h4>
      <div style='line-height: 150%;'>
        <h1 style="letter-spacing: 1px;">{{ $data[0]->title }}</h1>
        <table>
          <tbody>
            <tr>
              <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Meeting with</td>
              <td>: {{ $data['teacher'][0]->first_name }} {{ $data['teacher'][0]->last_name }}</td>
            </tr>
            <tr>
              <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Date</td>
              <td>: {{ $data[0]->appt_date }}</td>
            </tr>
            <tr>
              <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Time</td>
              <td>: {{ $data[0]->appt_stime }} - {{ $data[0]->appt_etime }}</td>
            </tr>
            <tr>
              <td style="padding:.5em 1em 1em 0!important; letter-spacing:1px; color:#999;">Description</td>
              <td>: {{ $data[0]->description }}</td>
            </tr>
          </tbody>
        </table>
        <br/><br/>
        <a href="http://dev2.teachat.co/" style='text-decoration: none; text-align:center;';>
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
