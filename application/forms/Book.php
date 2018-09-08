<?php

class Application_Form_Book extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

  // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an name element
        $this->addElement('text', 'name', array(
            'label'      => 'Name:',
            'required'   => true,
            'filters'    =>array('StripTags'),
            'filters'    => array('StringTrim'),

            )
        );

        // Add the category element
        $this->addElement('text', 'category', array(
            'label'      => 'category:',
            'required'   => true,
            'filters'    =>array('StripTags'),
            'filters'    => array('StringTrim'),
        ));

        // Add  author text
        $this->addElement('text', 'author', array(
            'label'      => 'Author:',
            'required'   => true,
            'filters'    =>array('StripTags'),
            'filters'    => array('StringTrim'),
            )
        );
        // Add price element
        $this->addElement('text', 'price', array(
                'label'      => 'Price:',
                'required'   => true,
                'filters'    =>array('Int'),

                )

        );

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Enter Book Details',

        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }






}

