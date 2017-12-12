// var app = angular.module('myApp',[]);

	// 头部banner
app.controller("bannerCtrl",function ($scope,$http){
	$scope.bannerList = [
		{a:'activity.html',src:'images/index-banner1.jpg'},
		{a:'activity.html',src:'images/index-banner2.jpg'},
	]
});
	// 热门专题
app.controller("hotCtrl",function ($scope,$http){
	$scope.projectList = [
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题1',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题2',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题1',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题2',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题1',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题2',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题1',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
		{a:'activity.html',src:'images/index-hottopic.jpg',title:'环保技术专题2',tecnology:'68项技术',type1:'激光清洗',type2:'抗菌清洁'},
	]
});

	// 前沿技术
// app.controller("advancedCtrl",function ($scope,$http){
// 	$scope.techList = [
// 		{a:'activity.html',src:'images/index-advanced-tech.jpg',title:'印刷品无痕防伪技术',type:'印刷工业，防伪工业'},
// 		{a:'activity.html',src:'images/index-advanced-tech.jpg',title:'印刷品无痕防伪技术2',type:'印刷工业，防伪工业'},
//
// 	]
// })

// 合作单位
app.controller("coopUnitCtrl",function ($scope,$http){
	$scope.unitList = [
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator2.jpg',unit:'广州中国科学院现金技术研究所'},
	
	]
})

// 合作企业
app.controller("companyCtrl",function ($scope,$http){
	$scope.comList = [
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
		{src:'images/index-cooperator3.jpg',unit:'广州中国科学院现金技术研究所'},
	
	]
})