app.controller('update', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {

    $scope.listContratos;
    $scope.id
    $scope.selected;
    $scope.selectedRow;
    $scope.search;
    $scope.empleadoSeleccionado;
    $scope.contrato;
    $scope.listaanios = [];
    $scope.anioSeleccionado;
    $scope.mesSeleccionado;
    $scope.diasNoLaborados;
    $scope.seguro;
    $scope.comision;
    $scope.descuento;
    $scope.total;
    $scope.totalDiasMes;
    $scope.diaslaborados;
    $scope.flag = false;
    $scope.fechasNoLaboradas;


    $scope.inicializar = function () {

        for (var i = 2016; i < 2100; i++) {

            $scope.listaanios.push(i);
        }

      //  console.log(myProvider.getAllRoles2());
        $http({
            method: 'POST',
            url: myProvider.getAllRoles1(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
              

            }


        })
            .then(function (response) {

                $scope.listContratos = response.data;
                
            }, function errorCallback(response) {

                console.log(response);
            });



       

    }


    $scope.setClickedRow = function (index, item) {

        $scope.id = item;
        $scope.selectedRow = index;

        console.log($scope.id);
      
    }


    $scope.modificar=function(){

        if ($scope.id != '' && $scope.id != undefined) {

            window.localStorage.setItem('mod', JSON.stringify($scope.id));

        
            window.location='modify.html';

        } else {

            alert('Seleccione la fila a modificar');
        }
        
    }


    $scope.addNew = function () {
        localStorage.removeItem('mod');
        window.location = 'index.html';
    }
}]);