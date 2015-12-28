<?php

class NovidadesController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Novidades');
		
        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;
        
		$noticiaModel = new Application_Model_Novidades();

        $this->view->noticia = $noticiaModel->fetchAll(
                        $noticiaModel->select()->where('excluido = 0')
        );

        $busca = $this->_request->getParam('busca');
    }


}

