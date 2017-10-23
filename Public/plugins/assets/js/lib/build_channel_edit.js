({
  name: "../main_channel_edit",
  out: "../main-built-channel-edit.js"
  , shim: {
    'backbone': {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone'
    },
    'underscore': {
      exports: '_'
    },
    'bootstrap': {
      deps: ['jquery'],
      exports: '$.fn.popover'
    }
  }
  , paths: {
    channel_edit         : ".."
    , collections : "../collections"
    , data        : "../data"
    , models      : "../models"
    , helper      : "../helper"
    , templates   : "../templates"
    , views       : "../views"
  }
})
