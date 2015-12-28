<?php

class Admin_ContatosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_request->getParam('respondida');
		$contatosModel = new Application_Model_Contatos();

		if (isset($id)){
        $this->view->contatos = $contatosModel->fetchAll(
                        $contatosModel->select()
						->where('respondida = ?', $id)
        );
		}else{
        $this->view->contatos = $contatosModel->fetchAll(
                        $contatosModel->select()
        );
		
		}
    }

    public function responderAction() {
        $id = $this->_request->getParam('id');
        $contatosModel = new Application_Model_Contatos();

        $row = $contatosModel->fetchRow($contatosModel->select()->where('id_msg = ?', $id));
        $row->respondida = 1;
        $row->save();
        $this->_helper->redirector('index');

    }
}

