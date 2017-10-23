/**
 * Created by SingHome on 2016/11/9.
 */
(function () {
    $.Extends = function (arg) {
        this.genElement = function (extendJson, default_value, form) {

            var type = extendJson.form_type;
            if (default_value == undefined || default_value == null) {
                default_value = extendJson.default_value;
            }

            var $group = $('<div class="form-group"><label class="col-sm-2 control-label">' + extendJson.title + '：</label></div>');
            var $col = $('<div class="col-sm-9"></div>');

            if(default_value == null){
                default_value = '';
            }

            var $ele = null;
            switch (type) {
                case 'text':
                    $ele = $('<input type="text" class="form-control form-input"/>');
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    $ele.attr('value', default_value);
                    if(extendJson.valid_pattern != null && extendJson.valid_pattern != ''){
                        $ele.attr('datatype', extendJson.valid_pattern);
                        if(extendJson.valid_pattern == 'm'){ //手机号
                            $ele.attr('maxlength', 11);
                        }
                    }
                    if(extendJson.valid_tip_msg != null && extendJson.valid_tip_msg != ''){
                        $ele.attr('placeholder', extendJson.valid_tip_msg);
                    }
                    if(extendJson.valid_error_msg != null && extendJson.valid_error_msg != ''){
                        $ele.attr('nullmsg', extendJson.valid_error_msg);
                    }

                    $col.append($ele);
                    break;

                case 'password':
                    $ele = $('<input type="password" class="form-control form-input" autocomplete="off"/>');
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    $ele.attr('value', default_value);
                    if(extendJson.valid_pattern != null && extendJson.valid_pattern != ''){
                        $ele.attr('datatype', extendJson.valid_pattern);
                    }
                    if(extendJson.valid_tip_msg != null && extendJson.valid_tip_msg != ''){
                        $ele.attr('placeholder', extendJson.valid_tip_msg);
                    }
                    if(extendJson.valid_error_msg != null && extendJson.valid_error_msg != ''){
                        $ele.attr('nullmsg', extendJson.valid_error_msg);
                    }

                    $col.append($ele);
                    break;

                case 'textarea':
                    $ele = $('<textarea class="form-control form-input"></textarea>');
                    $ele.attr('rows', 3);
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    if(extendJson.valid_pattern != null && extendJson.valid_pattern != ''){
                        $ele.attr('datatype', extendJson.valid_pattern);
                    }
                    if(extendJson.valid_tip_msg != null && extendJson.valid_tip_msg != ''){
                        $ele.attr('placeholder', extendJson.valid_tip_msg);
                    }
                    if(extendJson.valid_error_msg != null && extendJson.valid_error_msg != ''){
                        $ele.attr('nullmsg', extendJson.valid_error_msg);
                    }

                    $ele.text(default_value);

                    $col.append($ele);
                    break;

                case 'texteditor':
                    $ele = $('<textarea class="post_content">'+default_value+'</textarea>');
                    $ele.attr('rows', 3);
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    //$ele.text(default_value);

                    $col.append($ele);

                    break;

                case 'image':

                    $col = $('<div class="col-sm-9 btn-group"></div>');

                    var $path = $('<input type="text" placeholder="" class=" form-control" ' +
                        'id="' + extendJson.name + '" name="' + extendJson.name + '" ' +
                        'value="' + default_value + '" style="width:400px;float: left;" readonly/>');
                    $col.append($path);

                    var $btnDiv = $('<div class="col-sm-3"></div>');
                    var $uploadBtn = $('<input class="btn btn-info" style="float: left;" type="button" value="上传图片" />');
                    var $preBtn = $('<button class="btn btn-info " type="button">预览</button>');
                    $btnDiv.append($uploadBtn).append('&nbsp;&nbsp;').append($preBtn);
                    $col.append($btnDiv);
                    $uploadBtn.click(function () {
                        GetUploadify(1, extendJson.name, 'extend_img', '');
                    });

                    $preBtn.click(function () {
                        preview(extendJson.name)
                    });

                    break;

                case 'cityselect':
                    $ele = $('<input type="text" class="cityinput form-control form-input"/>');
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    $ele.attr('value', default_value);
                    if(extendJson.valid_pattern != null && extendJson.valid_pattern != ''){
                        $ele.attr('datatype', extendJson.valid_pattern);
                    }
                    if(extendJson.valid_tip_msg != null && extendJson.valid_tip_msg != ''){
                        $ele.attr('placeholder', extendJson.valid_tip_msg);
                    }
                    if(extendJson.valid_error_msg != null && extendJson.valid_error_msg != ''){
                        $ele.attr('nullmsg', extendJson.valid_error_msg);
                    }
                    $col.append($ele);

                    break;

                case 'upload':

                    $col = $('<div class="col-sm-9 btn-group"></div>');
                    $path = $('<input type="text" placeholder="" class=" form-control" ' +
                        'id="' + extendJson.name + '" name="' + extendJson.name + '" ' +
                        'value="' + default_value + '" style="width:400px;float: left;" readonly/>');
                    $col.append($path);

                    $btnDiv = $('<div class="col-sm-3"></div>');
                    $uploadBtn = $('<input class="btn btn-info" style="float: left;" type="button" value="上传文件" />');
                    $btnDiv.append($uploadBtn).append('&nbsp;&nbsp;');
                    $col.append($btnDiv);

                    $uploadBtn.click(function () {
                        GetUploadifyFile(1, extendJson.name, 'extend_file', '');
                    });


                    break;

                case 'datetime':
                    $ele = $('<input class="form-control form-input laydate-icon" style="height: 35px">');
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    $ele.attr('value', default_value);
                    $col.append($ele);
                    break;

                case 'checkbox':

                    var option = extendJson.item_option;
                    var html = '';
                    $(option).each(function (i, item) {
                        var checked = '';
                        if (default_value == item.key) {
                            checked = "checked";
                        }
                        html += '<input type="checkbox"  name="' + extendJson.name + '[]" value="' + item.name + '" ' + checked + ' >' + item.name + '&nbsp;&nbsp;&nbsp;&nbsp;';
                    });

                    $col.append(html);
                    break;

                case 'radio':
                    html = '';
                    option = extendJson.item_option;
                    $(option).each(function (i, item) {
                        var checked = '';
                        if (default_value == item.name) {
                            checked = "checked";
                        }
                        html += '<input type="radio" name="' + extendJson.name + '" value="' + item.name + '" '+checked+'>' + item.name + '&nbsp;&nbsp;&nbsp;&nbsp;';
                    });

                    $col.append(html);
                    break;

                case 'select':

                    option = extendJson.item_option;
                    var $select = $('<select class="small form-option" style="font-size: 14px;"></select>');
                    $select.attr('id', extendJson.name);
                    $select.attr('name', extendJson.name);
                    $(option).each(function (i, item) {
                        var selected = '';
                        if (default_value == item.value) {
                            selected = "selected";
                        }
                        var op = '<option value="'+item.value+'" '+selected+'>'+item.name+'</option>';
                        $select.append(op);
                    });

                    $col.append($select);
                    break;

                default:
                    $ele = $('<input type="text" class="form-control form-input"/>');
                    $ele.attr('id', extendJson.name);
                    $ele.attr('name', extendJson.name);
                    $ele.attr('value', default_value);
                    $col.append($ele);
                    if(extendJson.valid_pattern != null && extendJson.valid_pattern != ''){
                        $ele.attr('datatype', extendJson.valid_pattern);
                    }
                    if(extendJson.valid_tip_msg != null && extendJson.valid_tip_msg != ''){
                        $ele.attr('placeholder', extendJson.valid_tip_msg);
                    }
                    if(extendJson.valid_error_msg != null && extendJson.valid_error_msg != ''){
                        $ele.attr('nullmsg', extendJson.valid_error_msg);
                    }
                    break;

            }
            $group.append($col);
            $("#"+form).append($group);

        }

    };

})(jQuery);

/**
 * @param url 获取扩展字段的url
 * @param id 记录ID
 * @param extends_div 控件添加到div的id
 * */
function loadExtends(site, url, record_id, div_id) {
    $.ajax({
        type: "post",
        url: url,
        data: {'id': record_id},
        async: false,
        dataType: 'json',
        success: function (ret) {
            if(ret.result == 1){
                var $E = new $.Extends();
                $(ret.data).each(function (i, item) {
                    $E.genElement(item, item.default_value, div_id);
                    if (item.form_type == 'texteditor') {
                        initUEditor(site, item.name);

                    }else if (item.form_type == 'datetime') {
                        var dateTime = null;
                        if(item.date_format == 'date'){
                            dateTime = {
                                elem: '#' + item.name,
                                format: 'YYYY-MM-DD',
                                istime: false, //开启时分秒
                                istoday: true
                            };
                        }else{
                            dateTime = {
                                elem: '#' + item.name,
                                format: 'YYYY-MM-DD hh:mm:ss',
                                istime: true, //开启时分秒
                                istoday: true
                            };
                        }

                        laydate(dateTime);
                    }else if(item.form_type == 'cityselect'){
                        new Vcity.CitySelector({input: item.name});
                    }
                });

            }else{
                layer.msg(ret.msg);
            }


        }
    });
}