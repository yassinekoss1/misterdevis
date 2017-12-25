<?php


class Custom_LibraryAcl extends Zend_Acl {

  function __construct() {

    // >>>>>>>>>>>> Adding Roles <<<<<<<<<<<<<<<
    $this->addRole(new Zend_Acl_Role('guests'));
    $this->addRole(new Zend_Acl_Role('auth'), 'guests');

    // >>>>>>>>>>>> Adding Resources <<<<<<<<<<<<<<<

    // **** Resources for module Default *****
    $this->add(new Zend_Acl_Resource('default'));
    $this->add(new Zend_Acl_Resource('default:index'), 'default');
    $this->add(new Zend_Acl_Resource('default:error'), 'default');
    $this->add(new Zend_Acl_Resource('default:cron'), 'default');

    // **** Resources for module Admin *****
    $this->add(new Zend_Acl_Resource('admin'));
    $this->add(new Zend_Acl_Resource('admin:index'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:devis'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:create'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:category'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:product'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:formula'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:contact'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:company'), 'admin');
    $this->add(new Zend_Acl_Resource('admin:estimate'), 'admin');

    // **** Resources for module Auth *****
    $this->add(new Zend_Acl_Resource('auth'));
    $this->add(new Zend_Acl_Resource('auth:index'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:login'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:logout'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:user'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:dashboard'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:piscine'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:chauffage'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:fenetre'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:cuisine'), 'auth');
    $this->add(new Zend_Acl_Resource('auth:sallebain'), 'auth');

    // >>>>>>>>>>>> Affecting Resources <<<<<<<<<<<<<<<

    // -------  >> module Default  << -------
    $this->allow('auth', 'default:index');
    $this->allow('auth', 'default:error');
    $this->allow('guests', 'default:cron');

    // -------  >> module Auth  << -------
    $this->allow('auth', 'auth:index');
    $this->allow('guests', 'auth:login');
    $this->allow('auth', 'auth:logout');
    $this->allow('auth', 'auth:user');
    $this->allow('auth', 'auth:dashboard');
    $this->allow('auth', 'auth:piscine');
    $this->allow('auth', 'auth:chauffage');
    $this->allow('auth', 'auth:fenetre');
    $this->allow('auth', 'auth:cuisine');
    $this->allow('auth', 'auth:sallebain');
    $this->allow('guests', 'auth:user');

    // -------  >> module Admin  << -------
    $this->allow('auth', 'admin:index');
    $this->allow('auth', 'admin:devis');
    $this->allow('auth', 'admin:create');
    $this->allow('auth', 'admin:category');
    $this->allow('auth', 'admin:product');
    $this->allow('auth', 'admin:formula');
    $this->allow('auth', 'admin:contact');
    $this->allow('auth', 'admin:company');
    $this->allow('auth', 'admin:estimate');

    // -------  >> For Custom Permissions  << -------
    $this->addResource('pdf');
    $this->addResource('pdf facture');
    $this->addResource('pdf devis');
    $this->addResource('pdf bon de livraison');
    $this->addResource('gestion des devis');
    $this->addResource('solder');
    $this->addResource('voir tous les devis');
    $this->addResource('archives');
    $this->addResource('devis');
    $this->addResource('agenda');
    $this->addResource('actions');
    $this->addResource('formules');
    $this->addResource('contacts');
    $this->addResource('articles');
    $this->addResource('catalogue');
    $this->addResource('groupe');
    $this->addResource('clientele');
    $this->addResource('categories');
    $this->addResource('permissions');
    $this->addResource('entreprises');
    $this->addResource('utilisateurs');
    $this->addResource('catpermissions');
    $this->addResource('configuration');
    $this->addResource('fiche de production');
    $this->addResource('remise de chèques');
    $this->addResource('statistics');
  }


}
