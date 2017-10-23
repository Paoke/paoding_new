<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title><?php echo ($gemmap_config['shop_info_store_title']); ?></title>    <meta name="keywords" content="<?php echo ($gemmap_config['shop_info_store_keyword']); ?>" />     <meta name="description" content="<?php echo ($gemmap_config['shop_info_store_desc']); ?>" />

  <link href="<?php echo (CSS); ?>/style.css" rel="stylesheet">
  <link href="<?php echo (CSS); ?>/style-responsive.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>
<style type="text/css">
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
                编辑地区名称
                <div class="pull-right">
                <a style="margin-top:-8px" href="/index.php/Admin/Tools/region" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回管理员列表"><i class="fa fa-reply"></i></a>
                <!-- <a href="javascript:;" class="btn btn-default" data-url="http://www.gemmap.cn/Doc/Index/article/id/1001/developer/user.html" onclick="get_help(this)"><i class="fa fa-question-circle"></i> 帮助</a> -->
                </div>
            </header>
                <div class="panel-body ">   
                    <!--表单数据-->
                    <form action="<?php echo U('Admin/Tools/updateRegion');?>" class="form-horizontal adminex-form" method="post" onsubmit="return checkName();">   
                            
                           
                            
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">* 名称：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-input"  id="name" value="<?php echo ($list["name"]); ?>" name="name"/>
                                        <span id="err_name" style="color:#F00; display:none;">名称不能为空!!</span>
                            </div>
                        </div>
                       
                       
                      
                         <div class="form-group">
                            <div class="col-sm-12 btn-group">
                               <input type="hidden" name="id" value="<?php echo ($list["id"]); ?>">
                                <input type="hidden" name="pid" value="<?php echo ($pid); ?>">
                                <input class="Preservation" type="submit" value="保存">
                            </div><!-- /btn-group -->

                            </div>
                    </form><!--表单数据-->
                        </div>
        </section>

                </div>                    

        </div>
        </section>
        </div>

             
    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?php echo (JS); ?>/jquery-1.10.2.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-ui-1.9.2.custom.min.js"></script>
<script src="<?php echo (JS); ?>/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo (JS); ?>/bootstrap.min.js"></script>
<script src="<?php echo (JS); ?>/modernizr.min.js"></script>
<script src="<?php echo (JS); ?>/jquery.nicescroll.js"></script>
 <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<!--common scripts for all pages-->
<script src="<?php echo (JS); ?>/scripts.js"></script>
<script>
// 判断输入框是否为空
function checkName(){
	var name = $("#name").val();
    if($.trim(name) == '')
	{
		$("#err_name").show();
		return false;
	}
	return true;
}
</script>
</body>
</html>