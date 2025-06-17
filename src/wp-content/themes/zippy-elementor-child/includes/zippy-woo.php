<?php

add_action('woocommerce_after_shop_loop_item_title', 'show_stock_shop', 10);

function show_stock_shop()
{
  global $product;
  if ($product->managing_stock() && (int)$product->get_stock_quantity() < 1)
    echo '<p class="shop-out-of-stock" style="color: #fff;
    font-size: 12px;
    background: #666666;
    position: absolute;
    padding: 6px 12px;
    margin: 0 auto;
    top: 5px;
    left: 5px;">' . __('Out of stock') . '</p>';
}

add_action('woocommerce_checkout_before_customer_details', 'add_notification_coupon');

function add_notification_coupon()
{
  echo '<p style="text-align:center;color:#000000">🎉 Enjoy 10% Off Your Order!
    Use code <strong style="color:var(--e-global-color-primary);">NSDM10</strong> at checkout for 10% off when you spend a minimum of $330.</p>';
}
