<?php

class Admin_CategoriaController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
        $categoriaModel = new Application_Model_Categoria();

        $this->view->categoria = $categoriaModel->fetchAll(
                        $categoriaModel->select()->where('excluido = 0')
        );

        $busca = $this->_request->getParam('busca');
    }    

    public function adicionarAction(){

	    require_once APPLICATION_PATH . '/modules/admin/forms/Categoria.php';
        $this->view->form = new admin_Form_Categoria();

        $categoriaModel = new Application_Model_Categoria();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $id = $categoriaModel->insert($data);

                return $this->_helper->redirector('index');
            }
        }
    }
    public function removerAction() {
        $id = $this->_request->getParam('id');

        $categoriaModel = new Application_Model_Categoria();

        $categoriaModel->update(array(
            'excluido' => '1'
                ), 'id_categoria = ' . $id);

        return $this->_helper->redirector('index');
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Categoria.php';
        $this->view->form = new admin_Form_Categoria();

        $categoriaModel = new Application_Model_Categoria();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $categoriaModel->update($data, 'id_categoria = ' . $id);

                return $this->_helper->redirector('index');
            }
        }

        $categoria = $categoriaModel->find($id)->current();

        $this->view->form->setDefaults($categoria->toArray());
    }
    
}

