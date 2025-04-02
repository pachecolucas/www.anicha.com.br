<?

class Eliti_Uploader {

    /**
     * @var Eliti_Exception
     */
    protected $elitiException;
    protected $formInputName;
    protected $maxSize;
    //relativo a pasta public_html (DOCUMENT_ROOT)
    protected $path;
    private $fullPath;
    protected $file;
    protected $validExtentions = array();
    private $name;
    private $extension;

    public function __construct(array $config) {
        // Verifica se Eliti_Exception foi informado
        if (!isset($config["elitiException"]) || !($config["elitiException"] instanceof Eliti_Exception)) {
            throw new Exception("Eliti_Uploader::_construct() - objeto Eliti_Exception não localizado em 'elitiException'.");
        }
        $this->elitiException = $config["elitiException"];

        // Verifica se formInputName foi informado
        if (!array_key_exists("formInputName", $config)) {
            throw new Exception("Eliti_Uploader::_construct() - faltou informar 'formInputName'.");
        }
        $this->formInputName = $config["formInputName"];
        
        // Verifica se maxSize foi informado
        if (!array_key_exists("maxSize", $config)) {
            throw new Exception("Eliti_Uploader::_construct() - faltou informar 'maxSize'.");
        }
        $this->maxSize = $config["maxSize"] * 1024 * 1024; // Converte para KB

        // Verifica se path foi informado
        if (!array_key_exists("path", $config)) {
            throw new Exception("Eliti_Uploader::_construct() - faltou informar 'path'.");
        }
        $this->path = "/" . trim($config["path"], "/") . "/";

        // Define fullPath
        $this->fullPath = $_SERVER['DOCUMENT_ROOT'] . $this->path;

        // Verifica se fullPath existe
        if (!is_dir($this->fullPath)) {
            throw new Exception("Eliti_Uploader::_construct() - 'path' informado (".$this->path.") não existe. (" . $this->fullPath . ")");
        }

        // Verifica se informou arquivo
        if (!array_key_exists("file", $config)) {
            throw new Exception("Eliti_Uploader::_construct() - faltou informar 'file'.");
        }

        // Verifica se Arquivo existe
        if (!isset($config["file"]["tmp_name"])) {
            $this->elitiException->addError($this->formInputName, "Escolha um Arquivo.");
        } else {
            $this->file = $config["file"];
            
            // Verifica tamanho máximo aceito do arquivo
            $this->validSize();

            // Se há extensão para validar, então valida
            $this->setExtension();
            if (isset($config["validExtentions"])) {
                // verifica se as extensões válidas foram informadas em formato de array
                if (!is_array($config["validExtentions"])) {
                    throw new Exception("Eliti_Uploader::_construct() - 'validExtentions' deve ser um array.");
                }
                $this->validExtentions = $config["validExtentions"];
                $this->validExtension();
            }
        }

        // Define nome do arquivo
        $this->setName();
        while (is_file($this->getName())) {
            $this->setName();
        }
    }
    
    public function validSize() {
        if($this->file["size"] > $this->maxSize) {
            $this->elitiException->addError($this->formInputName, "Arquivo deve ter, no máximo, ".$this->bytesToMB($this->maxSize)."MB. Este arquivo possui ".$this->bytesToMB($this->file["size"])."MB.");
        }
    }

    public function setExtension($extension = null) {
        $this->extension = $extension;
        if (!$this->extension) {
            $arrayNome = explode('.', $this->file['name']);
            $this->extension = strtolower(end($arrayNome));
        }
    }
    
    public function validExtension() {
        if (array_search($this->getExtension(), $this->validExtentions) === false) {
            $this->elitiException->addError($this->formInputName, "Arquivo deve ser do tipo: " . implode(", ", $this->validExtentions) . ".");
        }
    }

    public function getExtension() {
        return $this->extension;
    }

    public function setName($name = null) {
        $this->name = $name ? $name : $this->getUniqueName();
    }

    public function getName() {
        return $this->name;
    }
    
    public function getFullName() {
        return $this->name . "." . $this->extension;
    }

    public function getUrl() {
        return $this->path . $this->getFullName();
    }

    public function getFile() {
        return $this->fullPath . $this->getFullName();
    }

    protected function getUniqueName() {
        return rand(0, 10000) . "-" . time();
    }

    public function save() {
        // Depois verifica se é possível mover o arquivo para a pasta escolhida
        if (!move_uploaded_file($this->file['tmp_name'], $this->getFile())) {
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            throw new Exception("Não foi possível enviar o arquivo, tente novamente");
        }
    }
    
    protected function bytesToMB($bytes) {
        $MB = $bytes / 1024 / 1024;
        return number_format($MB, 1, ",", ".");
    }

}
