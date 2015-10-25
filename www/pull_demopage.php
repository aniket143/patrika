<!DOCTYPE html>
<!-- CSP support mode (required for Windows Universal apps): https://docs.angularjs.org/api/ng/directive/ngCsp -->
<html lang="en" ng-app="app" ng-csp>
<head>
    <meta charset="utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />

    <!-- JS dependencies (order matters!) -->
    <script src="scripts/platformOverrides.js"></script>
    <script src="lib/angular/angular.js"></script>
    <script src="lib/onsen/js/onsenui.js"></script>

    <!-- CSS dependencies -->
    <link rel="stylesheet" href="lib/onsen/css/onsenui.css" />
    <link rel="stylesheet" href="lib/onsen/css/onsen-css-components-blue-basic-theme.css" />

    <!-- CSP support mode (required for Windows Universal apps) -->
    <link rel="stylesheet" href="lib/angular/angular-csp.css" />


    <!-- --------------- App init --------------- -->

    <title>Onsen UI Sliding Menu</title>

    <script>
   ons.bootstrap()
  .controller('DemoController', function($scope, $timeout, $http) {
    $scope.items = [];
    $scope.load = function($done) {
      $timeout(function() {
        $http.jsonp('http://numbersapi.com/random/year?callback=JSON_CALLBACK')
          .success(function(data) {
            $scope.items.unshift({
              desc: data,
              rand: Math.random()
            });
          })
          .error(function() {
            $scope.items.unshift({
              desc: 'No data',
              rand: Math.random()
            });
          })
          .finally(function() {
            $done();
          });
      }, 1000);
    };
    $scope.reset = function() {
      $scope.items.length = 0;
    }
  });
    </script>

    <style>
      .left {
  text-align: left;
}

img {
  position: absolute;
  margin: auto;
  top: 0;
  bottom: 0;
}

ons-list-item {
  line-height: 22px !important;
}

.info {
  margin-top: 20px;
  text-align: center;
  opacity: 0.75;
}
    </style>

</head>

<!-- <body onload="next()"> -->
<body>


<ons-page ng-controller="DemoController">
  <ons-pull-hook ng-action="load($done)" var="loader">
    <span ng-switch="loader.getCurrentState()">
          <span ng-switch-when="initial"><ons-icon size="35px" icon="ion-arrow-down-a"></ons-icon> Pull down to refresh</span>
    <span ng-switch-when="preaction"><ons-icon size="35px" icon="ion-arrow-up-a"></ons-icon> Release to refresh</span>
    <span ng-switch-when="action"><ons-icon size="35px" spin="true" icon="ion-load-d"></ons-icon> Loading data...</span>
    </span>
  </ons-pull-hook>

  <ons-toolbar>
    <div class="center">Pull to refresh</div>
    <div class="right">
      <ons-toolbar-button ng-click="reset()">Reset</ons-toolbar-button>
    </div>
  </ons-toolbar>

  <ons-list>
    <ons-list-item ng-show="items.length === 0">
      <div class="info">
        Pull down to fetch items
      </div>
    </ons-list-item>
    <ons-list-item class="item" ng-repeat="item in items">
      <ons-row>
        <ons-col width="80px">
          <img ng-src="http://lorempixel.com/60/60/?{{item.rand}}" class="item-thum"></img>
        </ons-col>
        <ons-col>
          <p class="item-desc">{{ item.desc }}</p>
        </ons-col>
      </ons-row>
    </ons-list-item>
  </ons-list>
</ons-page>

    <!-- Cordova reference -->
     <script src="cordova.js"></script>
     <script src="scripts/index.js"></script>
   
<!--   <img src="logo.png"  style="width:100%;hieght:100%;"> -->
  
<div ons-loading-placeholder="start.html">
     Loading My Application...
  </div>
  <ons-template id="start.html">
    <div>Welcome to my app!</div>
  </ons-template>
     
 </body>
 </html>