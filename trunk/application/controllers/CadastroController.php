<?php

class CadastroController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        require_once APPLICATION_PATH . '/forms/Cadastro.php';
        $this->view->form = new Application_Form_Cadastro();

        if ($this->_request->isPost()) {
            $this->view->form->setDefaults($this->_request->getPost());

            $data = $this->view->form->getValues();

            $usuarioModel = new Application_Model_Usuario();
            $contatoModel = new Application_Model_Contato();
            $enderecoModel = new Application_Model_Endereco();

            if ($this->view->form->isValid($data)) {
                $data['tipo'] = 'cliente';

                $data['senha'] = md5($data['senha']);

                unset($data['repita_senha']);

                $id = $usuarioModel->insert($data);
				$usuario = array();
				$usuario['usuario'] = $data['usuario'];
                $id2 = $contatoModel->insert($usuario);
                $id3 = $enderecoModel->insert($usuario);

                return $this->_helper->redirector('editar', 'cadastro');
            }
        }
    }
	
    public function contatoAction() {
		Zend_Loader::loadClass('Zend_Auth');
		$authClass = Zend_Auth::getInstance();

		if ($authClass->hasIdentity()) {
			$auth = $authClass->getStorage()->read();

			$user = $auth['usuario_id'];

			$usuarioModel = new Application_Model_Usuario();

			$usuario = $usuarioModel->find($user)->current();

			require_once APPLICATION_PATH . '/forms/CadastroContato.php';
			$this->view->form = new Application_Form_CadastroContato();

			if ($this->_request->isPost()) {
				$this->view->form->setDefaults($this->_request->getPost());

				$data = $this->view->form->getValues();

				$contatoModel = new Application_Model_Contato();

				$user = $usuario['usuario'];
				if ($this->view->form->isValid($data)) {
					$row = $contatoModel->fetchRow($contatoModel->select()->where('usuario = ?', $user));
					$row->dt_nasc = $data['dt_nasc'];
					$row->telefone = $data['telefone'];
					$row->email = $data['email'];
					$row->completo = 1;
					$row->save();

					return $this->_helper->redirector('editar', 'cadastro');
				}
			}
			$user = $usuario['usuario'];
			$contatoModel = new Application_Model_Contato();
			$row = $contatoModel->fetchRow($contatoModel->select()->where('usuario = ?', $user));
			$this->view->form->setDefaults($row->toArray());
		}
    }	
	
    public function enderecoAction() {
	
		Zend_Loader::loadClass('Zend_Auth');
		$authClass = Zend_Auth::getInstance();

		if ($authClass->hasIdentity()) {
			$auth = $authClass->getStorage()->read();

			$user = $auth['usuario_id'];

			$usuarioModel = new Application_Model_Usuario();

			$usuario = $usuarioModel->find($user)->current();

			require_once APPLICATION_PATH . '/forms/CadastroEndereco.php';
			$this->view->form = new Application_Form_CadastroEndereco();

			if ($this->_request->isPost()) {
				$this->view->form->setDefaults($this->_request->getPost());

				$data = $this->view->form->getValues();

				$enderecoModel = new Application_Model_Endereco();

				$user = $usuario['usuario'];
				if ($this->view->form->isValid($data)) {
					$row = $enderecoModel->fetchRow($enderecoModel->select()->where('usuario = ?', $user));
					$row->rua = $data['rua'];
					$row->cidade = $data['cidade'];
					$row->bairro = $data['bairro'];
					$row->numero = $data['numero'];
					$row->complemento = $data['complemento'];
					$row->latitude = '0';
					$row->longitude = '0';
					$row->completo = 1;
					$row->save();
					return $this->_helper->redirector('editar', 'cadastro');
				}
			}
			$user = $usuario['usuario'];
			$enderecoModel = new Application_Model_Endereco();
			$row = $enderecoModel->fetchRow($enderecoModel->select()->where('usuario = ?', $user));
			$this->view->form->setDefaults($row->toArray());

		}		
    }

    public function editarAction() {

	Zend_Loader::loadClass('Zend_Auth');
	$authClass = Zend_Auth::getInstance();

		if ($authClass->hasIdentity()) {
			$auth = $authClass->getStorage()->read();

			$id = $auth['usuario_id'];

			$usuarioModel = new Application_Model_Usuario();

			$usuario = $usuarioModel->find($id)->current();
		}
		if (isset($usuario)){

			//$user = $usuario['usuario'];
			$user = $auth['usuario_id'];

			$enderecoModel = new Application_Model_Endereco();
			$row = $enderecoModel->fetchRow($enderecoModel->select()->where('usuario = ?', $user));
			if($row->completo = '0'){
				$this->view->endereco = '1';
			}else{
				$this->view->endereco = '0';			
			}

			$contatoModel = new Application_Model_Contato();
			$rowdois = $contatoModel->fetchRow($contatoModel->select()->where('usuario = ?', $user));
			if($rowdois->completo = '0'){
				$this->view->contato = '1';
			}else{
				$this->view->contato = '0';
			}
		}
    }
}

