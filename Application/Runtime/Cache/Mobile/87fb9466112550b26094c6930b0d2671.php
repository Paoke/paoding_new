<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title><?php echo ($seoTitle); ?></title>
	<meta name="keywords" content="<?php echo ($seoKeywords); ?>">
	<link rel="shortcut icon" href="/Template/5u/mobile/Static/img/favicon.ico">
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
		<div class="index_search">
			<div class="weui-search-bar weui-search-bar_focusing" id="searchBar">
				<form class="weui-search-bar__form" action="/index.php/Mobile/Article/search/channel/<?php echo ($channel); ?>">
					<div class="weui-search-bar__box">
						<i class="weui-icon-search"></i>
						<input name="keyword" type="search" class="weui-search-bar__input" id="searchInput" placeholder="输入关键字搜索" required="">
						<a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
					</div>
					<label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
						<i class="weui-icon-search"></i>
						<span>搜索</span>
					</label>
				</form>
				<a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
			</div>
		</div>
		<div class="index_zhe"></div>
		<div class="index_xuan">
			<!--<div class="weui-cells">-->
			<div class="weui-cell"style="padding: 15px;font-size: 12px;">
				<div class="weui-cell__bd">
					<p class="">请选择需要显示在首页的专题</p>
				</div>
			</div>
			<!--</div>-->
			<div class="weui-cells weui-cells_checkbox" style="margin-top:0px;height:96%;overflow: auto;">
				<li v-for="category in categoryData">
					<label class="weui-cell weui-check__label"  style="padding: 10px;font-size: 12px;">
						<div class="weui-cell__hd">
							<input type="checkbox" class="weui-check" name="test" v-bind:value="category.cat_name" v-bind:id="category.id">
							<i class="weui-icon-checked"></i>
						</div>
						<div class="weui-cell__bd">
							<p >{{category.cat_name}}</p>
						</div>
					</label>
				</li>
				<div class="index_xuan_footK"></div>
			</div>

			<div class="index_xuan_foot">
				<a href="javascript:;" class="weui-btn weui-btn_primary" id="index_xuan_bt" style="background: #FF7800;" onclick="submit()">保存</a>
			</div>
		</div>
		<div class="index_head">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<li class="science_tabLi">
						<a href="/index.php/Mobile/Article/js_list" data-i="0" class="swiper-slide index_head_active">最新</a>
					</li>
					<li v-for="category in categoryData" class="science_tabLi">
						<a @click="getDataByCategory(category.id)" v-bind:id="'tab_'+category.id"  class="swiper-slide" v-text="category.cat_name"></a>
					</li>
				</div>
			</div>
			<div class="chevron-down"><img src="/Template/5u/mobile/Static/img/index_down.png"/></div>
			<div class="search"><img src="/Template/5u/mobile/Static/img/index_search.png"/></div>
		</div>
		<div class="index_body">
			<div data-id="0" class="weui-panel weui-panel_access index_section index_section_active" data-page="1"  type="new">
				<div class="weui-panel__bd" id="Dissimilarity">
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
							<!--<p class="index_sectionB3"><?php echo ($v["level_name"]); ?></p>-->
							<p class="index_sectionB3">{{list.csd}}</p>
						</div>
					</li>
				</div>
				<div class="weui-panel__ft index_body_foot1">
					<div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
						<div class="weui-cell__bd" style="text-align: center;" @click="go_page(page+1)">查看更多 </div>
					</div>
				</div>
				<div class="page__bd index_body_foot2" style="display: none;">
					<div class="weui-cell weui-cell_access weui-cell_link" style="padding: 10px;">
						<div class="weui-cell__bd" style="text-align: center;" @click="go_page(page+1)" >查看更多 </div>
					</div>
				</div>				<div class="page__bd index_body_foot3" style="display: none;">

					<div class="weui-loadmore weui-loadmore_line">
						<span class="weui-loadmore__tips">暂无数据</span>
					</div>
				</div>
			</div>
			<?php if(is_array($others['data'])): foreach($others['data'] as $k=>$val): ?><div data-id="<?php echo ($k); ?>" class="weui-panel weui-panel_access index_section" data-page="1" type="<?php echo ($k); ?>">
					<div class="weui-panel__bd">
						<?php if(is_array($val)): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="" class="weui-media-box weui-media-box_appmsg">
								<div class="weui-media-box__hd" style="width: 100px;height: 75px;">
									<img style="height: 100%;" class="weui-media-box__thumb" src="<?php echo ($v["banner"]); ?>">
								</div>
								<div class="weui-media-box__bd">
									<h4 class="weui-media-box__title"><?php echo ($v["science_name"]); ?></h4>
									<p class="weui-media-box__desc"><?php echo ($v["science_intro"]); ?></p>
								</div>
							</a>
							<div class="index_sectionB">
								<p class="index_sectionB1"><?php echo ($v["domain"]); ?></p>
								<p class="index_sectionB5"><?php echo ($v["focus"]); ?>阅读</p>
								<p class="index_sectionB3"><?php echo ($v["level_name"]); ?></p>
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<?php if($val == null): ?><div class="page__bd index_body_foot3" style="display: block;">
							<div class="weui-loadmore weui-loadmore_line">
								<span class="weui-loadmore__tips">暂无数据</span>
							</div>
						</div>
						<?php else: ?>
						<div class="weui-panel__ft index_body_foot1">
							<div class="weui-cell weui-cell_access weui-cell_link">
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
						</div><?php endif; ?>
				</div><?php endforeach; endif; ?>
		</div>
		<a href="/index.php/Mobile/Index/science_js"><div class="index_send"><p>发布技术</p></div></a>

	</div>
	</body>
</section>
<script src="/Template/5u/mobile/Static/js/jquery-2.1.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/Template/5u/mobile/Static/js/index.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/home/js/jquery.md5.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/Public/js/vue.js"></script>
<script type="text/javascript">
	function submit(){
				obj = document.getElementsByName("test");
				var html='<li class="science_tabLi"><a href="/index.php/Mobile/Article/js_list" data-i="0" class="swiper-slide index_head_active">最新</a></li>';
				for(var i=0; i<obj.length; i++){
					if(obj[i].checked){
						html+='<li class="science_tabLi"><a onclick="getDataByCategory('+obj[i].id+')" id=tab_'+obj[i].id+' class="swiper-slide">'+obj[i].value+'</a></li>';
					}
				}
				$(".swiper-wrapper").html(html);
			}
	function getDataByCategory(id){

		$('.science_tabLi a').removeClass('index_head_active');
		$('#tab_' + id).addClass('index_head_active');

		var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/js/type/1/category_id/"+id;
		var data={
			"order_field":"create_time",
			"order_by":"DESC",
			"page": 1,
			"page_num":10,
		};
		$.post(url,data,function(res){
			$("#Dissimilarity").empty();
			var data = res.data;
			for (var key in data){
				var value = data[key];
				var html='<li>';
					html+='<a onclick="getDetail('+value.id+')" class="weui-media-box weui-media-box_appmsg">';
					html+='<div class="weui-media-box__hd" style="width: 100px;height: 75px;">';
					html+='	<img style="height: 100%;" class="weui-media-box__thumb" src="'+value.cover_url+'"> </div>';
					html+='	<div class="weui-media-box__bd">';
					html+='	<h4 class="weui-media-box__title">'+value.title+'</h4>';
					html+='	<p class="weui-media-box__desc">'+value.desc+'</p>';
					html+='	</div> </a>';
					html+='	<div class="index_sectionB">';
					html+='<p class="index_sectionB1">'+value.cat_name+'</p>';
					html+='<p class="index_sectionB5">'+value.clicks+'阅读</p>';
					html+='	<p class="index_sectionB3">'+value.csd+'</p>';
					html+='	</div> </li>';
				$('#Dissimilarity').append(html);
			}

		},'json');
		$('.science_tabLi a').removeClass('index_head_active');
		$('#' + id).addClass('index_head_active');
	}
	function getDetail(id){
		window.location.href="/index.php/Mobile/Article/detail/channel/js/type/1/data_id/"+id;
	}

</script>
<script>
	var vm = new Vue({
		el:'#template',
		data:{
			listData: '', //列表数据
			categoryData: '',
			configData:'',
			countData:'',
			page : 1,
			page_total:0,
			show_prex:false,
			show_next:1,
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
				this.getCategoryData();
				this.getConfigData();
				this.getCount();
			})
		},
		updated:function(){
		},
		filters: {
		},
		methods:{
			getCount:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/count/channel/<?php echo ($channel); ?>/type/1";
				$.get(url,"", function (res) {
					_this.countData = res.data;
				})
			},
			getData:function (){
				vm.page = 1;
				vm.page_total = 0;
				this.search(0,false);
			},
			getConfigData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/Setting/settingAbout/channel/<?php echo ($channel); ?>/type/1";
				$.post(url,"", function (res) {
					_this.configData = res.data;
				})
			},
			getCategoryData:function () {
				var _this = this;
				var url = "/<?php echo (API_PATH); ?>/ChannelIndex/index/action/dataList/channel/js/type/2";
				$.get(url, function (res) {
					_this.categoryData = res.data;
				})
			},
			getDetail:function (id) {
				window.location.href="/index.php/Mobile/Article/detail/channel/js/type/1/data_id/"+id;
			},
			showDetail:function (url) {
				window.location.href=url;
			},
			getDataByCategory:function(category_id){
				vm.page = 1;
				vm.page_total = 0;
				this.search(category_id,false);
				$('.science_tabLi a').removeClass('index_head_active');
				$('#tab_' + category_id).addClass('index_head_active');
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

				$.post(url, data,function (res) {
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
			}
		}
	});
</script>

</html>