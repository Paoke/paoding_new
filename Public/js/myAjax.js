/**
 * Created by admin on 2015/9/21.
 */

/**
 *  Ajax通用提交表单
 *  @var  form表单的id属性值  form_id
 *  @var  提交地址 subbmit_url
 */

function post_form(form_id,subbmit_url){
    if(form_id == '' && subbmit_url == ''){
        alert('缺少必要参数');
        return false;
    }
    //  序列化表单值
    var data = $('#'+form_id).serialize();

    $.post(subbmit_url,data,function(result){
        var obj = $.parseJSON(result);
        if(obj.status == 0){
            alert(obj.msg);
            return false;
        }
        if(obj.status == 1){
            alert(obj.msg);
            if(obj.data.return_url){
                //  返回跳转链接
                location.href = obj.data.return_url;
            }else{
                //  刷新页面
                location.reload();
            }
            return;
        }
    })
}


/**
 * 删除
 * @returns {void}
 */
function del_fun(del_url)
{
    if(confirm("确定要删除吗?"))
        location.href = del_url;
}  


// 修改指定表的指定字段值
function changeTableVal(mod_id,table,id_name,id_value,field,obj,is_system)
{
		var src = "";

    if(is_system==1)
    {
        layer.msg("系统内置，不允许更改",{icon:2});
        return;
    }
		 if($(obj).attr('src').indexOf("cancel.png") > 0 )
		 {          
				src = '/Public/images/yes.png';
				var value = 1;
				
		 }else{                    
				src = '/Public/images/cancel.png';
				var value = 0;
		 }                                                 
		$.ajax({
				url:"/index.php?m=Admin&c=Index&a=changeTableVal&mod_id="+mod_id+"&table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
                dataType:'json',
                success: function(res){
                    if (res.status == 1) {
                        $(obj).attr('src',src);
                        location.reload();
                    }else if(res.status == 0) {
                        layer.msg(res.msg,{icon:2});
                    }else {
                        $(obj).attr('src',src);
                    }
				}
		});		
}

// 修改指定表的指定字段值
function changeTableField(mod_id,table,id_name,id_value,field,obj,is_system)
{
    var src = "";

    if(is_system==1)
    {
        layer.msg("系统内置，不允许更改",{icon:2});
        return;
    }
    if($(obj).attr('src').indexOf("cancel.png") > 0 )
    {
        src = '/Public/images/yes.png';
        var value = 0;

    }else{
        src = '/Public/images/cancel.png';
        var value = 1;
    }
    $.ajax({
        url:"/index.php?m=Admin&c=Index&a=changeTableVal&mod_id="+mod_id+"&table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
        dataType:'json',
        success: function(res){
            if (res.status == 1) {
                $(obj).attr('src',src);
                location.reload();
            }else if(res.status == 0) {
                layer.msg(res.msg,{icon:2});
            }else {
                $(obj).attr('src',src);
            }
        }
    });
}

// 修改指定表的排序字段
function updateSort(mod_id,table,id_name,id_value,field,obj)
{		       
 		var value = $(obj).val();
		$.ajax({
				url:"/index.php?m=Admin&c=Index&a=changeTableVal&mod_id="+mod_id+"&table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
				success: function(data){
                    if(data==2)
					layer.msg('更新成功', {icon: 1});
                    else
                    layer.alert(data);
				}
		});		
}

// 修改指定表的排序字段
function updateSelect(table,id_name,id_value,field,obj)
{              
        var value = $(obj).val();
        $.ajax({
                url:"/index.php?m=Admin&c=Index&a=changeTableVal&table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,           
                success: function(data){                                    
                    layer.msg('更新成功', {icon: 1});   
                }
        });     
}

// 修改指定表的某个字段自加一 例如点击量 阅读量
function updateClick(table,id_name,id_value,field)
{
    $.ajax({
        url:"/index.php?m=Admin&c=Index&a=changeClickVal&table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field,
        success: function(data){
               console.log(data);
        }
    });
}