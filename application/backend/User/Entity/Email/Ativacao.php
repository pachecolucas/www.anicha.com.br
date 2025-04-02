<?php

class User_Entity_Email_Ativacao extends User_Entity_Email {
	
	public function __construct($toNome, $toLogin, $id, $codigo) {
		
		$linkDeAtivacao = SITE."user/activate/u/$id/c/$codigo";
		
		$msgTitle = "Olá, $toNome";
		
		$msgSubTitle = "Obrigado por cadastrar-se no ".SITENAME.".<br>Ative sua conta clicando no link abaixo:";
		
		$msgBody = "
			<strong><a href='$linkDeAtivacao'>ATIVAR MINHA CONTA.</a></strong>
			<p>
				Caso o link acima não funcione copie e cole este link na sua barra de endereços:<br>
				$linkDeAtivacao
			</p>
			<br>
			<p>
				<span style='font-size:12px;'>
					<b style='color:red;'>ATENÇÃO:</b><br>Caso você não tenha criado uma conta no ".SITENAME.", por favor, ignore esta mensagem e a encaminhe para <b>atendimento@rendasdeimarui.com.br</b>
				</span>
			</p>
				";
		
		$subject = "Nova Conta ".SITENAME." - $toNome";
                
                
                
								
		parent::send($toNome, $toLogin, $msgTitle, $msgSubTitle, $msgBody, $subject);
	}
	
}