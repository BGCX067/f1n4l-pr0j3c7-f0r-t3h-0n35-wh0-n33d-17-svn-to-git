﻿<?php

class admin_Form_Relacionamento extends Zend_Form {

    public function init() {

        $produtoModel = new Application_Model_Produto();

        $produto = $produtoModel->fetchAll(
                                $produtoModel->select()
                                ->from($produtoModel->info(Zend_Db_Table_Abstract::NAME))
                                ->columns(array('id_produto', 'nome'))
        );
        $produtoArr = array();

        foreach ($produto as $produto) {
            $produtoArr[$produto['id_produto']] = $produto['nome'];
        }
        $this->addElement(
                'select',
                'id_produto',
                array(
                    'label' => 'Produto: ',
                    'multiple' => false,
                    'multiOptions' => $produtoArr,
                    'registerInArrayValidator' => false
                )
        );

	      $this->addElement(
                'checkbox',
                'opcional',
                array(
                    'label' => 'Opcional?',
                    'checkedValue' => 1,
                    'uncheckedValue' => 0,
                )
        );

		$this->addElement(
                'checkbox',
                'adicional',
                array(
                    'label' => 'Adicional?',
                    'checkedValue' => 1,
                    'uncheckedValue' => 0,
                )
        );

        $this->addElement(
                'text',
                'qtd_padrao',
                array(
                    'label' => 'Quantidade Padrão',
                    'required' => true
                    
                )
        );

        $this->addElement(
                'text',
                'qtd_max',
                array(
                    'label' => 'Quantidade Máxima',
                    'required' => true
                    
                )
        );
		
        $this->addElement(
                'text',
                'qtd_min',
                array(
                    'label' => 'Quantidade Mínima',
                    'required' => true
                    
                )
        );

		$this->addElement(
                'text',
                'valor',
                array(
                    'label' => 'Valor',
					'class' => 'campo-txt'
                    
                )
        );
		
        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Salvar',
                    'ignore' => true
                )
        );
    }

}

