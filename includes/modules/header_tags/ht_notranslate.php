<?php
/*
 * @copyright Copyright 2008 - http://www.innov-concept.com
 * @Brand : ClicShopping(Tm) at Inpi all right Reserved
 * @license GPL 2 License & MIT Licencse

*/

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ht_notranslate {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;
    public $languages_array = array();

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_header_tags_notranslate_title');
      $this->description = CLICSHOPPING::getDef('module_header_tags_notranslate_description');

      if ( defined('MODULE_HEADER_TAGS_NOTRANSLATE_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_NOTRANSLATE_STATUS == 'True');
      }
    }

    public function execute() {

      $CLICSHOPPING_Template = Registry::get('Template');

      $meta_tag = '<meta name="google" content="notranslate">';
      $CLICSHOPPING_Template->addBlock( $meta_tag, $this->group );
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined( 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS' );
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');


      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez vous activer ce module ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Souhaitez vous activer ce module ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Ordre de tri d\'affichage',
          'configuration_key' => 'MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER',
          'configuration_value' => '145',
          'configuration_description' => 'Ordre de tri pour l\'affichage (Le plus petit nombre est montré en premier)',
          'configuration_group_id' => '6',
          'sort_order' => '125',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );


      return $CLICSHOPPING_Db->save('configuration', ['configuration_value' => '1'],
                                                ['configuration_key' => 'WEBSITE_MODULE_INSTALLED']
                              );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER';

      return $keys_array;
    }
  }
?>