define(function(require) {
  var formname               = require('text!templates/snippet/formname.html')
  , component1                = require('text!templates/snippet/component1.html')
  , component2                = require('text!templates/snippet/component2.html')
  , component3                = require('text!templates/snippet/component3.html')
  , component4                = require('text!templates/snippet/component4.html')
  , component5                = require('text!templates/snippet/component5.html')
  , component6                = require('text!templates/snippet/component6.html')
  //, component7                = require('text!templates/snippet/component7.html')
      ;

  return {
    formname                   : formname
    , component1                  : component1
    , component2                  : component2
    , component3                  : component3
    , component4                  : component4
    , component5                  : component5
    , component6                  : component6
    //, component7                  : component7
  }
});
