<?php

function enqueue_wc_cart_fragments()
{
  wp_enqueue_script('wc-cart-fragments');
}
add_action('wp_enqueue_scripts', 'enqueue_wc_cart_fragments');

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

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_after_shop_loop_item', 'custom_add_to_cart_button', 20);

function custom_add_to_cart_button()
{
  global $product;

  $product_id = $product->get_id();
  $product_url = get_permalink($product_id);
  if (!function_exists('WC') || !WC()->session->get('order_mode')) : ?>
    <?php echo '<a data-product_id="' . $product_id . '" class="button add_to_cart_button">View Product</a>'; ?>
  <?php else: ?>
    <?php echo ' <a href="?add-to-cart=' . $product_id . '"  aria-describedby="woocommerce_loop_add_to_cart_link_describedby_' . $product_id . '" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="' . $product_id . '" data-product_sku="CNY010" aria-label="Add to cart: “TANGERINE TARTS”" rel="nofollow" data-success_message="“TANGERINE TARTS” has been added to your cart">Add to cart</a>'; ?>
  <?php endif; ?>

  <?php
  // Or link to cart directly:
  //
}
// add_action('woocommerce_checkout_before_customer_details', 'add_notification_coupon');

function add_notification_coupon()
{
  echo '<p style="text-align:center;color:#000000">🎉 Enjoy 10% Off Your Order!
    Use code <strong style="color:var(--e-global-color-primary);">NSDM10</strong> at checkout for 10% off when you spend a minimum of $330.</p>';
}

add_action('wp_footer', 'trigger_open_pickup_pop_up');
function trigger_open_pickup_pop_up()
{
  if (!function_exists('WC') || !WC()->session->get('order_mode')) {
    $popup_id = '232';
    ElementorPro\Modules\Popup\Module::add_popup_to_location($popup_id);
  ?>
    <script>
      jQuery(document).ready(function() {
        jQuery(window).on('elementor/frontend/init', function() {
          elementorFrontend.on('components:init', function() {
            jQuery('.add_to_cart_button').on('click', function(e) {
              e.preventDefault();
              // show the popup
              elementorFrontend.documentsManager.documents[<?php echo $popup_id; ?>].showModal();
              var product_id = jQuery(this).data('product_id');
              console.log(product_id);
              jQuery('#zippy-form').attr('data-product_id', product_id);
              jQuery('#zippy-form').attr('quantity', jQuery('input[name="quantity"').val());

            });
          });
        })

      });
    </script>;
<?php
  };
}
