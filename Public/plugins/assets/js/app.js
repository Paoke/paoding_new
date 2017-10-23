define([
       "jquery" , "underscore" , "backbone"
       , "collections/snippets" , "collections/my-form-snippets"
       , "views/tab" , "views/my-form"
       , "text!data/component.json", "text!templates/app/render.html"
], function(
  $, _, Backbone
  , SnippetsCollection, MyFormSnippetsCollection
  , TabView, MyFormView
  , componentJSON, renderTab
){
  return {
    initialize: function(){

      //Bootstrap tabs from json.

      new TabView({
        title: "Component"
        , name: "组件"
        , collection: new SnippetsCollection(JSON.parse(componentJSON))
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
  }
});
