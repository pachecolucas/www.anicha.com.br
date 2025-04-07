<?php

/**
 * Destruir sessão
 */
//session_start();
//print_r($_SESSION);
//unset($_SESSION["Eliti_Backend_Session"]);
//unset($_SESSION["Eliti_Session"]);
//die;

/**
 * Exibir erros
 */
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", "on");

/**
 * Set timezone
 */
date_default_timezone_set("America/Sao_Paulo");

/**
 * Variáveis globais importantes
 */
define("EF_EXIBIR", 10); // número de itens que serão listados
define("PUBLIC_PATH", $_SERVER['DOCUMENT_ROOT']); // public_html
define("BACKEND_PATH", PUBLIC_PATH . "/../application/backend"); // models
define("FRONTEND_PATH", PUBLIC_PATH . "/../application/frontend"); // modules
define("LIBRARY_PATH", PUBLIC_PATH . "/../library"); // zend, eliti, etc...
define("SITE", "http://anicha.com.br"); // mudar quando publicado
define("SITENAME", "Anicha");
define("MODULE_ADMIN", "epanel");
define("TELEFONE", "(47) 99977-0213");
define("EMAIL", "nilma@anicha.com.br");

/**
 * Onde buscar os arquivos
 */
set_include_path(
// LUCAS MACBOOK
        LIBRARY_PATH . "/zend-1.11.11" . PATH_SEPARATOR .
        LIBRARY_PATH . "/eliti-0.9.0" . PATH_SEPARATOR .
        LIBRARY_PATH . "/phpthumb-latest" . PATH_SEPARATOR .
        LIBRARY_PATH . "/PHPMailer_5.2.7" . PATH_SEPARATOR .
        LIBRARY_PATH . "/fpdf17" . PATH_SEPARATOR .
        BACKEND_PATH . PATH_SEPARATOR .
        get_include_path()
);

try {
    /**
     * Carrega o Zend e mandar ele trabalhar...
     */
// 1. O Zend_Loader_Autoloader é utilizado para carregar os arquivos com base no nome deles partindo dos diretórios acima setados no Path
    require_once "Zend/Loader/Autoloader.php";
    Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

// 2. Dá início ao suporte MVC
    Zend_Layout::startMvc();

// 3. Inícia o Zend_Controller_Front que atenderá a todas as requisições do cliente
    $front = Zend_Controller_Front::getInstance();
    $front->addModuleDirectory(FRONTEND_PATH); // trabalhar com múltiplos modules (default, epanel, etc...)
// 4. Adiciona um Controller Plugin para controlar o idioma
//require_once FRONTEND_PATH . "/user/controllers/plugins/LocaleController.php";
//$front->registerPlugin(new LocaleController());
// 5. Adiciona um Controller Plugin para controlar o acesso
//require_once FRONTEND_PATH . "/user/controllers/plugins/AccessController.php";
//$front->registerPlugin(new AccessController());
// 6. Informa quais modules atendem a solicitações REST
//$restRoute = new Zend_Rest_Route($front, array(), array("poa-vidros"));
//$front->getRouter()->addRoute('rest', $restRoute);
// 7. Manda o Zend_Controller_Front mostrar erros
    $front->throwExceptions(true);

// 8. Manda o Zend_Controller_Front atender a solicitação (/module/controller/action)
    $front->dispatch();
} catch (Zend_Controller_Dispatcher_Exception $e) {
    $front->setParam('useDefaultControllerAlways', true);
    $front->dispatch();
}


