<?php

class LocaleController extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

//        $this->getResponse()->appendBody("<hr><a href='?ef-locale=pt'>Português</a>|<a href='?ef-locale=es'>Español</a>|<a href='?ef-locale=en'>English</a>|<a href='?ef-locale=fr'>Francais</a>|<a href='?ef-locale=it'>Italiano</a><hr>");
//        $this->getResponse()->appendBody("<hr><b>LocaleController:</b><br>");
        Eliti::getInstance()->clearLocale();
        /**
         * N1: Solicitado (tem que estar na url)
         * N2: Usuário (locale indefinido, estar logado, possuir locale)
         * N3: Browser (locale indefinido)
         */
        // N1...
        $locale = $this->getParamLocale($request);
        if ($locale) {
//            $this->getResponse()->appendBody("<b>N1: SOLICITADO</b><br>");
//            $this->getResponse()->appendBody("Usuário informou locale explicitamente: $locale<br>");
            $idLocale = array_search($locale, User_Entity_Locale::$LOCALES);
            $idLocale ? Eliti::getInstance()->setLocale($idLocale) : null;
        }
        // N2...
        if (!Eliti::getInstance()->hasLocale() && Eliti::getInstance()->hasUser() && Eliti::getInstance()->getUser()->getLocale()) {
//            $this->getResponse()->appendBody("<b>N2: USUÁRIO</b><br>");
//            $this->getResponse()->appendBody("Encontrado locale do Usuário<br>");
            $this->setLocaleByUser();
        }
        // N3...
        if (!Eliti::getInstance()->hasLocale()) {
//            $this->getResponse()->appendBody("<b>N3: BROWSER</b><br>");
//            $this->getResponse()->appendBody($_SERVER["HTTP_ACCEPT_LANGUAGE"] . "<br>");
            $this->setLocaleByBrowser();
        }
        define("LOCALE", Eliti::getInstance()->getLocale());
//        $this->getResponse()->appendBody("LOCALE definido para: " . LOCALE . "<br>");
    }

    private function setLocaleByUser() {
        $locale = Eliti::getInstance()->getUser()->getLocale();
        Eliti::getInstance()->setLocale($locale);
    }

    private function setLocaleByBrowser() {
        $httpAcceptLanguage = array_key_exists("HTTP_ACCEPT_LANGUAGE", $_SERVER) ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : "";
        if (strpos($httpAcceptLanguage, "pt") !== false) {
//            $this->getResponse()->appendBody("Browser do usuário aceita português.<br>");
            Eliti::getInstance()->setLocale(User_Entity_Locale::PT);
        } else if (strpos($httpAcceptLanguage, "es") !== false) {
//            $this->getResponse()->appendBody("Browser do usuário aceita espanhol.<br>");
            Eliti::getInstance()->setLocale(User_Entity_Locale::ES);
        } else if (strpos($httpAcceptLanguage, "fr") !== false) {
//            $this->getResponse()->appendBody("Browser do usuário aceita francês.<br>");
            Eliti::getInstance()->setLocale(User_Entity_Locale::FR);
        } else if (strpos($httpAcceptLanguage, "it") !== false) {
//            $this->getResponse()->appendBody("Browser do usuário aceita italiano.<br>");
            Eliti::getInstance()->setLocale(User_Entity_Locale::IT);
        } else {
//            $this->getResponse()->appendBody("Browser do usuário não aceita português, espanhol, francês nem italiano!<br>");
            Eliti::getInstance()->setLocale(User_Entity_Locale::EN);
        }
    }

    public static function isValidLocale($locale) {
        return array_key_exists($locale, self::$LOCALES);
    }

    private function getParamLocale(Zend_Controller_Request_Abstract $request) {
        $locale = $request->getParam("ef-locale");
        if (in_array($locale, User_Entity_Locale::$LOCALES)) {
            return $locale;
        }
        // locale inválido, retorna português
        return null;
    }

}
