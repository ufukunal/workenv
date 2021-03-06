<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  // SIMPLE CHECKOUT START
if(SIMPLE_CHECKOUT_ENABLED == 'True') tep_redirect(tep_href_link(FILENAME_CHECKOUT, '', 'SSL'));
// SIMPLE CHECKOUT END

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!tep_session_is_registered('shipping')) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

// Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (tep_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }

// if no billing destination address was selected, use the customers own address as default
  if (!tep_session_is_registered('billto')) {
    tep_session_register('billto');
    $billto = $customer_default_address_id;
  } else {
// verify the selected billing address
    if ( (is_array($billto) && empty($billto)) || is_numeric($billto) ) {
      $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$billto . "'");
      $check_address = tep_db_fetch_array($check_address_query);

      if ($check_address['total'] != '1') {
        $billto = $customer_default_address_id;
        if (tep_session_is_registered('payment')) tep_session_unregister('payment');
      }
    }
  }

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  if (!tep_session_is_registered('comments')) tep_session_register('comments');
  if (isset($HTTP_POST_VARS['comments']) && tep_not_null($HTTP_POST_VARS['comments'])) {
    $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
  }

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();

// load all enabled payment modules
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment;

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PAYMENT);
  $current_page = FILENAME_CHECKOUT_PAYMENT;
  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<script type="text/javascript"><!--
var selected;

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_payment.payment[0]) {
    document.checkout_payment.payment[buttonSelect].checked=true;
  } else {
    document.checkout_payment.payment.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
<?php
  // Discount Code 3.1.1 - start
  if (MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') {
?>
$(document).ready(function() {
var a = 0;
discount_code_process();
$('#discount_code').blur(function() { if (a == 0) discount_code_process(); a = 0 });
$("#discount_code").keypress(function(event) { if (event.which == 13) { event.preventDefault(); a = 1; discount_code_process() } });
function discount_code_process() { if ($("#discount_code").val() != "") { $("#discount_code").attr("readonly", "readonly"); $("#discount_code_status").empty().append('<?php echo tep_image(DIR_WS_ICONS . 'dc_progress.gif'); ?>'); $.post("discount_code.php", { discount_code: $("#discount_code").val() }, function(data) { data == 1 ? $("#discount_code_status").empty().append('<?php echo tep_image(DIR_WS_ICONS . 'dc_success.gif'); ?>') : $("#discount_code_status").empty().append('<?php echo tep_image(DIR_WS_ICONS . 'dc_failed.gif'); ?>'); $("#discount_code").removeAttr("readonly") }); } }
});
<?php
  }
  // Discount Code 3.1.1 - end
?>
//--></script>
<?php echo $payment_modules->javascript_validation(); ?>

<?php echo tep_draw_content_top();?>

<?php echo tep_draw_title_top();?>
<h1><?php echo HEADING_TITLE; ?></h1>
<?php echo tep_draw_title_bottom();?>

<?php echo tep_draw_form('checkout_payment', tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();"', true); ?>

<div class="contentContainer">
  <div class="contentPadd">

<?php
  if (isset($HTTP_GET_VARS['payment_error']) && is_object(${$HTTP_GET_VARS['payment_error']}) && ($error = ${$HTTP_GET_VARS['payment_error']}->get_error())) {
?>

  <div class="contentInfoText">
    <?php echo '<strong>' . tep_output_string_protected($error['title']) . '</strong>'; ?>

    <p class="messageStackError"><?php echo tep_output_string_protected($error['error']); ?></p>
  </div>

<?php
  }
?>

  <h3><?php echo TABLE_HEADING_BILLING_ADDRESS; ?></h3>

  <div class="contentInfoText">
    <div class="" style="float:right; width:auto; margin-left:17px;">
      <h3 class="first_h3"><?php echo TITLE_BILLING_ADDRESS; ?></h3>

      <div class="contentInfoText marg-bottom" style="white-space:nowrap;">
        <?php echo tep_address_label($customer_id, $billto, true, ' ', '<br />'); ?>
      </div>
    </div>

    <?php echo TEXT_SELECTED_BILLING_DESTINATION; ?><br /><div class="buttonSet"><?php echo tep_draw_button2_top();?><?php echo tep_draw_button(IMAGE_BUTTON_CHANGE_ADDRESS, 'home', tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL')); ?><?php echo tep_draw_button2_bottom();?></div>
  </div>

  <div style="clear: both;"></div>

  <h3><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></h3>

<?php
  $selection = $payment_modules->selection();

  if (sizeof($selection) > 1) {
?>

  <div class="contentInfoText">
    <div style="float: right;">
      <?php echo '<strong>' . TITLE_PLEASE_SELECT . '</strong>'; ?>
    </div>

    <?php echo TEXT_SELECT_PAYMENT_METHOD; ?>
  

<?php
    } elseif ($free_shipping == false) {
?>

  <div class="contentInfoText">
    <?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?>
  

<?php
    }
?>
  <br /><br />

<?php
  $radio_buttons = 0;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="5">

<?php
    if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
      echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>

        <td width="100%"><strong><?php echo $selection[$i]['module']; ?></strong></td>
        <td align="right">

<?php
    if (sizeof($selection) > 1) {
      echo tep_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $payment));
    } else {
      echo tep_draw_hidden_field('payment', $selection[$i]['id']);
    }
?>

        </td>
      </tr>

<?php
    if (isset($selection[$i]['error'])) {
?>

      <tr>
        <td colspan="2"><?php echo $selection[$i]['error']; ?></td>
      </tr>

<?php
    } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
?>

      <tr>
        <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">

<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>

          <tr>
            <td><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
            <td><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
          </tr>

<?php
      }
?>

        </table></td>
      </tr>

<?php
    }
?>

    </table>

<?php
    $radio_buttons++;
  }
?>

  </div>
<?php
  // Discount Code 3.1.1 - start
  if (MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') {
?>

  <h2><?php echo TEXT_DISCOUNT_CODE; ?></h2>

  <div class="contentText">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="middle" height="25"><?php echo tep_draw_input_field('discount_code', $sess_discount_code, 'id="discount_code" size="10"'); ?></td>
        <td width="5"></td>
        <td valign="middle"><div id="discount_code_status"></div></td>
      </tr>
    </table>
  </div>
<?php
  }
  // Discount Code 3.1.1 - end
?>
  <h3><?php echo TABLE_HEADING_COMMENTS; ?></h3>

  <div class="contentInfoText">
    <?php echo tep_draw_textarea_field('comments', 'soft', '60', '5', $comments);
	
	/* kgt - discount coupons */
	if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS == 'true' ) {
?>
<h2><?php echo TABLE_HEADING_COUPON; ?></h2>

  <div class="contentText">
  	 </div>
   
        <div class="contentText">
        <?php echo ENTRY_DISCOUNT_COUPON.' '.tep_draw_input_field('coupon', '', 'size="32"', $coupon); ?>
  	 </div>
		
<?php
	}
/* end kgt - discount coupons */ 
	
	?>
  </div>
  
  <div class="buttonSet">
    <div class="coProgressBar">
      <div id="coProgressBar"></div>

      <table border="0" width="100%" cellspacing="7" cellpadding="0">
        <tr>
          <td align="center" width="33%" class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_DELIVERY . '</a>'; ?></td>
          <td align="center" width="33%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
          <td align="center" width="33%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
        </tr>
      </table>
    </div>
    

    <div class="fl_right" align="right"><?php echo tep_draw_button_top();?><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?><?php echo tep_draw_button_bottom();?></div>
  </div>
  
  </div>

</div>
<script type="text/javascript">
$('#coProgressBar').progressbar({
  value: 66
});
</script>

</form>

<?php echo tep_draw_content_bottom();?>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
