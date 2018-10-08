<link rel="stylesheet" type="text/css"
      href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_comment/asset'; ?>/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_comment/asset'; ?>/custom.css">
<script type="text/javascript" src="<?php echo BASE_URL . HM_PLUGIN_DIR . '/hm_comment/asset'; ?>/datatables.min.js"
        charset="UTF-8"></script>
<div class="container">
    <div class="row">

        <section class="show_order">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <a href="?run=admin_page.php&key=comment_all" class="btn btn-info btn-filter">Tất
                                            cả</a>
                                        <a href="?run=admin_page.php&key=comment_all&status=public"
                                           class="btn btn-success btn-filter">Đang công khai</a>
                                        <a href="?run=admin_page.php&key=comment_all&status=pending"
                                           class="btn btn-warning btn-filter">Đang chờ kiểm duyệt</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="ordertable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Đăng tải</th>
                                    <th>Cập nhật cuối</th>
                                    <th>Trên trang</th>
                                    <th>Chi tiết</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($data as $comment) {
                                    $status = $comment->status;
                                    $created = $comment->created;
                                    $updated = $comment->updated;
                                    $object_id = $comment->object_id;
                                    $object_type = $comment->object_type;
                                    switch ($status) {
                                        case 'public':
                                            $status_label = 'Công khai';
                                            $bgclass = 'bg-info';
                                            break;
                                        case 'hidden':
                                            $status_label = 'Tạm ẩn';
                                            $bgclass = 'bg-warning';
                                            break;
                                        default:
                                            $status_label = '';
                                            $bgclass = '';
                                    }

                                    switch ($object_type) {
                                        case 'content':
                                            $object_name = get_primary_con_val($object_id);
                                            $object_href = request_uri("type=content&id=$object_id");
                                            break;
                                        case 'taxonomy':
                                            $object_name = get_primary_tax_val($object_id);
                                            $object_href = request_uri("type=taxonomy&id=$object_id");
                                            break;
                                        default:
                                            $object_name = '';
                                            $object_href = '';
                                    }
                                    ?>
                                    <tr class="<?php echo $bgclass; ?>">
                                        <td>
                                            <span><?php echo $comment->id; ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo date(DATETIME_FORMAT, $created); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo date(DATETIME_FORMAT, $updated); ?></span>
                                        </td>
                                        <td>
                                            <a href="<?php echo $object_href; ?>"
                                               target="_blank"><?php echo $object_name; ?></a>
                                        </td>
                                        <td>
                                            <?php
                                            $cmt_fields = get_comment_fields($comment->id);
                                            if (is_array($cmt_fields)) {
                                                foreach ($cmt_fields as $cmt_field) {
                                                    echo '<li><b>' . $cmt_field->name . ':</b> ' . $cmt_field->val . '</li>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($status) {
                                                case 'public':
                                                    ?>
                                                    <span data-status="hide" data-id="<?php echo $comment->id; ?>"
                                                          class="btn btn-warning btn-xs ajax_update_cmt_status"><?php echo hm_lang('hide'); ?></span>
                                                    <?php
                                                    break;
                                                case 'pending':
                                                    ?>
                                                    <span data-status="public" data-id="<?php echo $comment->id; ?>"
                                                          class="btn btn-success btn-xs ajax_update_cmt_status"><?php echo hm_lang('public'); ?></span>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                            <span data-status="deleted" data-id="<?php echo $comment->id; ?>"
                                                  class="btn btn-danger btn-xs ajax_update_cmt_status"><?php echo hme_lang('delete'); ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('.ajax_update_cmt_status').click(function () {
            var status = $(this).attr('data-status');
            var id = $(this).attr('data-id');
            $.ajax({
                method: "POST",
                url: "?run=ajax.php&key=comment_action",
                data: {action: 'update_status', id: id, status: status}
            }).done(function () {
                window.location.href = window.location.href
            });
        });
    });
</script>
