<div class="product-of-categories__box">
    <h3 class="product-of-categories__title"><?php echo $heading_title; ?></h3>
    <div class="row">
        <?php foreach ($products as $product) { ?>
            <div class="product-layout col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="product-thumb transition product-of-categories__product">

                    <div class="product-of-categories__button-group product-of-categories__button-info">
                        <div>Подробнее</div>
                    </div>

                    <div class="image product-of-categories__img-box"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive product-of-categories__img" /></a></div>

                    <div class="button-group product-of-categories__button-group">
                        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                    </div>

                    <div class="caption">
                        <h4><a class="product-of-categories__name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                        <?php if ($product['price']) { ?>
                            <p class="price product-of-categories__price">
                                <?php if (!$product['special']) { ?>
                                    <?php echo $product['price']; ?>
                                <?php } else { ?>
                                    <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                <?php } ?>
                            </p>
                        <?php } ?>

                        <?php if ($product['rating']) { ?>
                            <div class="rating product-of-categories__rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <?php if ($product['rating'] < $i) { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } else { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>
