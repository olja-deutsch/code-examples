<?php

// Add news block to page

if (!function_exists('storefront_page_news')) {

    function storefront_page_news()
    {
        if (is_front_page()) {
            ?>
            <div class="home-news">
                <div class="col-full">
                    <?php $posts = get_posts("category=493&orderby=date&numberposts=2"); ?>
                    <?php if ($posts) : ?>
                        <div class="home-news__heading"><a href="<?php echo get_category_link(493); ?>">Наши новости</a>
                        </div>
                        <?php foreach ($posts as $post) : setup_postdata($post); ?>
                            <div class="home-news__block">
                                <div class="home-news__date"><?php echo get_the_date('d F Y', $post); ?></div>
                                <div class="home-news__caption">
                                    <a href="<?php echo get_permalink($post->ID, false); ?>"
                                       rel="bookmark"><?php echo $post->post_title; ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            return;
        }
    }
}
add_action('storefront_before_footer', 'storefront_page_news', 11);