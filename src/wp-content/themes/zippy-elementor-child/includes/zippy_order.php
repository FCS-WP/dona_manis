<?php
//Save custom field billing
function custom_save_checkout_fields($order_id)
{
  $fields = [
    'billing_date',
    'billing_time',
    'billing_outlet_address',
  ];

  foreach ($fields as $field) {
    if (!empty($_POST[$field])) {
      update_post_meta($order_id, '_' . $field, sanitize_text_field($_POST[$field]));
    }
  }
}

add_action('woocommerce_checkout_update_order_meta', 'custom_save_checkout_fields');

//Display Admin
function custom_display_order_meta($order)
{
  $productID = $order->get_id();
  echo '<h4>' . __('Shipping Details', 'woocommerce') . '</h4>';
  echo '<p><strong>Outlet Address:</strong> ' . get_post_meta($productID, '_billing_outlet_address', true) . '</p>';
  echo '<p><strong>Date:</strong> ' . get_post_meta($productID, '_billing_date', true) . '</p>';
  echo '<p><strong>Time:</strong> ' . get_post_meta($productID, '_billing_time', true) . '</p>';
}
add_action('woocommerce_admin_order_data_after_shipping_address', 'custom_display_order_meta', 10, 1);




function remove_cart_session()
{
  // Empty cart
  WC()->cart->empty_cart();
  //Empty Session
  WC()->session->destroy_session();

  wp_send_json_success(['message' => 'Cart session removed']);
}

add_action('wp_ajax_remove_cart_session', 'remove_cart_session');
add_action('wp_ajax_nopriv_remove_cart_session', 'remove_cart_session');
