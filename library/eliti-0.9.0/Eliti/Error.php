<?

class Eliti_Error  {
    
    public $key;
    public $message;
    
    public function __construct($key, $message) {
        $this->key = $key;
        $this->message = $message;
    }

}
