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
			<div class="search_search">
				<div class="weui-search-bar weui-search-bar_focusing" id="searchBar">
		            <form class="weui-search-bar__form" action="/index.php/Mobile/Article/search/channel/<?php echo ($channel); ?>">
		                <div class="weui-search-bar__box">
		                    <i class="weui-icon-search"></i>
		                    <input name="keyword" type="search" class="weui-search-bar__input" id="keyword" placeholder="搜索" required="" value="<?php echo ($_GET['keyword']); ?>">
		                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
		                </div>
		                <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
		                    <i class="weui-icon-search"></i>
		                    <span @click="search()">搜索</span>
		                </label>
		            </form>
		            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel2">取消</a>
		        </div>
			</div>
			<!--<if condition="$search neq null">-->
			<div class="index_body">
				<div class="weui-panel weui-panel_access index_section index_section_active" data-page="1">
		            <div class="weui-panel__bd">
		            	<li v-for="list in listData">
			                <a @click="getDetail(list.id)" class="weui-media-box weui-media-box_appmsg">
			                    <div class="weui-media-box__hd" style="width: 100px;height: 75px;">
			                        <img style="height: 100%;" class="weui-media-box__thumb" v-bind:src="list.cover_url">
			                    </div>
			                    <div class="weui-media-box__bd">
									<h4 class="weui-media-box__title">{{list.title}}</h4>
									<p class="weui-media-box__desc">{{list.desc}}</p>
			                    </div>
			                </a>
			                <div class="index_sectionB">
								<p class="index_sectionB1">{{list.cat_name}}</p>
								<p class="index_sectionB5">{{list.clicks}}阅读</p>
								<p class="index_sectionB3">{{list.csd}}</p>
							</div>
						</li>
		            </div>
		            <div class="weui-panel__ft index_body_foot1">
		                <div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
		                    <div class="weui-cell__bd" style="text-align: center;" @click="go_page(page+1)" v-if="show_next">查看更多</div>
		                </div>    
		            </div>
		            <div class="page__bd index_body_foot2" style="display: none;">
						<div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
							<div class="weui-cell__bd" style="text-align: center;" @click="go_page(page+1)" v-if="show_next">查看更多</div>
						</div>
				    </div>
				    <div class="page__bd index_body_foot3" style="display: none;">
				        <div class="weui-loadmore weui-loadmore_line">
				            <span class="weui-loadmore__tips">暂无数据</span>
				        </div>
				    </div>
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
			page : 1,
			page_total:0,
			show_prex:false,
			show_next:false,
			show_item:5,
			bool : 'true',
			category_id: 0
		},
		computed:{
			pages:function(){
				var pag = [];
				if( this.page < this.show_item ){
					//如果当前的激活的项 小于要显示的条数
					//总页数和要显示的条数那个大就显示多少条
					var i = Math.min(this.show_item,this.page_total);
					while(i){
						pag.unshift(i--);
					}
				}else{ //当前页数大于显示页数了
					var middle = this.page - Math.floor(this.show_item / 2 ),//从哪里开始
							i = this.show_item;
					if( middle >  (this.page_total - this.show_item)  ){
						middle = (this.page_total - this.show_item) + 1
					}
					while(i--){
						pag.push( middle++ );
					}
				}
				return pag
			}
		},
		mounted: function () {
			this.$nextTick(function () {
				this.getData();
				var postData={
					"search":$("#keyword").val()
				};
			})
		},
		updated:function(){
		},
		filters: {
		},
		methods:{
			getData:function (){
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/xq/type/1";
				vm.url=url;
				var search=$("#keyword").val();
				var data={
					"order_field":"create_time",
					"order_by":"DESC",
					"search":search,
					"get_page": true,
					"page": vm.page,
					"page_num":20

				};
				$.post(url, data,function (res) {
					_this.listData = res.data.info;
					var page = res.data.page;
					vm.page = parseInt(page.page);
					vm.page_total = parseInt(page.page_total);
					vm.show_first = (vm.page-1 > 1);
					vm.show_prex = (vm.page-1 > 0);
					vm.show_next = (vm.page_total-vm.page > 0);
					vm.show_end = (vm.page_total-vm.page > 1);
				})
			},


			getDetail:function (id) {
				window.location.href="/index.php/Mobile/Article/detail/channel/js/type/1/data_id/"+id;
			},
			showDetail:function (url) {
				window.location.href=url;
			},

			search:function(){
				var _this = this;
				_this.listData=0;
				var postData="{search:'"+$("#keyword").val()+"'}";
			},

			go_page: function(page){
				if(page == vm.page){
					return;
				}
				vm.page = parseInt(page);
				this.getData(vm.url);
			},
		}
	});
</script>















	<script type="text/javascript">
		function pullUpAction (dom,_s) {
			var pageNum = $(dom).attr("data-page");
			var keyword = $('#searchInput').val();
			console.log(keyword);
			$.ajax({
				url:"<?php echo U('Science/science_search');?>",
				data:{page:pageNum++,keyword:keyword},
				type:'post',
				dataType:'json',
				success:function(science){
					if(science == ''){
						$(_s).siblings(".index_body_foot2").css("display","none");
						$(_s).siblings(".index_body_foot3").css("display","block");
					}else{
						addHtml(science,dom,_s);
					}
				}
			});
			
			$(dom).attr("data-page",pageNum);
		}
		function addHtml(datas,dom,_s){
			var result="";
			for(i=0;i<datas.length;i++){
				var data = datas[i];
				result +='<a class="weui-media-box weui-media-box_appmsg" href="<?php echo U('Science/science_info','','');?>/domain_id/'+data.domain_id+'/science_id/'+data.science_id+'">'+
		                    '<div class="weui-media-box__hd" style="width: 100px;height: 75px;">'+
		                    	'<img style="height: 100%;" class="weui-media-box__thumb" src="'+data.banner+'"></div>'+
		                    '<div class="weui-media-box__bd">'+
		                    	'<h4 class="weui-media-box__title">'+data.science_name+'</h4>'+
		                        '<p class="weui-media-box__desc">'+data.science_intro+'</p></div></a>'+
		                '<div class="index_sectionB">'+
							'<p class="index_sectionB1">'+data.domain+'</p>'+
							'<p class="index_sectionB5">'+data.focus+'阅读</p>'+
							'<p class="index_sectionB3">'+data.level_name+'</p></div>';
			}
			$(_s).siblings(".weui-panel__bd").append(result);
			$(_s).siblings(".index_body_foot2").css("display","none");
			$(_s).css("display","block");
		}
		
		$(".index_body_foot1").click(function(){
			var _s = this;
			var dom = $(this).parents();
			$(this).css("display","none");
			$(this).siblings(".index_body_foot2").css("display","block");
			pullUpAction(dom,_s);
		})
	</script>
</html>