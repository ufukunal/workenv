<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class cm_menu_header {
    var $code = 'cm_menu_header';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $pages;	

    function cm_menu_header() {
      $this->title = MODULE_BOXES_MAIN_MENU_TITLE;
      $this->description = MODULE_BOXES_MAIN_MENU_DESCRIPTION;

      if ( defined('MODULE_BOXES_MAIN_MENU_STATUS') ) {
        $this->sort_order = MODULE_BOXES_MAIN_MENU_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_MAIN_MENU_STATUS == 'True');
        $this->pages = MODULE_BOXES_MAIN_MENU_DISPLAY_PAGES;
				$this->group = 'boxes_header';
      }
    }

    function execute() {
      global $oscTemplate, $current_page;
	    $button_act1 = $button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		if ($current_page == FILENAME_DEFAULT)	{
		$button_act1 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_CATEGORIES_NESTED)	{
		$button_act1 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_CATEGORIES_LISTING)	{
		$button_act1 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_FEATURED_PRODUCTS)	{
		$button_act5 = " act";
		$button_act1 = $button_act3 = $button_act4 = $button_act2 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}				
		if ($current_page == FILENAME_PRODUCTS_NEW)	{
		$button_act2 = " act";
		$button_act1 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_SPECIALS)	{
		$button_act3 = " act";
		$button_act2 = $button_act1 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_REVIEWS)	{
		$button_act4 = " act";
		$button_act2 = $button_act3 = $button_act1 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act12 = "";
		}
		if ($current_page == FILENAME_CONTACT_US)		{
		$button_act6 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act1 = $button_act7 = $button_act8 = $button_act12 = "";
		}	
		if ($current_page == (FILENAME_ADVANCED_SEARCH))
		{
		$button_act7 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act1 = $button_act6 = $button_act8 = $button_act12 = "";
		}		
		if ($current_page == FILENAME_MANUFACTURERS)	{
		$button_act12 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act8 = $button_act1 = "";
		}
		if ($current_page == (FILENAME_SHIPPING))
		{
		$button_act8 = " act";
		$button_act2 = $button_act3 = $button_act4 = $button_act5 = $button_act6 = $button_act7 = $button_act1 = $button_act12 = "";
		}		
			
      $data = '<div class="menu">' . 
   //           '  <h4 class="Menu_BoxHeading">' . MODULE_BOXES_MAIN_MENU_BOX_TITLE . '</h4>' .
			  '  <ul>' .
              '    <li class="'.$button_act1.'"><a href="' . tep_href_link(FILENAME_DEFAULT) . '">'. tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_DEFAULT . '' . tep_draw_menu_bottom() . '</a></li>' .
			  '    <li class="'.$button_act5.'"><a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_FEATURED . '' . tep_draw_menu_bottom() . '</a></li>'.
              '    <li class="'.$button_act2.'"><a href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_PRODUCTS_NEW . '' . tep_draw_menu_bottom() . '</a></li>' .
              '    <li class="'.$button_act3.'"><a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_SPECIALS . '' . tep_draw_menu_bottom() . '</a></li>' .
		//					'    <li class="'.$button_act12.'"><a href="' . tep_href_link(FILENAME_MANUFACTURERS) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_MANUFACTURERS . '' . tep_draw_menu_bottom() . '</a></li>'.
              '    <li class="'.$button_act4.'"><a href="' . tep_href_link(FILENAME_REVIEWS) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_REVIEWS . '' . tep_draw_menu_bottom() . '</a></li>'.
			  '    <li class="'.$button_act6.'"><a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . tep_draw_menu_top() . '' . MODULE_BOXES_MAIN_MENU_BOX_CONTACT_US . '' . tep_draw_menu_bottom() . '</a></li>'.
			//	'<li class="'.$button_act7.'"><a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">'.tep_draw_button_header_top().'<span>'.MODULE_BOXES_MAIN_MENU_BOX_ADVANCED_SEARCH.'</span>'.tep_draw_button_header_bottom().'</a></li>'.
							'<li class="'.$button_act8.'"><a href="' . tep_href_link(FILENAME_SHIPPING) . '">'.tep_draw_button_header_top().'<span>'.MODULE_BOXES_USER_MENU_BOX_SHIPPING.'</span>'.tep_draw_button_header_bottom().'</a></li>'.
			  '  </ul>' .
              '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_MAIN_MENU_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'MODULE_BOXES_MAIN_MENU_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_MAIN_MENU_CONTENT_PLACEMENT', 'Header Block', 'Should the module be loaded in the Header Block?', '6', '1', 'tep_cfg_select_option(array(\'Header Block\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_MAIN_MENU_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display in pages.', 'MODULE_BOXES_MAIN_MENU_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', '6', '0','tep_cfg_select_pages(' , now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_MAIN_MENU_STATUS', 'MODULE_BOXES_MAIN_MENU_CONTENT_PLACEMENT', 'MODULE_BOXES_MAIN_MENU_SORT_ORDER','MODULE_BOXES_MAIN_MENU_DISPLAY_PAGES');
    }
  }
?>
