	<div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
		<div style='width:600px; margin: 0 auto; '>
			<center>
				<div style='padding: 1em 0; background: #D7E8D1;'>
					<img alt='Teachat' src='http://dev.teachat.co/assets/img/teachat2.png' style='margin-left: 1em; width: 150px;'/>
				</div>
			</center>
			<h1 style='letter-spacing: 3px; color:#000 !important;'> Someone message us.</h1>
			<div style='line-height: 150%;'>
				<br>
				<table>
					<tr>
						<td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Email</td>
						<td style="padding-left: 1em;">: {{ $data['email'] }}</td>
					</tr>
					<tr>
						<td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">Fullname</td>
						<td style="padding-left: 1em;">: {{ $data['fullname'] }}</td>
					</tr>
					<tr>
						<td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">State</td>
						<td style="padding-left: 1em;">: {{ $data['state'] }}</td>
					</tr>
					<tr>
						<td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">City</td>
						<td style="padding-left: 1em;">: {{ $data['city'] }}</td>
					</tr>
					<tr>
						<td style="color: #ccc; letter-spacing: 1px; font-weight:bolder; padding: .5em 0;">School Name</td>
						<td style="padding-left: 1em;">: {{ $data['school'] }}</td>
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