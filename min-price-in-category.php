<?php

// Output min price in category

function om_term_description_price() {
    global $product;

    if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
        $term = get_queried_object();

        $term_slug = $term->slug;

        $productAll = get_posts( array(
            'post_type' => 'product',
            'posts_per_page' => 100000,
            'orderby' => 'date',
            'product_cat' => $term_slug,
        ));

        $priceAll = array();

        foreach ($productAll as $post) {
            $_product = wc_get_product( $post->ID );
            $price = (int) $_product->get_price();

            if ($price != '') {
                array_push($priceAll, $price);
            }
        }

        $filter_page = count(explode('?', $_SERVER['REQUEST_URI']));

        $priceMin = min($priceAll);
        $priceMin = number_format($priceMin, 0, '', ' ');

        if ( $term && ( (!empty( $term->description ) ) || ( !empty($priceMin) ) ) ) {
            echo '<div class="grid">';

            if (!empty( $term->description )) {
                echo '<div class="width-' . ((!empty($priceMin) && ($filter_page < 2)) ? '4-5' : '1-1') . '">
                        <div class="term-description">' . wc_format_content( $term->description ) . '</div>
                    </div>';
            }

            if (!empty($priceMin) && ($filter_page < 2)) {
                echo '<div class="width-' . (!empty( $term->description ) ? '1-5' : '1-1') . ' text-right">
                        <div class="term-price">Цена от <span class="term-price__value text-bold">' . $priceMin . ' р.</span></div>
                    </div>';
            }

            echo '</div>';
        }
    }

    wp_reset_postdata();

    return;
}
add_action( 'woocommerce_archive_description', 'om_term_description_price', 10 );