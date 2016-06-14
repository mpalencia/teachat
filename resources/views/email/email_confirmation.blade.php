<div style='color:#000 !important; font-family: Arial, Helvetica, sans-serif; width:100%;'>
	<div style='width:600px; margin: 0 auto; '>
		<center>
			<div style='padding: 1em 0; background: #D7E8D1;'>
				<img alt='Teachat' src='http://dev.teachat.co/assets/img/teachat2.png' style='margin-left: 1em; width: 150px;'/>
			</div>
			<h1 style='letter-spacing: 3px; color:#000 !important;'> Welcome to Teachat!</h1>
			<div style='margin: 1em !important; line-height: 150%;'>
				<p style='font-size: 120%; letter-spacing: 1px; color:#000 !important;'>
					In order to start using the service<br/>
					you need to first activate your account. <br/>
					Please click the link below.
				</p>
				<br>
				<a href="{{ $data['link'] }}" style='text-decoration: none';>
					<span  style='-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 0px;font-family: Arial;color: #ffffff;font-size: 15px;background: #578548;padding: 10px 20px 10px 20px;text-decoration: none; width:80%; display:block; margin: 0 auto; margin-top: -20px;'>
						Activate account
					</span>
				</a>
				<small style='color: #000;'>
					Click activate account or Copy and paste the provided link to your browser <br/>
					{{ $data['link'] }}
				</small><br/><br/>
				<small>
					Copyright &copy 2015 Teachat.co
				</small>
			</div>
		</center>
	</div>
</div>
