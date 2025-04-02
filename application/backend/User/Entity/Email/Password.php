<?php

class User_Entity_Email_Password extends User_Entity_Email {
	
	public function __construct(User_Entity_User $user) {
		
		$linkDePassword = SITE."user/pass/new/u/".$user->id."/c/".$user->codigo;
		
		$msgTitle = "Olá, ".$user->nome."!";
		
		$msgSubTitle = "Você solicitou a criação de uma nova senha para acessar sua conta no site ".SITENAME.".";
		
		$msgBody = "
                        <p>Para criar uma nova senha basta clicar no link abaixo:</p>
                        <p>
                            <strong>
                                <a href='$linkDePassword'>
                                        CRIAR NOVA SENHA
                                </a>
                            </strong>
                        </p>
			<p>
				Caso o link acima não funcione copie e cole este link na sua barra de endereços:<br>
				$linkDePassword
			</p>
			<br>
			<p>
                                <span style='font-size:12px;'>
                                        <b style='color:red;'>ATENÇÃO:</b><br>Caso não tenha solicitado uma nova senha, por favor, ignore esta mensagem e a encaminhe para <b>".EMAIL."</b>
                                </span>
			</p>
				";
		
		$subject = "Instrução para criação de nova senha - ".SITENAME;
								
		parent::send($user->nome, $user->email, $msgTitle, $msgSubTitle, $msgBody, $subject);
	}
	
}