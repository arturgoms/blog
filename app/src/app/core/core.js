angular.module('app', [
    'ngResource',
    'ui.router',
    'angular-jwt',
    'app.index',
    'app.auth',
    'app.home',
    'app.user'
]);

/**
 * Modules
 */
angular.module('app.index', []);
angular.module('app.auth', []);
angular.module('app.home', []);
angular.module('app.user', []);


angular.module('app').config(['appConfigProvider', '$stateProvider', '$urlRouterProvider', '$httpProvider', 'jwtInterceptorProvider', config]);

function config(appConfigProvider, $stateProvider, $urlRouterProvider, $httpProvider, jwtInterceptorProvider) {

    // jwtInterceptorProvider.tokenGetter = ['myService', function(myService) {
    //     myService.doSomething();
    //     return localStorage.getItem('token');
    // }];

    $httpProvider.interceptors.push('jwtInterceptor');
    /**
     * Adiciona no cabecalho padrao do método post/put para usar o urlencoded
     */
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';


    $httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;


    /**
     * Rotas
     */
    $urlRouterProvider.otherwise("/");
    var base = {
        name: 'base',
        url: '',
        abstract: true,
        controller: 'BaseController as Base',
        templateUrl: 'src/app/core/views/base.html'
    };

    $stateProvider
        .state(base);

}
