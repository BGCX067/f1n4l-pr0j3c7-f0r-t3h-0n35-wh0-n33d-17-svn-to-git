<?php

class admin_Form_Combo extends Zend_Form {

    public function init() {
		
		$produtoModel = new Application_Model_Produto();

        $produtos = $produtoModel->fetchAll(
                                $produtoModel->select()
                                ->from($produtoModel->info(Zend_Db_Table_Abstract::NAME))
                                ->columns(array('id_produto','nome'))
        );
        $produtosArr = array();
		$produtosArr[0] = 'nenhum';

        foreach ($produtos as $produto) {
            $produtosArr[$produto['id_produto']] = $produto['nome'];
        }
        $this->addElement(
                'select',
                'id_produto1',
                array(
                    'label' => 'Produto 1: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $produtosArr,
                    'registerInArrayValidator' => false
                )
        );
		
		$this->addElement(
                'select',
                'id_produto2',
                array(
                    'label' => 'Produto 2: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $produtosArr,
                    'registerInArrayValidator' => false
                )
        );
		
		$this->addElement(
                'select',
                'id_produto3',
                array(
                    'label' => 'Produto 3: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $produtosArr,
                    'registerInArrayValidator' => false
                )
        );
		
		$this->addElement(
                'select',
                'id_produto4',
                array(
                    'label' => 'Produto 4: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $produtosArr,
                    'registerInArrayValidator' => false
                )
        );
		
		$this->addElement(
                'select',
                'id_produto5',
                array(
                    'label' => 'Produto 5: ',
					'class' => 'campo-txt',
                    'multiple' => false,
                    'multiOptions' => $produtosArr,
                    'registerInArrayValidator' => false
                )
        );

		$this->addElement(
                'text',
                'preco',
                array(
                    'label' => 'Preço*',
					'class' => 'campo-txt',
					'required' => true
                )
        );

        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Salvar',
					'class' => 'bt-enviar',
                    'ignore' => true
                )
        );
    }

}

