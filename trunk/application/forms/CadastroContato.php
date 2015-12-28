<?php

class Application_Form_CadastroContato extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'dt_nasc',
                array(
                    'label' => 'Data de Nascimento (dd/mm/aaaa)*',
                    'required' => true,
					'maxlength' => '10',
                )
        );

        $this->addElement(
                'text',
                'telefone',
                array(
                    'label' => 'Telefone*',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'email',
                array(
                    'label' => 'E-mail*',
                    'required' => true,
                )
        );

	    $this->addElement(
                'checkbox',
                'news',
                array(
                    'label' => 'Desejo receber newsletter',
                    'checkedValue' => 1,
                    'uncheckedValue' => 0,
                )
        );		
		
        $this->addElement(
                'submit',
                'submit_button',
                array(
                    'label' => 'Enviar',
                    'ignore' => true
                )
        );
    }

}
