<?php


/**
 * Class Auth_Form_Artisan
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    02/01/18
 */
class Auth_Form_Artisan extends Auth_Form_Base {
  
  private $_qualification = [
    ''              => 'Veuillez préciser',
    'Non qualifiée' => 'Non qualifiée',
    'NRP'           => 'NRP',
    'Occupé'        => 'Occupé',
    'Qualifié'      => 'Qualifié',
    'Trop tard'     => 'Trop tard',
    'Rappel'        => 'Rappel',
  ];
  
  private $_activites = [
    '' => 'Veuillez préciser',
  ];
  
  
  /**
   * @throws \Zend_Form_Exception
   */
  public function init() {
    
    $default_filters = [
      'StringTrim',
      'StripTags',
    ];
    
    $select_filters = [ 'StripTags' ];
    
    // nom_artisan
    $nom_artisan = new Zend_Form_Element_Text( 'nom_artisan' );
    $nom_artisan->setLabel( 'Nom' )
                ->setRequired( true )
                ->setBelongsTo( 'Artisan' )
                ->addFilters( $default_filters );
    
    // prenom_artisan
    $prenom_artisan = new Zend_Form_Element_Text( 'prenom_artisan' );
    $prenom_artisan->setLabel( 'Prénom' )
                   ->setRequired( true )
                   ->setBelongsTo( 'Artisan' )
                   ->addFilters( $default_filters );
    
    
    // login
    $login = new Zend_Form_Element_Text( 'login' );
    $login->setLabel( 'Login' )
          ->setRequired( true )
          ->setBelongsTo( 'Artisan' )
          ->addFilters( $default_filters );
    
    // pass
    $pass = new Zend_Form_Element_Password( 'pass' );
    $pass->setLabel( 'Mot de passe' )
         ->setBelongsTo( 'Artisan' )
         ->addFilters( $default_filters );
    
    // pass2
    $pass2 = new Zend_Form_Element_Password( 'pass2' );
    $pass2->setLabel( 'Cofirmer le mot de passe' )
          ->setBelongsTo( 'Artisan' )
          ->addFilters( $default_filters );
    
    // code_artisan
    $code_artisan = new Zend_Form_Element_Text( 'code_artisan' );
    $code_artisan->setLabel( 'Code d\'artisan' )
                 ->setBelongsTo( 'Artisan' )
                 ->addFilters( $default_filters );
    
    // raison_social
    $raison_social = new Zend_Form_Element_Text( 'raison_social' );
    $raison_social->setLabel( 'Raison social' )
                  ->setBelongsTo( 'Artisan' )
                  ->addFilters( $default_filters );
    
    // email_artisan
    $email_artisan = new Zend_Form_Element_Text( 'email_artisan' );
    $email_artisan->setLabel( 'Adresse email' )
                  ->setRequired( true )
                  ->setValidators( [ new Zend_Validate_EmailAddress ] )
                  ->setBelongsTo( 'Artisan' )
                  ->addFilters( $default_filters );
    
    // telephone_fixe
    $telephone_fixe = new Zend_Form_Element_Text( 'telephone_fixe' );
    $telephone_fixe->setLabel( 'Tél. Fixe' )
                   ->setBelongsTo( 'Artisan' )
                   ->addFilters( $default_filters );
    
    // telephone_portable
    $telephone_portable = new Zend_Form_Element_Text( 'telephone_portable' );
    $telephone_portable->setLabel( 'Tél. Portable' )
                       ->setRequired( true )
                       ->setBelongsTo( 'Artisan' )
                       ->addFilters( $default_filters );
    
    // fax
    $fax = new Zend_Form_Element_Text( 'fax' );
    $fax->setLabel( 'Fax' )
        ->setBelongsTo( 'Artisan' )
        ->addFilters( $default_filters );
    
    // rcs
    $rcs = new Zend_Form_Element_Text( 'rcs' );
    $rcs->setLabel( 'RCS' )
        ->setBelongsTo( 'Artisan' )
        ->addFilters( $default_filters );
    
    // siret
    $siret = new Zend_Form_Element_Text( 'siret' );
    $siret->setLabel( 'SIRET' )
          ->setBelongsTo( 'Artisan' )
          ->addFilters( $default_filters );
    
    // code_naf
    $code_naf = new Zend_Form_Element_Text( 'code_NAF' );
    $code_naf->setLabel( 'Code NAF' )
             ->setBelongsTo( 'Artisan' )
             ->addFilters( $default_filters );
    
    // horairerdv
    $horairerdv = new Zend_Form_Element_Text( 'horaireRDV' );
    $horairerdv->setLabel( 'Horaire pour vous joindre' )
               ->setBelongsTo( 'Artisan' )
               ->addFilters( $default_filters );
    
    
    // adresse
    $adresse = new Zend_Form_Element_Text( 'adresse' );
    $adresse->setLabel( 'Adresse' )
            ->setBelongsTo( 'Artisan' )
            ->addFilters( $default_filters );
    
    // adresse2
    $adresse2 = new Zend_Form_Element_Text( 'adresse2' );
    $adresse2->setLabel( 'Adresse 2' )
             ->setBelongsTo( 'Artisan' )
             ->addFilters( $default_filters );
    
    // description
    $description = new Zend_Form_Element_Textarea( 'description' );
    $description->setLabel( 'Description' )
                ->setBelongsTo( 'Artisan' )
                ->addFilters( $default_filters );
    
    
    // qualification
    $qualification = new Zend_Form_Element_Select( 'qualification' );
    $qualification->setLabel( 'Qualification' )
                  ->setBelongsTo( 'Artisan' )
                  ->addFilters( $select_filters )
                  ->addMultiOptions( $this->_qualification );
    
    
    // select_activites
    $select_activites = new Zend_Form_Element_Select( 'select_activites' );
    $select_activites->setLabel( 'Activités' )
                     ->setBelongsTo( 'Artisan' )
                     ->setIsArray( true )
                     ->addFilters( $select_filters )
                     ->addMultiOptions( $this->_activites );
    
    
    // Submit button
    $submit = new Zend_Form_Element_Submit( 'submit' );
    $submit->setLabel( 'Envoyer' )
           ->setAttribs( [ 'class' => 'btn btn-primary btn-block' ] );
    
    $this->addElements( [
      $nom_artisan,
      $prenom_artisan,
      $code_artisan,
      $raison_social,
      $email_artisan,
      $telephone_fixe,
      $telephone_portable,
      $fax,
      $rcs,
      $siret,
      $code_naf,
      $horairerdv,
      $login,
      $pass,
      $pass2,
      $adresse,
      $adresse2,
      $description,
      $qualification,
      $select_activites,
      $submit,
    ] );
    
    parent::init();
    
  }
  
}
