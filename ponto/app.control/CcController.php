<?php


class CcController extends Controller {

    private $view;
    private $model;

    public function __construct(){
        // instanciamos os objetos
        $this->model = new Cc();
        //$this->view = new View('apropriar.html');
    }

    public function getCC(){
        echo $this->model->getCc($_GET['cc']);
    }

}    
?>
