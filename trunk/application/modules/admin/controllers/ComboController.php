<?php

class Admin_ComboController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){

		$comboModel = new Application_Model_Combo();

        $this->view->combo = $comboModel->fetchAll(
                        $comboModel->select()->where('excluido = 0')
        );

        $busca = $this->_request->getParam('busca');
    }
    public function adicionarAction() {
        require_once APPLICATION_PATH . '/modules/admin/forms/Combo.php';
        $this->view->form = new admin_Form_Combo();

        if ($this->_request->isPost()) {
			
            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $comboModel = new Application_Model_Combo();

                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);

                $id = $comboModel->insert($data);

                return $this->_helper->redirector('index');
            }
        }
    }
	
	public function removerAction() {
        $id = $this->_request->getParam('id');

        $comboModel = new Application_Model_Combo();

        $comboModel->update(array(
            'excluido' => '1'
                ), 'id_combo = ' . $id);
				
        return $this->_helper->redirector('index');
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Combo.php';
        $this->view->form = new admin_Form_Combo();

        $comboModel = new Application_Model_Combo();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $data['preco'] = str_replace(array(',', '.'), '', $data['preco']);

                $comboModel->update($data, 'id_combo = ' . $id);

                return $this->_helper->redirector('index');
            }
        }

        $combo = $comboModel->find($id)->current();

        $this->view->form->setDefaults($combo->toArray());
    }

}

