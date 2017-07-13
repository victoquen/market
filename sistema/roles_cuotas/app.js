'use strict';

// Declare app level module which depends on views, and components
var app = angular.module("myApp", ['ngStorage', 'ngRoute', 'angularUtils.directives.dirPagination'])


var ApiUrl= function(){

    this.getEmpleados=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/selectEmpleado.php';
    }
    this.getContrato=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/selecContrato.php';
    }
    this.getRol=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/addOne.php';
    }
    this.getModRol=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/modificar.php';
    }
    this.getContratoIns=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/insertContrato.php';
    }
    this.getCuotas=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/addPagos.php';
    }
    this.getContratoCred=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/getContratosActivos.php';
    }
    this.getCuotasPago=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/getCuotas.php';
    }
    this.getUpdatePago=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/updatePago.php';
    }
    this.getAllRoles1=function(){
        return 'http://localhost/electroparc/sistema/roles_cuotas/selectAll.php';
    }
    this.getAllRoles2 = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/selectAll.php';
    }
    this.getAllContratosActi = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getAllContratos.php';
    }
    this.getAllContratosActiMod1 = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/modifyCont.php';
    }
    this.getUsr = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getUsr.php';
    }
    this.getUpdatePagoDelete = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/updatePagoDelete.php';
    }
    this.getContratoCred2 = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getContratosActivos2.php';
    }
    this.getFacLinea = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getNames.php';
    }
    this.getUpdateCont = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/updateStateCont.php';
    }
    this.getAllContratosActi3 = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getAllContratosActivos3.php';
    }
    this.getAllCompra = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getFactura.php';
    }
    this.getClientePrint = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getClientePrint.php';
    }
    this.getOldContract = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getContratoOld.php';
    }
    this.getCuotasOld = function () {
        return 'http://localhost/electroparc/sistema/roles_cuotas/getCuotasOld.php';
    }
    this.getAbonoOld = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/getAbonosOld.php';
    }
    this.saveOld = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/saveAbonoLegacy.php';
    }
    this.updateCuota = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/updateStateOldCuota.php';
    }
    this.getUsr2 = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/getUsr2.php';
    }
    this.getTotal = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/getTotal.php';
    }
    this.saveDiary = function () {
        return ' http://localhost/electroparc/sistema/roles_cuotas/inputDiary.php';
    }
}

app.factory("myProvider",function(){
   // console.log("factory function");
    return new ApiUrl();

});

    app.config (function($routeProvider ,$provide){
   //$locationProvider.html5Mode(true);
    $routeProvider.when("/",{templateUrl:"/tesisSaludOcupacional/Client/Administrator/inicio.html", controller:'LoginController'});
    $routeProvider.when("/newEmpresa",{templateUrl:"/tesisSaludOcupacional/Client/Administrator/Empresa/ingresarEmpresa.html", controller:'EmpresaController'});
    $routeProvider.when("/newHistory",{templateUrl:"/tesisSaludOcupacional/Client/Administrator/HistoriaClinica/newClinicHistory.html", controller:'HistoriaClinicaController'});
    $routeProvider.when("/first",{templateUrl:"/tesisSaludOcupacional/Client/Administrator/HistoriaClinica/first.html", controller:'HistoriaClinicaController'});
    $routeProvider.when("/second",{templateUrl:"/tesisSaludOcupacional/Client/Administrator/HistoriaClinica/second.html", controller:'HistoriaClinicaController'});

        /*$provide.factory("ApiUrl", function () {
            return {
                urlUsuarios: 'http://192.168..1.118:3000/api/usuarios'
            };
        })*/

        //$provide.value('urlUsuarios', 'http://192.168..1.118:3000/api/usuarios');




});



//('urlUsuarios', 'http://192.168..1.118:3000/api/usuarios');



    /*app.config(['$routeProvider', function ($routeProvider) {

        $routeProvider.when('/newEmpresa', { templateUrl: '/tesisSaludOcupacional/Client/Administrator/newEmpresa.html', controller: 'EmpresaController' });
        $routeProvider.when('/', { templateUrl: '/indexAdmin.html' });
        $routeProvider.otherwise({ redirectTo: '/error' });

    }]);*/

