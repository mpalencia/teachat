<div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
	<div style='width:600px; margin: 0 auto; '>
		<center>
			<div style='padding: 1em 0; background: #D7E8D1;'>
				<img alt='Teachat' src='https://dev3.teachat.co/images/teachat-logo.png' style='margin-left: 1em; width: 150px;'/>
			</div>
			<h1 style='letter-spacing: 3px; color:#000 !important;'> Welcome to Teachat!</h1>
			<div style='margin: 1em !important; line-height: 150%;'>
				<p style='font-size: 120%; letter-spacing: 1px; color:#000 !important;'>
					Your School Admin created your account<br/>
					We generated a temporary password to your account.<br/>
					Please log in to Teachat with the information below.
				</p>
				<br>
					<span  style='-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;font-family: Arial;color: #ffffff;font-size: 20px;background: #D7E8D1;padding: 20px 20px 20px 20px;text-decoration: none; width:80%; display:block; margin: 0 auto; text-shadow: 0px 0px 1px #000; letter-spacing: 1px;'>
						<strong style='color: rgba(0,0,0,0.5)'>Your Username:</strong> <strong style='color: blue'>{{ $data['temp_email'] }}</strong>
					</span>
					<br>
					<span  style='-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;font-family: Arial;color: #ffffff;font-size: 20px;background: rgba(0,0,0,0.5);padding: 20px 20px 20px 20px;text-decoration: none; width:80%; display:block; margin: 0 auto; text-shadow: 0px 0px 1px #000; letter-spacing: 1px;'>
						<strong>Your Password: {{ $data['temp_password'] }}</strong>
					</span>
					Click <a href="{{ $data['link'] }}" style='text-decoration: none';> here </a>to login to your account.<br/><br/>
				<small>
					Copyright &copy; 2015 Teachat.co
				</small>
			</div>
		</center>
	</div>
</div>