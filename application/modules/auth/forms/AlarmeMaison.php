<?php


/**
 * Class Auth_Form_AlarmeMaison
 *
 * @author  Youssef Erratbi <yerratbi@gmail.com>
 * @date    24/12/17
 */
class Auth_Form_AlarmeMaison extends Auth_Form_Base {
  
  /**
   * @throws \Zend_Form_Exception
   */
  
  private $_type_alarme = [
    ''         => 'Veuillez préciser',
    'Filaire'  => 'Filaire',
    'Sans fil' => 'Sans fil',
    'Autre'    => 'Autre',
  
  ];
  
  
  private $_system_alarme = [
    ''                      => 'Veuillez préciser',
    'Détection'             => 'Détection',
    'Sirène anti-intrusion' => 'Sirène anti-intrusion',
    'Surveillance'          => 'Surveillance',
    'Gardiennage'           => 'Gardiennage',
  ];
  
  private $_type_travaux = [
    ''                      => 'Veuillez préciser',
    'Remplacement'          => 'Remplacement',
    'Installation Neuve'    => 'Installation Neuve',
    'Réparation'            => 'Réparation',
    'Entretien/Maintenance' => 'Entretien/Maintenance',
  ];
  
  
  /**
   * @throws \Zend_Form_Exception
   */
  public function init() {
    
    $default_filters = [
      'StringToLower',
      'StringTrim',
      'StripTags',
    ];
    
    $select_filters = [ 'StripTags' ];
    
    // type_travaux
    $type_travaux = new Zend_Form_Element_Select( 'type_travaux' );
    $type_travaux->setLabel( 'Type de Travaux' )
                 ->setBelongsTo( 'AlarmeMaison' )
                 ->addFilters( $select_filters )
                 ->addMultiOptions( $this->_type_travaux );
    
    // type_alarme
    $type_alarme = new Zend_Form_Element_Select( 'type_alarme' );
    $type_alarme->setLabel( 'Type d\'Alarme Souhaité' )
                ->setBelongsTo( 'AlarmeMaison' )
                ->addFilters( $select_filters )
                ->addMultiOptions( $this->_type_alarme );
    
    // system_alarme
    $system_alarme = new Zend_Form_Element_Select( 'system_alarme' );
    $system_alarme->setLabel( 'Type de Système d\'Alarme' )
                  ->setBelongsTo( 'AlarmeMaison' )
                  ->addFilters( $select_filters )
                  ->setAttrib( 'slugify', true )
                  ->addMultiOptions( $this->_system_alarme );
    
    // nbre_fenetre
    $nbre_fenetre = new Zend_Form_Element_Text( 'nbre_fenetre' );
    $nbre_fenetre->setLabel( 'Nombre de Pièces à Surveiller' )
                 ->setBelongsTo( 'AlarmeMaison' )
                 ->addFilters( $default_filters );
    
    // nbre_piece
    $nbre_piece = new Zend_Form_Element_Text( 'nbre_piece' );
    $nbre_piece->setLabel( 'Nombre de Fenêtres' )
               ->setBelongsTo( 'AlarmeMaison' )
               ->addFilters( $default_filters );
    
    // Submit button
    $submit = new Zend_Form_Element_Submit( 'submit' );
    $submit->setLabel( 'Envoyer' )
           ->setAttribs( [ 'class' => 'btn btn-primary btn-block' ] );
    
    $this->addElements( [
      $type_travaux,
      $type_alarme,
      $system_alarme,
      $nbre_fenetre,
      $nbre_piece,
      $submit,
    ] );
    
    parent::init();
    
  }
  
}
