<?php
class Application{
    private $controller;
    private $action;
    private $params;

    public function __construct(){

    }

    /**
     * Recebe os dados via GET ou POST e seta em seus respectivos atributos
     * @return void
     */
    public function loadRoute(){
        $this->controller   = (!empty($_REQUEST['controller'])) ? ucfirst($_REQUEST['controller']) : 'Default';
        $this->action       = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : 'index';
        $this->params       = (!empty($_REQUEST['params'])) ? $_REQUEST['params'] : null;

        $this->controller   = "{$this->controller}Controller";
        $this->action       = "{$this->action}Action";
    }
  
    /**
    *
    * Instancia a classe referente ao Controlador (Controller) e executa
    * método referente a acao (Action)
    * @throws Exception
    */
    public function init(){
        $this->loadRoute();

        // Verifica se o controller existe
        if (class_exists($this->controller)){
            try{
                $objController = new $this->controller();
                // verifica se a action existe no Controller
                if (method_exists($objController, $this->action)){
                    if (!empty($this->params)){
                        $objController->{$this->action}($this->params);    
                    }else{
                        $objController->{$this->action}();    
                    }
                }
            }catch (Exception $e){
                return "ERROR: {$e->getMessage()}";
            }
        }else{
            throw new Exception("Arquivo /desafioEAD/controllers/{$this->controller}.php não encontrado!");
        }
    }
  
    /**
    * Redireciona a chamada http para outra página
    * @param string $url
    */
    static function redirect( $url ){
        return "<script>window.location.href = '".URL.$url."';</script>";
    }
}
?>