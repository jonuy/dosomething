//
//
// Development Build Configuration
// Settings for development builds only. This file is **not** included
// when building JavaScript for production.
//
//


/* jshint ignore:start */
var DEBUG = true;

// In dev, we concatenate jQuery into `app.js`, so don't load it using RequireJS.
// We do this because inline (Drupal) scripts were failing when $ was not defined on load.
(function() {
  require.config({
    paths: {
      "jquery": "jquery.dev"
    }
  });
})();


// Console-polyfill. MIT license.
// https://github.com/paulmillr/console-polyfill
(function(con) {
  'use strict';
  var prop, method;
  var empty = {};
  var dummy = function() {};
  var properties = 'memory'.split(',');
  var methods = ('assert,clear,count,debug,dir,dirxml,error,exception,group,' +
     'groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,' +
     'table,time,timeEnd,timeStamp,trace,warn').split(',');
  while (prop = properties.pop()) con[prop] = con[prop] || empty;
  while (method = methods.pop()) con[method] = con[method] || dummy;
})(this.console = this.console || {}); // Using `this` for web workers.


// Development build notice
(function() {
  var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
  var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);

  var cactus = "font-size: 16px; padding: 0 5px; font-weight: normal; background: transparent; background-size: contain; background-position: center; background-image: url(data:image/png;base64,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);";
  var highlight = "font-size: 16px; background:yellow; font-weight: bold;";
  var unhighlight = "font-size: 16px; background:transparent; font-weight: bold;";
  var bold = "font-weight: bold;"
  var unbold = "font-weight: regular";

  if(isSafari || isChrome) {
    console.log("");
    console.log("%c %c %cYou're running a development build. Exciting!%c %c ", cactus, unhighlight, highlight, unhighlight, cactus);
    console.log("Run %cds grunt --prod%c from your Vagrant box to build production assets.", bold, unbold);
    console.log("More information: https://github.com/DoSomething/dosomething/wiki/Front-End-Development#javascript-development");
    console.log("");
  } else {
    console.log("---------------------------------------------");
    console.log("You're running a development build. Exciting!");
    console.log("Run 'ds grunt --prod' from your Vagrant box to build production assets.");
    console.log("More information: https://github.com/DoSomething/dosomething/wiki/Front-End-Development#javascript-development");
    console.log("---------------------------------------------");
  }

})();

/* jshint ignore:end */