<?php

class CardapioController extends Zend_Controller_Action{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $this->view->headTitle('Cardápio');
        
		$sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');
		
		if (isset($sessao->produtos) && sizeof($sessao->produtos) > 0) {
			foreach($sessao->produtos as $produto => $quantidade){
				for($i = 0;$i < $quantidade;$i++){
					$produtos[] = $produto;
				}
			}
			$this->view->carro = $produtos;
		}
		
        $categoriaModel = new Application_Model_Categoria();

        $nome_categorias = $categoriaModel->fetchAll(
                                    $categoriaModel->select()
                                		->from($categoriaModel->info(Zend_Db_Table_Abstract::NAME))
                                		->columns(array('nome_categoria'))
                                    );
		$this->view->categorias = $nome_categorias;

		$busca = $this->_request->getParam('categoria');
		$this->view->cat = $busca;
		
		if($busca == 'Combos'){
			$comboModel = new Application_Model_Combo();

			$this->view->produto = $comboModel->fetchAll(
							$comboModel->select()->where('excluido = 0')
			);
		
		}else{
			$produtoModel = new Application_Model_Produto();

			$this->view->produto = $produtoModel->fetchAll(
							$produtoModel->select()->where('excluido = 0')
										  ->where('categoria LIKE :busca')
										  ->bind(array(
											'busca' => '%' . $busca . '%'
										))
			);
		}
        $produto = $this->_request->getParam('produto');
        
    }

        public function visualizarAction() {
		$this->_helper->layout()->disableLayout();
        $busca = $this->_request->getParam('id');

        $produtoModel = new Application_Model_Produto();

            $this->view->produto = $produtoModel->fetchAll(
                                    $produtoModel->select()
                                    ->where('id_produto LIKE :busca')
                                    ->where('excluido = 0')
                                    ->bind(array(
                                        'busca' => '%' . $busca . '%'
                                    ))
            );
        }

        public function detalhesAction() {
        $busca = $this->_request->getParam('id');

        $produtoModel = new Application_Model_Produto();

            $this->view->produto = $produtoModel->fetchAll(
                                    $produtoModel->select()
                                    ->where('id_produto LIKE :busca')
                                    ->where('excluido = 0')
                                    ->bind(array(
                                        'busca' => '%' . $busca . '%'
                                    ))
            );
        }

		public function adicionarAction() {
        $id = $this->_request->getParam('id');

        $sessao = new Zend_Session_Namespace('SESSAO_CARRINHO');

        if (!isset($sessao->produtos)) {
            $sessao->produtos = array();
        }

        $sessao->produtos[] = $id;

        return $this->_helper->redirector('index');
		}

    }
   

