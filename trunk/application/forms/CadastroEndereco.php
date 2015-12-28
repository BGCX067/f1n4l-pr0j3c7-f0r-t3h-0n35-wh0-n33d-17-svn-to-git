<?php

class Application_Form_CadastroEndereco extends Zend_Form {

    public function init() {
        $this->addElement(
                'text',
                'rua',
                array(
                    'label' => 'Rua*',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'cidade',
                array(
                    'label' => 'Cidade*',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'bairro',
                array(
                    'label' => 'Bairro*',
                    'required' => true,
                )
        );

        $this->addElement(
                'text',
                'numero',
                array(
                    'label' => 'Numero*',
                    'required' => true,
					'validators' => array(
                        new Zend_Validate_Int()
                ))
        );

        $this->addElement(
                'text',
                'complemento',
                array(
                    'label' => 'Complemento: '
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
