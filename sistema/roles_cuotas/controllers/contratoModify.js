app.controller('ModifyController', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {


    $scope.listaContratos = [];
    $scope.listaPagosPendiente = [];
    $scope.listaPagosRealizados = [];
    $scope.cedula;
    $scope.id;
    $scope.id2;
    $scope.id3;
    $scope.selectedRow;
    $scope.selectedRow2;
    $scope.selectedRow3;
    $scope.pagar;
    $scope.dateNow;
    $scope.pagar1;
    $scope.iniciar = function () {


    }


    $scope.loadContratos = function () {

        $http({
            method: 'POST',
            url: myProvider.getAllContratosActi3(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                cedula: $scope.cedula



            }


        })
            .then(function (response) {

                
                if (response.data.length > 0) {
                    $scope.listaContratos = response.data;
                    console.log($scope.listaContratos);
                } else {
                    console.log(response.data);
                  //  alert('La cedula ingresada no tiene un contrato activo');
                }

            }, function errorCallback(response) {

                console.log(response);
            });

    }


    $scope.setClickedRow = function (index, item) {

        $scope.id = item;
        $scope.selectedRow = index;

        console.log($scope.id);

    }

    $scope.redirect = function () {
        if ($scope.id != '' && $scope.id != undefined) {

            window.localStorage.setItem('mod1', JSON.stringify($scope.id));


            window.location = 'modifyContract.html';

        } else {

            alert('Seleccione la fila a modificar');
        }
        
    }

}]);