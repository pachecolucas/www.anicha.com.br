<?
// Utilizando o PHP Thumb...
require_once 'ThumbLib.inc.php';

class Eliti_Uploader_Image extends Eliti_Uploader {
    
    const TYPE_JPG = "image/jpeg";
    const TYPE_GIF = "image/gif";
    const TYPE_PNG = "image/png";

    protected $minWidth;
    protected $minHeight;
    
    protected $image;

    public function __construct(array $config) {
        parent::__construct($config);
        
        if(!$this->elitiException->hasErrors()) {
            // Se informou minWidth, então valida
            if (isset($config["minWidth"])) {
                $this->minWidth = $config["minWidth"];
                $this->validMinWidth();
            }

            // Se informou minHeight, então valida
            if (isset($config["minHeight"])) {
                $this->minHeight = $config["minHeight"];
                $this->validMinHeight();
            }
        }
        
    }
    
    public function validMinWidth() {
        $tamanhos = getimagesize($this->file["tmp_name"]);
        if ($tamanhos[0] < $this->minWidth) {
            $this->elitiException->addError($this->formInputName, "Imagem deve ter uma largura mínima de " . $this->minWidth . "px. Esta possui apenas ".$tamanhos[0]."px.");
        }
    }
    
    public function validMinHeight() {
        $tamanhos = getimagesize($this->file["tmp_name"]);
        if ($tamanhos[1] < $this->minHeight) {
            $this->elitiException->addError($this->formInputName, "Imagem deve ter uma altura mínima de " . $this->minHeight . "px. Esta possui apenas ".$tamanhos[1]."px.");
        }
    }

    public function slice($width, $height) {
        $this->getImage()->adaptiveResize($width, $height);
    }
    
    public function save() {
        $this->getImage()->save($this->getFile());
    }

    public function saveAs($format = self::TYPE_JPG) {
        switch ($format) {
            case self::TYPE_PNG:
                $this->setExtension("png");
                $this->getImage()->save($this->getFile(), "png");
                break;
            case self::TYPE_GIF:
                $this->setExtension("gif");
                $this->getImage()->save($this->getFile(), "gif");
                break;
            case self::TYPE_JPG:
                $this->setExtension("jpg");
                $this->getImage()->save($this->getFile(), "jpg");
                break;
            default:
                throw new Exception("Eliti_Uploader_Image::savaAs() - formato inválido ($format) selecionado.");
        }
        
    }
    
    public function getBlob() {
        if(!file_exists($this->getFile())) {
            $this->save();
        }
        $file = $this->getFile();
        // ABRE ARQUIVO
        $ponteiro = fopen($file, "rb");
        // PERCORRE O ARQUIVO
        $blob = addslashes(fread($ponteiro, filesize($file)));
        unlink($file);
        return $blob;
    }
    
    protected function getImage() {
        if ($this->image) {
            return $this->image;
        }
        $this->image = PhpThumbFactory::create($this->file["tmp_name"], array("jpegQuality"=> 90));
        return $this->image;
    }

}