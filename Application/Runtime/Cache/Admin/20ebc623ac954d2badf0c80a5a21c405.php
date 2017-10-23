<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title></title>
    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>"/>
    <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>"/>

    <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
    <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

    <!-- jQuery 2.1.4 -->
    <script src="/Public/js/global.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">

    .fr {
        float: right;
    }

    .caption h2 {
        font-size: 24px;
        line-height: 18px;
        font-weight: 700;
    }

    .option {
        height: 27px;
        width: 145px;
    }

    .form-input {
        width: 400px;
        display: inline-block;
    }

    .panel-body {
        padding: 15px;
        border: 1px solid #e6e8eb;
        margin-top: -1px;
    }

    .radio input[type=radio], .radio-inline input[type=radio], .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox] {
        float: none;
        margin-left: 10px;
    }

    .input-group-addon {
        padding: 5px 20px;
    }
    .control-label  input{    width: 20px;
        height: 20px;
        background-color: #ffffff;
        border: solid 1px #dddddd;
        -webkit-border-radius:50%;
        border-radius: 50%;
        font-size: 16px;
        margin: 0;
        padding: 0;
        position: relative;
        display: inline-block;
        vertical-align: top;
        cursor: default;
        -webkit-appearance: none;
        -webkit-user-select: none;
        user-select: none;
        -webkit-transition: background-color ease 0.1s;
        transition: background-color ease 0.1s;
    }
    .control-label  input:hover{cursor:pointer;}
    .control-label  input:focus { outline: none !important; }
    .control-label  input:checked{    background-color: #03a9f4;
        border: solid 1px #03a9f4;
        text-align: center;
        background-clip: padding-box;
        border:none;
    }
    .control-label  input:checked:before{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);}

    .control-label  input:checked:after{    content: '';
        width: 10px;
        height: 6px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -5px;
        margin-top: -5px;
        background: transparent;
        border: 1px solid #ffffff;
        border-top: none;
        border-right: none;
        z-index: 2;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }
    .sh{
        display: -webkit-box;
        letter-spacing: 1px;
        min-height:200px;
    }

</style>

<body class="sticky-header">
<section>

    <!-- main content start-->
    <div class="main-content" width="100%" style="margin:0px;">
        <!--body wrapper start-->
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            用户详细信息
                            <div class="pull-right">
                                <?php if($Authen["status"] == -1): ?><a href="javascript:;" onclick="tab(0)"  data-toggle="tooltip" title=""
                               class="btn btn-default">通过</a>
                                <?php elseif($Authen["status"] == 0): ?>
                                <a href="javascript:;" onclick="tab(-1)"  data-toggle="tooltip" title=""
                                   class="btn btn-default">不通过</a>
                                    <?php else: ?>
                                    <a href="javascript:;" onclick="tab(-1)"  data-toggle="tooltip" title=""
                                       class="btn btn-default">不通过</a>
                                    <a href="javascript:;" onclick="tab(0)"  data-toggle="tooltip" title=""
                                       class="btn btn-default">通过</a><?php endif; ?>
                            </div>
                        </header>
                        <div class="">
                            <form  class="adminex-form" method="post" id="Authen">
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">昵称:</span>
                                        <span><?php echo ($Authen["nickname"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">真实姓名: </span>
                                        <span><?php echo ($Authen["user_name"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">联系电话: </span>
                                        <span><?php echo ($Authen["mobile"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">邮箱: </span>
                                        <span><?php echo ($Authen["email"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">公司: </span>
                                        <span><?php echo ($Authen["company_name"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">技术领域: </span>
                                        <span><?php echo ($Authen["tech_field"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">所在城市: </span>
                                        <span><?php echo ($Authen["city"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">认证状态: </span>
                                        <?php if($Authen["status"] == 0): ?><span>通过</span>
                                            <?php elseif($Authen["status"] == 1): ?>
                                                <span>待审核</span>
                                            <?php else: ?>
                                            <span>不通过</span><?php endif; ?>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">注册时间: </span>
                                        <span><?php echo ($Authen["add_time"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">统一社会信用代码/身份证号码: </span>
                                        <span><?php echo ($Authen["company_code"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">希望展示的内容: </span>
                                        <span class="sh"><?php echo ($Authen["desc"]); ?></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">专利: </span>
                                        <?php if($Authen["has_patent"] == 1): ?><span>有</span>
                                            <?php else: ?>
                                            <span>无</span><?php endif; ?>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">营业执照: </span>
                                        <button type="button" id="company_pic"  value="<?php echo ($Authen["company_pic"]); ?>" class="btn btn-default "
                                                onclick="savepic()"><i class="fa fa-cloud-download"></i>下载
                                        </button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <span class="col-md-2">技术资料: </span>
                                        <button type="button" id="tech_file" value="<?php echo ($Authen["tech_file"]); ?>"  class="btn btn-default "
                                                onclick="dataFile()"><i class="fa fa-cloud-download"></i>下载
                                        </button>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="nav-button ">
                                        <?php if($Authen["has_patent"] == 1): ?><span class="col-md-2">专利资料: </span>
                                            <button type="button" id="patent_file" value="<?php echo ($Authen["patent_file"]); ?>" class="btn btn-default "
                                                    onclick="infoFile()"><i class="fa fa-cloud-download"></i>下载
                                            </button><?php endif; ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </section><!--表单数据-->
        <form id="download_form" name="download_form" method="post" action="/index.php/Admin/User/download">
            <input type="hidden" id="download_img" name="image" value="">
        </form>
        <form id="downfile_form" name="downfile_form" method="post" action="/index.php/Admin/User/attachments">
            <input type="hidden" id="downfile_img" name="file" value="">
        </form>
        <form id="downfiles_form" name="downfiles_form" method="post" action="/index.php/Admin/User/patent">
            <input type="hidden" id="downfiles_img" name="files" value="">
        </form>

    </div>
    </div>


    </div>
    <!-- main content end-->
</section>
<script type="text/javascript" src="<?php echo (JS); ?>/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo (JS); ?>/Validform_v5.3.2_min.js"></script>
<script type="text/javascript">
    $('.adminex-form').Validform({
        tiptype: 3
    });
</script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script src="/Public/js/laydate/laydate.js"></script>
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
   function tab(status){
       var url = "/index.php/Admin/User/identityVerify/action/update_status";
       var id = "<?php echo ($id); ?>";
       var  data={"id":id, "status":status};
       $.post(url,data,function(res){
         if(res.result==1){
             layer.msg("审核通过");
            location.href="/index.php/Admin/User/identityVerify/action/page_list/tab/<?php echo ($tab); ?>";
         }else {
             layer.msg("审核失败");
         }
       })
   }


    function infoFile(){
        var file=$("#patent_file").val();
        $("#downfiles_img").val(file);
        $("#downfiles_form").submit();
    }
function dataFile(){
    var file=$("#tech_file").val();
    $("#downfile_img").val(file);
    $("#downfile_form").submit();
}
function savepic(){
    var pic=$("#company_pic").val();
    //window.location.href = "/image/index.php/Admin/User/download/"+encodeURI(pic);
    $("#download_img").val(pic);
    $("#download_form").submit();
   /* $.ajax({
        url:"/index.php/Admin/User/download",
        data:{"image":pic},
        type:'get',
        dataType:'json',
        success:function(data){

        }
    });*/
}

</script>


<script>
    document.getElementById("authentication").value="<?php echo ($user["authentication"]); ?>";
    function preview(id) {
        var src = "";
        if ( $( '#' + id ).val() ) {
            src = $( '#' + id ).val();
        } else {
            src = $( '#' + id ).attr( "src" );
        }

        var content;
        if (src == "") {
            content = '没有图片可供预览';
            layer.msg(content);
        }
        else {
            content = "<img width='300' height='300' src='" + src + "'>";
            layer.open({
                type: 1,
                title: false,
                closeBtn: false,
                area: ['300px', '300px'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: content
            });
        }
    }    //表单提交判断，id为空则URL表示添加，否则表示编辑
    function ajax_submit_form(form_id) {
        //判断id值是否存在
        var id = $("#id").val();
        var action = '';
        if (id == '') {
            //不存在，表示添加
            action = "/index.php/Admin/User/user/action/add";
        } else {
            //存在，表示编辑
            action = "/index.php/Admin/User/user/action/edit/id/<?php echo ($user["user_id"]); ?>";
        }
        //异步提交表单数据
        $.ajax({
            type: "post",
            url: action,
            data: $('#' + form_id).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.result == 1) {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        window.location.href = "/index.php/Admin/User/user/action/page_list";
                    }, 1000);
                }
                if (res.result == 0) {
                    layer.msg(res.msg);
                }
            }
        })
    }
</script>
</body>
</html>