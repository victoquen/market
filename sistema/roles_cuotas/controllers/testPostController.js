
app.controller('TestPostController', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {


	$scope.send = function () {

		$http({
			method: 'POST',
			url: 'http://localhost/testAngular/testPostphp.php',
			headers: {
				'Content-Type': 'application/json'
			},
			data: {

				name:'xaipo',
				

			}


		}).then(function successCallback(response) {
			console.log(response.data);
		}, function errorCallback(response) {
			// called asynchronously if an error occurs
			// or server returns response with an error status.
			// console.log(response);

			console.log(response);
			//$scope.mesaje = response.mensaje;

		});


	}
}]);