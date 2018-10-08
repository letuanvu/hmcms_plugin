<div class="content_slider_box row">
    <?php
    $args = [
        'nice_name' => 'Độ cao của slider',
        'name' => 'galleria_height',
        'description' => 'Nếu để bằng 0 sẽ tự nhận độ cao mặc định chung trong cài đặt',
        'input_type' => 'number',
        'required' => false,
        'default_value' => 0,
    ];
    build_input_form($args);
    ?>
    <table class="table table-striped row">
        <thead>
        <tr>
            <th>Ảnh</th>
            <th>Thông số</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody class="content_slider_list_item">
        <tr class="content_slider_item" data-num="1">
            <td>
                <?php
                $args = [
                    'nice_name' => false,
                    'handle' => false,
                    'label' => 'Chọn ảnh',
                    'name' => 'content_slider_image[]',
                    'input_type' => 'image',
                    'required' => true,
                ];
                build_input_form($args);
                ?>
            </td>
            <td>
                <?php
                $args = [
                    'nice_name' => 'Tiêu đề',
                    'handle' => false,
                    'name' => 'content_slider_title[]',
                    'input_type' => 'text',
                ];
                build_input_form($args);

                $args = [
                    'nice_name' => 'Mô tả',
                    'handle' => false,
                    'name' => 'content_slider_description[]',
                    'input_type' => 'textarea',
                ];
                build_input_form($args);

                $args = [
                    'nice_name' => 'Link khi bấm vào',
                    'handle' => false,
                    'name' => 'content_slider_link[]',
                    'input_type' => 'text',
                ];
                build_input_form($args);
                ?>
            </td>
            <td>
                <span class="btn btn-danger del_content_slider_item" data-num="1">Xóa</span>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="row">
        <span class="btn btn-info add_content_slider_item" data-num="2">Thêm ô chèn ảnh</span>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.add_content_slider_item').click(function () {
            var num = $(this).attr('data-num');
            var line = '<tr class="content_slider_item" data-num="' + num + '">' +
                '	<td>' +
                '		<div class="form-group hm-form-group" data-input-name="content_slider_image[]" data-order="0">' +
                '			<div class="preview_media_file  preview_media_file_imageonly" use_media_file="content_slider_image[]"></div>' +
                '			<span id="content_slider_image[]" multi="false" imageonly="true" class="use_media_file btn btn-default btn-xs" data-toggle="modal" data-target="#media_box_modal">' +
                '			Chọn ảnh</span>' +
                '			<input use_media_file="content_slider_image[]" type="hidden" name="content_slider_image[]" value="" />' +
                '		</div>' +
                '	</td>' +
                '	<td>' +
                '		<div class="form-group hm-form-group" data-input-name="content_slider_title[]" data-order="0">' +
                '			<label for="content_slider_title[]">Tiêu đề</label>' +
                '			<input autocomplete="false"   name="content_slider_title[]" type="text" class="form-control  " id="content_slider_title[]" placeholder="" value="">' +
                '		</div>' +
                '		<div class="form-group hm-form-group" data-input-name="content_slider_description[]" data-order="0">' +
                '			<label for="content_slider_description[]">Mô tả</label>' +
                '			<textarea autocomplete="false"  name="content_slider_description[]" class="form-control  " id="content_slider_description[]"></textarea>' +
                '		</div>' +
                '		<div class="form-group hm-form-group" data-input-name="content_slider_link[]" data-order="0">' +
                '			<label for="content_slider_link[]">Link khi bấm vào</label>' +
                '			<input autocomplete="false"   name="content_slider_link[]" type="text" class="form-control  " id="content_slider_link[]" placeholder="" value="">' +
                '		</div>' +
                '	</td>' +
                '	<td>' +
                '		<span class="btn btn-danger del_content_slider_item" data-num="' + num + '">Xóa</span>' +
                '	</td>' +
                '</tr>';
            $('.content_slider_list_item').append(line);
            var new_num = parseInt(num) + 1;
            $('.add_content_slider_item').attr('data-num', new_num);
        });

        $(document).on('click', '.del_content_slider_item', function () {
            var num = $(this).attr('data-num');
            $('.content_slider_item[data-num=' + num + ']').remove();
        });

        $(".content_slider_list_item").sortable({});

    });
</script>