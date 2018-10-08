<div class="express_form_popup express_form_popup_textarea">

    <?php
    $args = [
        'nice_name' => 'Tên biểu mẫu',
        'handle' => false,
        'name' => 'label',
        'input_type' => 'text',
    ];
    build_input_form($args);

    $args = [
        'nice_name' => 'Tên biến POST',
        'handle' => false,
        'name' => 'name',
        'input_type' => 'text',
    ];
    build_input_form($args);
    ?>
    <p class="required_checkbox">
        <input type="checkbox" name="required" value="required">
        <span>Không được để trống<span>
    </p>
    <?php
    $args = [
        'nice_name' => 'Giá trị mặc định',
        'handle' => false,
        'name' => 'value',
        'input_type' => 'text',
        'description' => 'Bạn có thể lấy theo phương thức GET hoặc POST bằng các điền vào theo cấu trúc : get|parameter hoặc post|parameter, ví dụ  get|tensanpham',
    ];
    build_input_form($args);

    $args = [
        'nice_name' => 'Độ dài tối đa (ký tự)',
        'handle' => false,
        'name' => 'maxlength',
        'input_type' => 'number',
    ];
    build_input_form($args);

    $args = [
        'nice_name' => 'Placeholder',
        'handle' => false,
        'name' => 'placeholder',
        'input_type' => 'text',
    ];
    build_input_form($args);

    $args = [
        'nice_name' => 'Class của biểu mẫu',
        'handle' => false,
        'name' => 'class',
        'input_type' => 'text',
    ];
    build_input_form($args);

    $args = [
        'nice_name' => 'ID của biểu mẫu',
        'handle' => false,
        'name' => 'id',
        'input_type' => 'text',
    ];
    build_input_form($args);
    ?>
    <button class="btn btn-default add_form_input_textarea">Thêm biểu mẫu vào form</button>
    <button class="btn btn-danger close_form_popup">Hủy</button>
</div>


<script>
    $(document).ready(function () {
        /* input textarea */
        $('.express_form_popup_textarea input[name=label]').change(function () {
            var url = '?run=content_ajax.php&action=ajax_slug';
            var val = $(this).val();
            $.post(url, {val: val, accented: 'false', object: '0'}, function (data) {
                $('.express_form_popup_textarea input[name=name]').val(data);
            });
        });
        $('.add_form_input_textarea').click(function () {

            var input_attr = '';
            var label = $('.express_form_popup_textarea input[name=label]').val();
            var name = $('.express_form_popup_textarea input[name=name]').val();
            var value = $('.express_form_popup_textarea input[name=value]').val();
            var maxlength = $('.express_form_popup_textarea input[name=maxlength]').val();
            var placeholder = $('.express_form_popup_textarea input[name=placeholder]').val();
            var cssclass = $('.express_form_popup_textarea input[name=class]').val();
            var id = $('.express_form_popup_textarea input[name=id]').val();
            if (name != '') {
                input_attr = input_attr + '&name=' + name;
            } else {
                alert('Tên biến POST không thể để trống');
                return;
            }
            if ($('.express_form_popup_textarea input[name=required]').is(':checked')) {
                input_attr = input_attr + '&required=required';
            }
            if (value != '') {
                input_attr = input_attr + '&value=' + value;
            }
            if (maxlength != '') {
                input_attr = input_attr + '&maxlength=' + maxlength;
            }
            if (placeholder != '') {
                input_attr = input_attr + '&placeholder=' + placeholder;
            }
            if (cssclass != '') {
                input_attr = input_attr + '&class=' + cssclass;
            }
            if (id != '') {
                input_attr = input_attr + '&id=' + id;
            }
            var line = label + "\n" + '[shortcode=express_form&type=textarea' + input_attr + "]\n";
            var old_val = $('.express_form_template textarea').val();
            $('.express_form_template textarea').val(old_val + line);
            reset_field('textarea');
            $('.popup_overlay').hide();
            $('.express_form_popup').hide();
        });
    });
</script>