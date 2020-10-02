<?php

// Output stock status in category

function om_product_availability() {
    global $product;

    $stock_status = $product->get_stock_status();
    $stock_status_class = $stock_status;

    switch ($stock_status) {
        case 'instock':
            $stock_status = 'В наличии';
            break;
        case 'outofstock':
            $stock_status = 'Под заказ';
            break;
        case 'onbackorder':
            $stock_status = 'Под заказ';
            $stock_status_class = 'outofstock';
            break;
    }

    echo '<div class="stock_status ' . $stock_status_class . '">' . $stock_status . '</div>';

    return;
}
add_action( 'woocommerce_after_shop_loop_item', 'om_product_availability', 60 );
add_action( 'woocommerce_single_product_summary', 'om_product_availability', 1);