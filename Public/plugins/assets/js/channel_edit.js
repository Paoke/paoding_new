define([
       "jquery" , "underscore" , "backbone"
       , "collections/snippets" , "collections/my-form-snippets"
       , "views/tab" , "views/my-form"
       ,  "text!data/channeldata.json" , "text!templates/app/render.html"
], function(
  $, _, Backbone
  , SnippetsCollection, MyFormSnippetsCollection
  , TabView, MyFormView
  , channeldataJSON , renderTab
){
  return {
    initialize: function(){

      new TabView({
        title: "Component"
        , name: "列表组件"
        , collection: new SnippetsCollection(JSON.parse(channeldataJSON))
      });
      new TabView({
        title: "Rendered"
        , name: "代码"
        , content: renderTab
      });

      //Make the first tab active!
      $("#components .tab-pane").first().addClass("active");
      $("#formtabs li").first().addClass("active");
      // Bootstrap "My Form" with 'Form Name' snippet.

	  var id = $("#id").val();
      var url = $("#url").val()+id;

      $.get(url,function(ret){

          if(ret.result == 1){
            new MyFormView({
              title: "Original"
              , collection: new MyFormSnippetsCollection(JSON.parse(ret.data))
            });
          }else{
            new MyFormView({
              title: "Original"
              , collection: new MyFormSnippetsCollection([
                { "title" : "Form Name"
                  , "fields": {
                  "name" : {
                    "label"   : "页面名称"
                    , "type"  : "input"
                    , "value" : "页面名称"
                  }
                }
                }
              ])
            });
          }
      },'json');



    }
  }
});
