<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title><?php echo ($seoTitle); ?></title>
	<link rel="shortcut icon" href="/Template/5u/mobile/Static/img/favicon.ico">
	<meta name="keywords" content="<?php echo ($seoKeywords); ?>">
	<meta name="description" content="<?php echo ($seoDescription); ?>">
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/weui.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/swiper.min.css"/>
	<link rel="stylesheet" type="text/css" href="/Template/5u/mobile/Static/css/index.css"/>
	<script>
		//百度统计
		var _hmt = _hmt || [];
		(function() {
			var hm = document.createElement("script");
			hm.src = "https://hm.baidu.com/hm.js?f095b63fbc1984edb5ae1cef37dd08a6";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(hm, s);
		})();
		//清除信息
		<?php if(!empty($clearAll)): ?>if(localStorage.getItem("clearAll") && localStorage.getItem("clearAll") == <?php echo ($clearAll); ?>){
			localStorage.clear();
		}<?php endif; ?>
	</script>
</head>
<section id="template">
	<body>
		<div class="web">
			<div class="tDetail_head">
				<img style="width: 100%;" class="blur" src="/Template/5u/mobile/Static/img/topic_head.png"/>
	        	<div class="section">
	        		<a href="#" class="weui-media-box weui-media-box_appmsg" style="margin-top: 28px;">
	                    <div class="weui-media-box__hd" style="width: 184px;height: 37.5px;" >
	                        <!--<img style="height: 100%;" class="weui-media-box__thumb" src="/Template/5u/mobile/Static/img/topic_t.png" alt="">-->
							<div class="weui-media-box__bd">
								<p class="weui-media-box__title ztgl" v-for="list in listData"  style="font-size: 16px; color: #f3f4f8;" v-text="list.t_name"></p>
							</div>
	                    </div>

	                </a>
	        	</div>
			</div>
			<div class="tDetail_body">
				<div class="weui-cell" style="margin-top: 5px;padding: 10px;">
	                <div class="weui-cell__bd">
	                    <p style="font-size: 14px;color: #333333;">专题技术</p>
	                </div>
	            </div>
	            <div class="weui-panel weui-panel_access" style="margin-top: 0px;">
		            <div class="weui-panel__bd">
		           <li v-for="list in listData">
		            	<a @click="getDetail(list.id)" class="weui-media-box weui-media-box_appmsg">
		                    <div class="weui-media-box__hd" style="width: 100px;height: 75px;">
		                        <img style="height: 100%;" class="weui-media-box__thumb" v-bind:src="list.cover_url" >
		                    </div>
		                    <div class="weui-media-box__bd">
		                        <h4 class="weui-media-box__title" v-text="list.title"></h4>
		                        <p class="weui-media-box__desc" v-text="list.desc"></p>
		                    </div>
		                </a>
		                <div class="index_sectionB">
							<p class="index_sectionB1" v-text="list.cat_name"></p>
							<p class="index_sectionB5" v-text="list.clicks">阅读</p>
							<p class="index_sectionB3" v-text="list.csd" ></p>
						</div>
				   </li>
		            </div>
		            <!-- <div class="weui-panel__ft index_body_foot1">
		                <div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
		                    <div class="weui-cell__bd" style="text-align: center;">查看更多</div>
		                </div> 
		            </div>
		            <div class="page__bd index_body_foot2" style="display: none;">
				        <div class="weui-loadmore">
				            <i class="weui-loading"></i>
				            <span class="weui-loadmore__tips">正在加载</span>
				        </div>
				    </div>
				    <div class="page__bd index_body_foot3" style="display: none;">
				        <div class="weui-loadmore weui-loadmore_line">
				            <span class="weui-loadmore__tips">暂无数据</span>
				        </div>
				    </div> -->
		        </div>
			</div>
		</div>
	</body>
</section>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
			categoryData: '',
			configData:'',
			ztData:'',
			countData:'',
			page : 1,
			page_total:0,
			show_prex:false,
			show_next:1,
			show_item:5,
			bool : 'true',
			category_id: 0
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getNew();
				this.getZt();
			})
		},
		updated:function(){
		},
		filters: {
		},
		methods:{
			getNew:function(){
				var _this=this;
				var href=window.location.href;;
				var id=href.substr(-1);
				var url="/<?php echo (API_PATH); ?>/Paoding/getData";
				var data={
					"sszt":id,
					"page": 1,
					"page_num":10,
					"order_by":"DESC"
				};
				$.post(url, data, function(res){
					_this.listData=res.data;
				}, 'json');
			},

			getZt:function(id){
				var _this=this;
				var url="/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/ztgl/type/1";
				var data={
					"sszt":id,
				};
				$.get(url,data,function(res){
					_this.ztData = res.data;
				});
			},
			showDetail:function (url) {
				window.location.href=url;
			},
			getDataDetail:function (id) {
				window.location.href="/index.php/Mobile/Article/detail/channel/xq/type/1/data_id/"+id;
			},

			search:function(category_id,isMore){
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/js/type/1/category_id/"+category_id;
				if(category_id > 0){
					vm.category_id = category_id;
					url += "/category_id/"+category_id;
				}
				var _this = this;
				var data={
					"order_field":"create_time",
					"order_by":"DESC",
					"get_page": true,
					"page": vm.page,
					"page_num":10
				};
				$.post(url,data, function (res) {
					if(isMore){
						vm.listData = vm.listData.concat(res.data.info);
					}else{
						_this.listData = res.data.info;
					}
					var page = res.data.page;
					vm.page = parseInt(page.page);
					vm.page_total = parseInt(page.page_total);
					vm.show_first = (vm.page-1 > 1);
					vm.show_prex = (vm.page-1 > 0);
					vm.show_next = (vm.page_total-vm.page > 0);
					vm.show_end = (vm.page_total-vm.page > 1);
				})
			},
			go_page: function(page){
				if(page == vm.page){
					return;
				}
				vm.page =page;
				this.search(vm.category_id,true);
			},
		}
	});
</script>
	<script type="text/javascript">
		/* $(".index_body_foot1").click(function(){
			var _s =this;
			$(this).css("display","none");
			$(this).siblings(".index_body_foot2").css("display","block");
			setTimeout(function(){
				var result="";
				for(i=0;i<15;i++){
					result += '<a href="detaile.html" class="weui-media-box weui-media-box_appmsg"><div class="weui-media-box__hd"style="width: 100px;height: 75px;"><img style="height: 100%;" class="weui-media-box__thumb" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAAAeFBMVEUAwAD///+U5ZTc9twOww7G8MYwzDCH4YcfyR9x23Hw+/DY9dhm2WZG0kbT9NP0/PTL8sux7LFe115T1VM+zz7i+OIXxhes6qxr2mvA8MCe6J6M4oz6/frr+us5zjn2/fa67rqB4IF13XWn6ad83nxa1loqyirn+eccHxx4AAAC/klEQVRo3u2W2ZKiQBBF8wpCNSCyLwri7v//4bRIFVXoTBBB+DAReV5sG6lTXDITiGEYhmEYhmEYhmEYhmEY5v9i5fsZGRx9PyGDne8f6K9cfd+mKXe1yNG/0CcqYE86AkBMBh66f20deBc7wA/1WFiTwvSEpBMA2JJOBsSLxe/4QEEaJRrASP8EVF8Q74GbmevKg0saa0B8QbwBdjRyADYxIhqxAZ++IKYtciPXLQVG+imw+oo4Bu56rjEJ4GYsvPmKOAB+xlz7L5aevqUXuePWVhvWJ4eWiwUQ67mK51qPj4dFDMlRLBZTqF3SDvmr4BwtkECu5gHWPkmDfQh02WLxXuvbvC8ku8F57GsI5e0CmUwLz1kq3kD17R1In5816rGvQ5VMk5FEtIiWislTffuDpl/k/PzscdQsv8r9qWq4LRWX6tQYtTxvI3XyrwdyQxChXioOngH3dLgOFjk0all56XRi/wDFQrGQU3Os5t0wJu1GNtNKHdPqYaGYQuRDfbfDf26AGLYSyGS3ZAK4S8XuoAlxGSdYMKwqZKM9XJMtyqXi7HX/CiAZS6d8bSVUz5J36mEMFDTlAFQzxOT1dzLRljjB6+++ejFqka+mXIe6F59mw22OuOw1F4T6lg/9VjL1rLDoI9Xzl1MSYDNHnPQnt3D1EE7PrXjye/3pVpr1Z45hMUdcACc5NVQI0bOdS1WA0wuz73e7/5TNqBPhQXPEFGJNV2zNqWI7QKBd2Gn6AiBko02zuAOXeWIXjV0jNqdKegaE/kJQ6Bfs4aju04lMLkA2T5wBSYPKDGF3RKhFYEa6A1L1LG2yacmsaZ6YPOSAMKNsO+N5dNTfkc5Aqe26uxHpx7ZirvgCwJpWq/lmX1hA7LyabQ34tt5RiJKXSwQ+0KU0V5xg+hZrd4Bn1n4EID+WkQdgLfRNtvil9SPfwy+WQ7PFBWQz6dGWZBLkeJFXZGCfLUjCgGgqXo5TuSu3cugdcTv/HjqnBTEMwzAMwzAMwzAMwzAMw/zf/AFbXiOA6frlMAAAAABJRU5ErkJggg==" alt=""></div><div class="weui-media-box__bd"><h4 class="weui-media-box__title">多功能快速油质分析仪器</h4><p class="weui-media-box__desc">可现场、快速分析油品的粘度、密度、温度、高度广度和</p></div></a>';
				}
		        $(_s).parent().find(".weui-panel__bd").append(result);
		        $(_s).css("display","block");
				$(_s).siblings(".index_body_foot2").css("display","none");
			},1000)
		}) */
	</script>
</html>