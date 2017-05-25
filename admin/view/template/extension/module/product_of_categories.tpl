<?php echo $header; ?><?php echo $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <button type="submit" form="form-product_of_categories" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                    <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
                <h1><?php echo $heading_title; ?></h1>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <?php if ($error_warning) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product_of_categories" class="form-horizontal">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                                <?php if ($error_name) { ?>
                                    <div class="text-danger"><?php echo $error_name; ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="product_of_categories_limit" value="<?php echo $product_of_categories_limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="product_of_categories_search_category" value="" placeholder="" id="input-search-category" class="form-control" />
                                <div id="input-search-category-title">Установленные категории:</div>
                                <div id="input-search-category-list">
                                    <?php if ($product_of_categories_categories) :?>
                                        <?php foreach ($product_of_categories_categories as $key => $item) :?>
                                            <div><i class="fa fa-minus-circle"></i> id: <?php echo $item?><input type="hidden" name="product_of_categories_categories[]" value="<?php echo $item?>" /></div>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-search-product"><?php echo $entry_search_products; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="product_of_categories_search_product" value="" placeholder="" id="input-search-product" class="form-control" />
                                <div id="input-search-product-title">Установленные товары:</div>
                                <div id="input-search-product-list">
                                    <?php if ($product_of_categories_products) :?>
                                        <?php foreach ($product_of_categories_products as $key => $item) :?>
                                            <div><i class="fa fa-minus-circle"></i> id: <?php echo $item?><input type="hidden" name="product_of_categories_products[]" value="<?php echo $item?>" /></div>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-limit" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
                            <div class="col-sm-10">
                                <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-limit" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                            <div class="col-sm-10">
                                <select name="status" id="input-status" class="form-control">
                                    <?php if ($status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            /* Выбор категории */
            $('#input-search-category').autocomplete({
                source: function (request, response) {

                    var data = {
                        "category_name" : request
                    };

                    $.ajax({
                        url: 'index.php?route=extension/module/product_of_categories/getCategory&token=<?php echo $token; ?>',
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        success: function (json) {
                            console.log(json);
                            var qwe = response($.map(json, function (item) {
                                return {
                                    label: item['name'],
                                    value: item['category_id']
                                }
                            }));
                            console.log(qwe);
                        }
                    });
                },
                select: function (item) {
                    console.log(item['label'] + " : " + item['value']);
                    $('#input-search-category-list').append('<div><i class="fa fa-minus-circle"></i> id: ' + item['value'] +' Название: ' + item['label'] + '<input type="hidden" name="product_of_categories_categories[]" value="' + item['value'] + '|' + item['label'] +'" /></div>');
                }
            });
            $('#input-search-category-list').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
            });



        </script>

        <script>
            $('#input-search-product').autocomplete({
                source: function (request, response) {

                    var product_of_categories_categories = $('input[name=\'product_of_categories_categories[]\']');
                    var arr =[];
                    var category_id = [];

                    product_of_categories_categories.each(function() {
                        if (this.value != "") {
                            arr.push(this.value);
                        }
                    });

                    $.map(arr, function (el) {
                        category_id.push(el.split('|'));
                    });

                    var arr_id = $.map(category_id, function (val) {
                        return val[0];
                    });

                    var str_id = arr_id.join(', ');

                    var data = {
                        "filter_name" : request,
                        "product_of_categories_id" : "<?php echo $product_of_categories_id ?>",
                        "product_of_categories_categories" : str_id
                    };

                    $.ajax({
                        url: 'index.php?route=extension/module/product_of_categories/autocomplete&token=<?php echo $token; ?>',
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        /*dataFilter: function (json) {
                            if ( json === null ) {
                                console.log(json + " JSON === null");
                            } else {
                                console.log(json + " JSON != null");
                            }
                        },*/
                        success: function (json) {

                            console.log(json);
                            var qwe = response($.map(json, function (item) {
                                return {
                                    label: item['model'],
                                    value: item['product_id']
                                }
                            }));
                            console.log(qwe);
                        }
                    });
                },
                select: function (item) {
                    console.log(item['label'] + " : " + item['value']);
                    $('#input-search-product-list').append('<div><i class="fa fa-minus-circle"></i> id: ' + item['value'] +' Название: ' + item['label'] + '<input type="hidden" name="product_of_categories_products[]" value="' + item['value'] + '|' + item['label'] +'" /></div>');
                }
            });
            $('#input-search-product-list').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
            });
        </script>

       <!-- <script type="text/javascript">
            $('input[name=\'product_name\']').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: 'index.php?route=catalog/product/autocomplete&token=<?php /*echo $token; */?>&filter_name=' +  encodeURIComponent(request),
                        dataType: 'json',
                        success: function(json) {
                            response($.map(json, function(item) {
                                return {
                                    label: item['name'],
                                    value: item['product_id']
                                }
                            }));
                        }
                    });
                },
                select: function(item) {
                    $('input[name=\'product_name\']').val('');

                    $('#featured-product' + item['value']).remove();

                    $('#featured-product').append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');
                }
            });

            $('#featured-product').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
            });
            </script>-->

    </div>



<?php echo $footer; ?>