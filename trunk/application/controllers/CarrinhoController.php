<?php

class CarrinhoController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Carrinho');

        $sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		if (!isset($sessao->produtos)) {
            $sessao->produtos = array();
        }
		
		foreach($_POST as $key=>$value)
		{
			$key=(int)str_replace('_cnt','',$key);
			$sessao->produtos[$key]=$value;
		}

		if (isset($sessao->produtos) && sizeof($sessao->produtos) > 0) {
			foreach($sessao->produtos as $chave => $id){
				$ingredientes[$id] = array();
				
				$ingredModel = new Application_Model_Relacionamentos();

				$dados = $ingredModel->fetchAll(
								$ingredModel->select()->where('excluido = 0')
											  ->where('id_produto LIKE :id')
											  ->bind(array(
												'id' => '%' . $id . '%'
											))
				);
				foreach($dados as $chave => $valor){
					$ingredientes[$id][] = $dados[$chave];
				}
			}
            $this->view->ingredientes = $ingredientes;
            $this->view->produtos = $sessao->produtos;
        }
		
		}
		
		public function removerAction() {
        $id = $this->_request->getParam('id');

        $sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

		unset($sessao->produtos[$id]);

        return $this->_helper->redirector('index');
    }
    }
   

