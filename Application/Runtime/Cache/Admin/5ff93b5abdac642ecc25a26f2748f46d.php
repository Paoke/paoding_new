<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>表单设计器</title>
<meta name="keyword" content="拖拽式表单设计器">
<meta name="description" content="拖拽式表单设计器">
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


<!--<link href="/Public/css/style.css" rel="stylesheet">-->
<link href="/Public/plugins/assets/css/lib/bootstrap.min.css" rel="stylesheet">
<link href="/Public/plugins/assets/css/lib/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/Public/plugins/assets/css/custom.css" rel="stylesheet">
<link href="/Public/css/define_page/Template-style.css" rel="stylesheet">
<!--<link href="/Public/css/bootstrap-reset.css" rel="stylesheet">-->

<style>
h2{ font-size: 20px; }
body { padding: 10px; padding-bottom: 10px; background: #EFF0F4; }
.main-content{ background: #fff; }
.panel-heading{ height: 40px; padding:5px; }
.wx-header { background-image: url(/Public/plugins/pageconfig/css/bootstrap/img/titlebar@2x.png); background-repeat: no-repeat; background-size: 100%; color: white; text-align: center; padding-top: 18px; line-height: 56px; }
#target fieldset{ background: #efeff4; overflow:auto; max-height: 680px; }
.tabbable{ overflow:auto; height: 680px; }
::-webkit-scrollbar{ width:5px; }
::-webkit-scrollbar-track{ background-color:#bee1eb; }
::-webkit-scrollbar-thumb{ background-color:#00aff0; }
::-webkit-scrollbar-thumb:hover { background-color:#9c3; }
::-webkit-scrollbar-thumb:active { background-color:#00aff0; }


</style>
    <script src="/Public/js/jquery-1.10.2.min.js" ></script>
    <script src="/Public/js/layer/layer.js"></script>
    <script src="/Public/js/global.js"></script>
</head>
<body>
<div class="main-content" width="100%" style="margin:0px;padding-bottom: 20px">
    <section class="wrapper">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left"> <h4>编辑自定义列表</h4></div>
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" id="postbutton" class="btn btn-default">保存</button>
                        <button type="reset" class="btn btn-default">取消</button>
                        <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                           class="btn btn-default" >返回</a>
                    </div>
                </div>
            </div>
            </div>

            <div class="row clearfix">
                    <!-- Components -->
                    <div class="span4">
                        <h2>拖放组件(下方组件拖放到右边表中)</h2>
                        <hr>
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="formtabs">
                                <!-- Tab nav -->
                            </ul>
                            <form class="form-horizontal" id="components">
                                <fieldset>
                                    <div id="comp_tab" class="tab-content">
                                        <!-- Tabs of snippets go here -->
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <!-- / Components -->

                    <!-- Building Form. -->
                    <div class="span4" style="margin-left: 50px;">
                        <div class="clearfix">
                            <h2>页面展示</h2>
                            <hr>
                            <div id="build">
                                <form id="target" class="form-horizontal">
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / Building Form. -->

        </div> <!-- /container -->
        <input type="hidden" id="id" value="<?php echo ($id); ?>">
        <input type="hidden" id="url" value="/index.php/Admin/PageConfig/page_config/action/info/id/">
    </section>
</div>
<?php if(empty($edit)): ?><script data-main="/Public/plugins/assets/js/main-built.js" src="/Public/plugins/assets/js/lib/require.js" ></script><?php endif; ?>
<?php if(!empty($edit)): ?><script data-main="/Public/plugins/assets/js/main-built-edit.js" src="/Public/plugins/assets/js/lib/require.js" ></script><?php endif; ?>
<script>
    $("#postbutton").click(function(){
        var html = $("#render").val().replace(/[\r\n]/g, '');
        var title = $(html).find("legend").text();

        var legend = $(html).find("legend").prop("outerHTML");
        html = html.replace(legend, '');
        html = encodeURI(html);
        var datas = get_page_data();

        var url = "/index.php/Admin/PageConfig/page_config/action/add";
        if($("#id").val() != null && $("#id").val() != ''){
            url = "/index.php/Admin/PageConfig/page_config/action/edit/id/"+$("#id").val();
        }
        var data = {'html': html, 'title': title, 'form_data': datas};
       // alert(JSON.stringify(data));
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(ret){
                if(ret.result == 1){
                    layer.msg(ret.msg);
                    setTimeout(function(){
                        window.location.href = "/index.php/Admin/PageConfig/page_config/action/page_list";
                    },'1500')
                }else{
                    layer.msg(ret.msg);
                }
            }
        });
    });

    function get_page_data(){
        var datas = new Array();
        $("#target .component").each(function(i, el){
            var form =  $(this).attr('data-content');
            var fdata = $(form).serializeArray();
            var title = $(this).attr('data-title');

            var data = {'title': title, 'data':fdata};
            datas[i] = data;
        });
        return datas;
    }

</script>
</body>
</html>