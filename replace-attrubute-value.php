<?php
// Replace attributes value in product description (WordPress)

function replace_product_attr() {

    global $product;

    $total_description = '';
    $total_description_meta = '';
    $valueDesc = array();
    $aliasDesc = array();
    $attributes = $product->get_attributes();

    $match = strpos($product->post->post_content, '%sku%');

    if ($match) {
        $aliasDesc[] = '%sku%';
        $valueDesc[] = $product->sku;
    }

    foreach ($attributes as $attribute_key => $attribute) {
        $attr_name = explode(",", wc_attribute_label( $attribute->get_name() ));
        $match = strpos($product->get_description(), '%' . $attribute['name'] . '%');
        if ($match) {
            $aliasDesc[] = '%' . $attribute['name'] . '%';
            $valueDesc[] = $product->get_attribute($attribute['name']).$attr_name[1];
        }
    }

    $total_description =  str_replace($aliasDesc, $valueDesc, $product->get_description());

    return $total_description;
}

function show_product_description() {
    echo replace_product_attr();
}
add_action( 'show_product_description', 'show_product_description', 10 );

function show_product_category_description() {

    $total_description_meta = strip_tags(replace_product_attr());
    $total_description_meta = mb_strimwidth($total_description_meta, 0, 250, "...");

    echo '<meta itemprop="description" content="' . $total_description_meta . '">';
}
add_action( 'show_category_meta_description', 'show_product_category_description', 10 );
