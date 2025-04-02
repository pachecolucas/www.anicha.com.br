<?php

class Zend_View_Helper_Locale extends Zend_View_Helper_Abstract {

    private static $TS = array(
        LocaleController::es => array(
            "Cancelar" => "Cancelar",
            "Voltar" => "Volver",
            "Salvar" => "Guardar",
            "Aguarde" => "Espere",
            "Entrar" => "Entrar",
            "Esqueceu sua senha?" => "¿Olvidó su contraseña?",
            "Senha" => "Contraseña",
        ),
        LocaleController::en => array(
            "Cancelar" => "Cancel",
            "Voltar" => "Back",
            "Salvar" => "Save",
            "Aguarde" => "Wait",
            "Entrar" => "Login",
            "Esqueceu sua senha?" => "Forgot your password?",
            "Senha" => "Password",
        ),
    );

    public function locale($string) {
//        if (LOCALE === LocaleController::es || LOCALE === LocaleController::en) {
//            return self::$TS[LOCALE][$string];
//        }
        return $string;
    }

}
