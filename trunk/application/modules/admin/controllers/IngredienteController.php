<?php

class Admin_IngredienteController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){

		$ingredienteModel = new Application_Model_Ingrediente();

        $this->view->ingrediente = $ingredienteModel->fetchAll(
                        $ingredienteModel->select()->where('excluido = 0')
        );

        $busca = $this->_request->getParam('busca');

    }
    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Ingrediente.php';
        $this->view->form = new admin_Form_Ingrediente();

        if ($this->_request->isPost()) {
			
            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $ingredienteModel = new Application_Model_Ingrediente();

                $id = $ingredienteModel->insert($data);

                return $this->_helper->redirector('index');
            }
        }
    }
	
	public function removerAction() {
        $id = $this->_request->getParam('id');

        $ingredienteModel = new Application_Model_Ingrediente();

        $ingredienteModel->update(array(
            'excluido' => '1'
                ), 'id_ingrediente = ' . $id);

        return $this->_helper->redirector('index');
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Ingrediente.php';
        $this->view->form = new admin_Form_Ingrediente();

        $ingredienteModel = new Application_Model_Ingrediente();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $ingredienteModel->update($data, 'id_ingrediente = ' . $id);

                return $this->_helper->redirector('index');
            }
        }

        $ingrediente = $ingredienteModel->find($id)->current();

        $this->view->form->setDefaults($ingrediente->toArray());
    }

}

