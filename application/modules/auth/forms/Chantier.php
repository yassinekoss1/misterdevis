<?php


class Auth_Form_Chantier extends Auth_Form_Base {

  /**
   * @throws \Zend_Form_Exception
   */
  public function init() {

    $default_filters = [
      'StringToLower',
      'StringTrim',
      'StripTags',
    ];

    $select_filters = ['StripTags'];


    // adresse
    $adresse = new Zend_Form_Element_Text('adresse');
    $adresse->setLabel('Adresse')
      ->setBelongsTo('Chantier')
      ->setRequired(true)
      ->addFilters($default_filters);

    // adresse2
    $adresse2 = new Zend_Form_Element_Text('adresse2');
    $adresse2->setLabel('Adresse2')
      ->setBelongsTo('Chantier')
      ->addFilters($default_filters);

    // ville
    $ville = new Zend_Form_Element_Text('ville');
    $ville->setLabel('Ville')
      ->setBelongsTo('Chantier')
      ->setRequired(true)
      ->addFilters($default_filters);

    // code_postal
    $code_postal = new Zend_Form_Element_Text('code_postal');
    $code_postal->setLabel('Code postal')
      ->setBelongsTo('Chantier')
      ->setRequired(true)
      ->addFilters($default_filters);


    // id_zone
    $id_zone = new Zend_Form_Element_Select('id_zone');
    $id_zone->setLabel('Zone')
      ->setBelongsTo('Chantier');


    // Submit button
    $submit = new Zend_Form_Element_Submit('submit');
    $submit->setLabel('Envoyer')
      ->setAttribs(['class' => 'btn btn-primary btn-block']);

    $this->addElements([
      $adresse,
      $adresse2,
      $ville,
      $code_postal,
      $id_zone,
      $submit,
    ]);

    parent::init();

  }

}
