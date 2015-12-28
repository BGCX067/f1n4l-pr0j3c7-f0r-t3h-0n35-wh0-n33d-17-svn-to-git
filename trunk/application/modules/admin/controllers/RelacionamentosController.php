<?php

class Admin_RelacionamentosController extends Zend_Controller_Action
{

    public function init(){
        /* Initialize action controller here */
    }

    public function indexAction(){
        $busca = $this->_request->getParam('id');

        $ingredienteModel = new Application_Model_Ingrediente();
		        $nome_ingrediente = $ingredienteModel->fetchAll(
                                    $ingredienteModel->select()
                                		->from($ingredienteModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_ingrediente'))
										->where('id_ingrediente like :busca')
										->bind(array(
										'busca' => '%' . $busca . '%'
										))
                                    );
		$this->view->nome_ingrediente = $nome_ingrediente[0]['nome_ingrediente'];

        $relacionamentosModel = new Application_Model_Relacionamentos();

		
        $this->view->relacionamento = $relacionamentosModel->fetchAll(
                        $relacionamentosModel->select()->where('excluido = 0')
														->where('id_ingrediente = ?', $busca)

        );

    }    

    public function adicionarAction(){

	    require_once APPLICATION_PATH . '/modules/admin/forms/Relacionamento.php';
        $this->view->form = new admin_Form_Relacionamento();

        $id = $this->_request->getParam('id');

        $relacionamentosModel = new Application_Model_Relacionamentos();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {
				$idx = $this->_request->getParam('id');

				$data['id_ingrediente'] = $idx;
                $id = $relacionamentosModel->insert($data);

                return $this->_helper->redirector('index');
            }
        }
    }
    public function removerAction() {
        $id = $this->_request->getParam('id');

        $relacionamentosModel = new Application_Model_Relacionamentos();

        $relacionamentosModel->update(array(
            'excluido' => '1'
                ), 'id_ingrediente_idx = ' . $id);

        return $this->_helper->redirector('index');
    }
	
	public function editarAction() {
        $id = $this->_request->getParam('id');

        require_once APPLICATION_PATH . '/modules/admin/forms/Relacionamento.php';
        $this->view->form = new admin_Form_Relacionamento();

        $relacionamentosModel = new Application_Model_Relacionamentos();

        if ($this->_request->isPost()) {

            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            if ($this->view->form->isValid($data)) {

                $relacionamentosModel->update($data, 'id_ingrediente_idx = ' . $id);

                return $this->_helper->redirector('index');
            }
        }

        $relacionamento = $relacionamentosModel->find($id)->current();

        $this->view->form->setDefaults($relacionamento->toArray());
    }
    
}

