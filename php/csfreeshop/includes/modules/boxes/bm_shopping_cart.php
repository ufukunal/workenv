<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_shopping_cart {
    var $code = 'bm_shopping_cart';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $pages;	

    function bm_shopping_cart() {
      $this->title = MODULE_BOXES_SHOPPING_CART_TITLE;
      $this->description = MODULE_BOXES_SHOPPING_CART_DESCRIPTION;

      if ( defined('MODULE_BOXES_SHOPPING_CART_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SHOPPING_CART_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SHOPPING_CART_STATUS == 'True');
        $this->pages = MODULE_BOXES_SHOPPING_CART_DISPLAY_PAGES;
        $this->group = ((MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $cart, $new_products_id_in_cart, $currencies, $oscTemplate;

      $cart_contents_string = '';

      if ($cart->count_contents() > 0) {
        $cart_contents_string = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
        $products = $cart->get_products();
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {
          $cart_contents_string .= '<tr><td align="right" valign="top">';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '<span class="newItemInCart">';
          }

          $cart_contents_string .= $products[$i]['quantity'] . '&nbsp;x&nbsp;';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '</span>';
          }

          $cart_contents_string .= '</td><td valign="top" style="width:100%;"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '<span class="newItemInCart">';
          }

          $cart_contents_string .= $products[$i]['name'];

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            $cart_contents_string .= '</span>';
          }

          $cart_contents_string .= '</a></td></tr>';

          if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
            tep_session_unregister('new_products_id_in_cart');
          }
        }

        $cart_contents_string .= '<tr><td colspan="2" class="cart_box_separator">'.tep_draw_separator('spacer.gif', '1', '1').'</td></tr>' .
                                 '<tr><td colspan="2" class="cart_price_box" align="right"><span class="productSpecialPrice">' . $currencies->format($cart->show_total()) . '</span></td></tr>' .
                                 '</table>';
      } else {
        $cart_contents_string .= '' . MODULE_BOXES_SHOPPING_CART_NOW_IN_CART . '<strong>' . MODULE_BOXES_SHOPPING_CART_EMPTY . '</strong>';
      }

      $data = '<div class="infoBoxWrapper cart_box">' . tep_draw_box_wrapper_top() .
              '  <div class="infoBoxHeading"><a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . tep_draw_box_title_top() . MODULE_BOXES_SHOPPING_CART_BOX_TITLE . tep_draw_box_title_bottom() . '</a></div>' .
              '  <div class="infoBoxContents">' . tep_draw_box_content_top() . '' . $cart_contents_string . '' . tep_draw_box_content_bottom() . '</div>' .
          	  '' . tep_draw_box_wrapper_bottom() . '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SHOPPING_CART_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Shopping Cart Module', 'MODULE_BOXES_SHOPPING_CART_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SHOPPING_CART_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display in pages.', 'MODULE_BOXES_SHOPPING_CART_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', '6', '0','tep_cfg_select_pages(' , now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SHOPPING_CART_STATUS', 'MODULE_BOXES_SHOPPING_CART_CONTENT_PLACEMENT', 'MODULE_BOXES_SHOPPING_CART_SORT_ORDER','MODULE_BOXES_SHOPPING_CART_DISPLAY_PAGES');
    }
  }
?>
