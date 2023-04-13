<?php
class indexController extends Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(Sesion::get('autenticado')){
            $this->view->rendering('index');
            $this->view->template='admin';
        }else{
            $this->view->template='main';
            $this->view->rendering('index');
        }
    }
}
?>