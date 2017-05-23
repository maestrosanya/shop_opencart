<?php echo $header; ?><?php echo $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                    <button type="submit" form="form-maestro" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                </div>
                <h1><?php echo $heading_title; ?></h1>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>

                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-maestro" class="form-horizontal">


                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Главная</a></li>
                        <li><a href="#messages" data-toggle="tab">Сообщения</a></li>
                        <li><a href="#settings" data-toggle="tab">Настройки</a></li>
                    </ul>
                    <div class="table-responsive">
                        <div class="tab-content">

                            <div class="tab-pane active" id="home">
                                <table class="table">
                                    <thead>
                                        <th></th>
                                        <th>Это тр Главная</th>
                                        <th class="text-right">Действие</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($custom_field as $item): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected[]" value="<?php echo $item['id']; ?>"  />
                                                </td>
                                                <td>Это <?php echo $item['title'] ?></td>
                                                <td class="text-right"><a href="<?php  ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="messages">
                                <table class="table ">
                                    <thead>
                                        <th>Это тр Сообщения</th>
                                        <th class="text-right">Действие</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($custom_field as $item): ?>
                                            <tr>
                                                <td>Это <?php echo $item['title'] ?></td>
                                                <td class="text-right"><a href="<?php  ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="settings">Настройки</div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php echo $footer; ?>