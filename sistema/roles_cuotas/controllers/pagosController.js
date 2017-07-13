// JavaScript source code
app.controller('PagosController', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {


    $scope.listaContratos=[],
    $scope.listaContratosAux = [{
        contrato: '',
        array:[],
    }];
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
    $scope.pagar2;
    $scope.dateNow;
    $scope.pagar1;
    $scope.usuario;
    $scope.listaProductos=[];
    $scope.iniciar = function () {
        $http({
            method: 'POST',
            url: myProvider.getUsr(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {


            }


        })
            .then(function (response) {
                // console.log(response.data);
                $scope.usuario = JSON.parse(response.data);
             //   console.log($scope.usuario);
            }, function errorCallback(response) {

                console.log(response);
            });
        $scope.loadContratos();

    }


    $scope.loadContratos = function () {

        $http({
            method: 'POST',
            url: myProvider.getContratoCred2(),
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
                    // console.log($scope.listaContratos);

                      $scope.n = $scope.listaContratos.length;
                    console.log('entra');
                    //console.log($scope.n);
                    
                   /* for ( var i = 0; i < $scope.n; i++) {
                        $scope.prod = [];
                        $scope.aux = {
                            "codigo": "",
                            "confechacontrato": "",
                            "conplazocredito": "",
                            "estconcodigo": "",
                            "concostocuota": "",
                            "coninterescredito": "",
                            "coninteresmora": "",
                            "concuotainicial": "",
                            "nombre": "",
                            "ci_ruc": "",
                            "id_factura": ""

                        }
                        console.log($scope.listaContratos[i+1].id_factura);
                        if ($scope.listaContratos[i + 1].id_factura !== undefined) {

                            if ($scope.listaContratos[i].id_factura == $scope.listaContratos[i + 1].id_factura) {

                                $scope.listaProductos.push($scope.listaContratos[i].producto);


                            } else {
                                $scope.aux = {
                                    "codigo": $scope.listaContratos[i].codigo,
                                    "confechacontrato": $scope.listaContratos[i].confechacontrato,
                                    "conplazocredito": $scope.listaContratos[i].conplazocredito,
                                    "estconcodigo": $scope.listaContratos[i].estconcodigo,
                                    "concostocuota": $scope.listaContratos[i].concostocuota,
                                    "coninterescredito": $scope.listaContratos[i].coninterescredito,
                                    "coninteresmora": $scope.listaContratos[i].coninteresmora,
                                    "concuotainicial": $scope.listaContratos[i].concuotainicial,
                                    "nombre": $scope.listaContratos[i].nombre,
                                    "ci_ruc": $scope.listaContratos[i].ci_ruc,
                                    "id_factura": $scope.listaContratos[i].id_factura

                                }
                                $scope.listaContratosAux.push($scope.aux);

                            }

                        } else{


                            $scope.aux = {
                                "codigo": $scope.listaContratos[i].codigo,
                                "confechacontrato": $scope.listaContratos[i].confechacontrato,
                                "conplazocredito": $scope.listaContratos[i].conplazocredito,
                                "estconcodigo": $scope.listaContratos[i].estconcodigo,
                                "concostocuota": $scope.listaContratos[i].concostocuota,
                                "coninterescredito": $scope.listaContratos[i].coninterescredito,
                                "coninteresmora": $scope.listaContratos[i].coninteresmora,
                                "concuotainicial": $scope.listaContratos[i].concuotainicial,
                                "nombre": $scope.listaContratos[i].nombre,
                                "ci_ruc": $scope.listaContratos[i].ci_ruc,
                                "id_factura": $scope.listaContratos[i].id_factura

                            }

                            $scope.listaContratosAux.push($scope.aux);

                        }

                        

                    }*/


                } else {
                  
                }
              
            }, function errorCallback(response) {

                console.log(response);
            }).then(function (response) {
//
           

            });

    }


    $scope.loadPagos = function () {

     //   console.log($scope.id);


        $http({
            method: 'POST',
            url: myProvider.getCuotasPago(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                cont: $scope.id.codigo ,
                estado:1



            }


        })
            .then(function (response) {



                $scope.listaPagosPendiente = response.data;
               // console.log($scope.listaPagosPendiente);
            }, function errorCallback(response) {

               // console.log(response);
            });

        $http({
            method: 'POST',
            url: myProvider.getCuotasPago(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                cont: $scope.id.codigo,
                estado: 2



            }


        })
            .then(function (response) {



                $scope.listaPagosRealizados = response.data;
            //    console.log($scope.listaPagosRealizados);
            }, function errorCallback(response) {

                console.log(response);
            });

    }


    $scope.setClickedRow = function (index, item) {

        $scope.id = item;
        $scope.selectedRow = index;

        console.log($scope.id);

    }


    $scope.setClickedRow2 = function (index, item) {

        $scope.id2 = item;
        $scope.selectedRow2 = index;
        $scope.pagar = item;
        $scope.pagar2 = item;
       // console.log($scope.id2);
        console.log('selecciona');
        window.localStorage.setItem('pago2', JSON.stringify($scope.pagar2));
       

    }


    $scope.setClickedRow3 = function (index, item) {

        $scope.id3 = item;
        $scope.selectedRow3 = index;
        $scope.pagar1 = item;
       // console.log($scope.id3);

    }


    $scope.pago = function () {

        console.log(' pago ');
        var tiempo = new Date();
        var hora = tiempo.getHours();
        var minuto = tiempo.getMinutes();
        var segundo = tiempo.getSeconds();
        var horaActual=hora + ':' + minuto + ':' + segundo;

        if ($scope.listaPagosPendiente.length == 1) {



            console.log('antes pago ');
            console.log($scope.pagar);
            $scope.aux = JSON.parse(window.localStorage.getItem('pago2'));
            console.log('aux');
            console.log($scope.aux);
            if (parseFloat($scope.pagar.valor) < parseFloat($scope.aux.valor)) {
                console.log('entra pago menor');
                $http({
                    method: 'POST',
                    url: myProvider.getUpdatePago(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id: $scope.pagar.id,
                        estado: 2,
                        valor: $scope.pagar.valor,
                        final: $scope.dateNow,
                        usuario: $scope.usuario,
                        hora: horaActual


                    }


                })
                    .then(function (response) {

                        console.log('ingreso correcto');
                        $scope.vec1 = $scope.pagar.fecha_maxima.split('-');
                        console.log($scope.vec1);
                        $scope.flag = false;
                        $scope.vec1[0] = parseInt($scope.vec1[0]);
                        $scope.vec1[1] = parseInt($scope.vec1[1]);
                        $scope.vec1[2] = parseInt($scope.vec1[2]);
                        switch ($scope.vec1[1]) {

                            case 1: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 2:

                                $scope.vec1[1] += 1;
                                // $scope.vec1[1] = 29;
                                //  console.log($scope.totalDiasMes);
                                if ($scope.vec1[2] > 28) {
                                    $scope.auxDate = $scope.vec1[3];
                                    $scope.vec1[2] = 28;
                                    $scope.flag = true;
                                }


                                //  console.log($scope.totalDiasMes);

                                break;
                            case 3: $scope.vec1[1] = +1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 4: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 5: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 6: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 7: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 8: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 9: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 10: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 11: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 12: $scope.vec1[1] = 1;
                                $scope.vec1[0]++;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;

                        }

                        console.log('actualiza');
                        $scope.formatedDate1 = '';
                        $scope.formatedDate1 = $scope.vec1[0] + '-' + $scope.vec1[1] + '-' + $scope.vec1[2];
                        console.log($scope.formatedDate1);
                        if ($scope.flag) {

                            $scope.vec[0] = $scope.auxDate;
                        }


                        $scope.aux.valor -= $scope.pagar.valor;
                        var data2 = {
                            //   id: $scope.pagar.id,
                            id_contrato: $scope.pagar.id_contrato,
                            descripcion_pago: 'cuota ' + 'pendiente anterior ',
                            fecha_maxima: $scope.formatedDate1,
                            estado: 1,
                            valor: $scope.aux.valor
                            // final: $scope.formatedDate1,
                            //final: $scope.dateNow,
                            // usuario: $scope.usuario,
                            //  hora: horaActual


                        }
                        console.log(data2);

                        $http({
                            method: 'POST',
                            url: myProvider.getCuotas(),
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                //   id: $scope.pagar.id,
                                id_contrato: $scope.pagar.id_contrato,
                                descripcion_pago: 'cuota ' + 'pendiente anterior cuota',
                                fecha_maxima: $scope.formatedDate1,
                                estado: 1,
                                valor: $scope.aux.valor
                                // final: $scope.formatedDate1,
                                //final: $scope.dateNow,
                                // usuario: $scope.usuario,
                                //  hora: horaActual


                            }


                        })
                            .then(function (response) {
                                console.log(response);
                                console.log('ingreso correcto');

                                $scope.loadPagos();
                            }, function errorCallback(response) {
                                //console.log(url2);
                                // console.log(response.data);
                            });





                        //  $scope.loadPagos();
                    }, function errorCallback(response) {
                        //console.log(url2);
                        // console.log(response.data);
                    });




            } else {


                $http({
                    method: 'POST',
                    url: myProvider.getUpdatePago(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id: $scope.pagar.id,
                        estado: 2,
                        valor: $scope.pagar.valor,
                        final: $scope.dateNow,
                        usuario: $scope.usuario,
                        hora: horaActual


                    }


                })
                    .then(function (response) {

                        var data3 ={
                            id: $scope.id,
                            estconcodigo: 'Cancelado'


                        }
                        console.log(data3);

                        $http({
                            method: 'POST',
                            url: myProvider.getUpdateCont(),
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                id: $scope.id.codigo,
                                estconcodigo: 'Cancelado'


                            }


                        })
                            .then(function (response) {

                                console.log('ingreso correcto');
                               
                                $scope.loadContratos();
                                $scope.loadPagos();
                                $scope.listaPagosPendiente = [];
                                $scope.listaPagosRealizados = [];
                            }, function errorCallback(response) {
                                //console.log(url2);
                                // 
                                console.log(response.data);
                            });

                        //$scope.loadPagos();
                    }, function errorCallback(response) {
                        //console.log(url2);
                        // console.log(response.data);
                    });
            }

        








        } else {

            console.log('antes pago ');
            console.log($scope.pagar);
            $scope.aux = JSON.parse(window.localStorage.getItem('pago2'));
            console.log('aux');
            console.log($scope.aux);
            if (parseFloat($scope.pagar.valor) < parseFloat($scope.aux.valor)) {
                console.log('entra pago menor');
                $http({
                    method: 'POST',
                    url: myProvider.getUpdatePago(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id: $scope.pagar.id,
                        estado: 2,
                        valor: $scope.pagar.valor,
                        final: $scope.dateNow,
                        usuario: $scope.usuario,
                        hora: horaActual


                    }


                })
                    .then(function (response) {

                        console.log('ingreso correcto');


                        $http({
                            method: 'POST',
                            url: myProvider.saveDiary(),
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                id_factura : $scope.id.id_venta,
                                id_cliente: $scope.id.id_cliente,
                                // id_usuario: '1',
                                importe: $scope.pagar.valor,
                                fechacobro:$scope.dateNow




                            }


                        })
                            .then(function (response) {
                            }, function errorCallback(response) {

                                // console.log(response);
                            });


                        $scope.vec1= $scope.pagar.fecha_maxima.split('-');
                        console.log($scope.vec1);
                        $scope.flag = false;
                        $scope.vec1[0] = parseInt($scope.vec1[0]);
                        $scope.vec1[1] = parseInt($scope.vec1[1]);
                        $scope.vec1[2] = parseInt($scope.vec1[2]);
                        switch ($scope.vec1[1]) {

                            case 1: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 2:

                                $scope.vec1[1] += 1;
                                // $scope.vec1[1] = 29;
                                //  console.log($scope.totalDiasMes);
                                if ($scope.vec1[2] > 28) {
                                    $scope.auxDate = $scope.vec1[3];
                                    $scope.vec1[2] = 28;
                                    $scope.flag = true;
                                }


                                //  console.log($scope.totalDiasMes);

                                break;
                            case 3: $scope.vec1[1] = +1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 4: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 5: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 6: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 7: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 8: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 9: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 10: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 11: $scope.vec1[1] += 1;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;
                            case 12: $scope.vec1[1] = 1;
                                $scope.vec1[0]++;
                                if ($scope.vec1[2] > 30) {
                                    $scope.vec1[2] = 30;
                                }
                                break;

                        }

                        console.log('actualiza');
                        $scope.formatedDate1 = '';
                        $scope.formatedDate1 = $scope.vec1[0] + '-' + $scope.vec1[1] + '-' + $scope.vec1[2];
                        console.log($scope.formatedDate1);
                        if ($scope.flag) {

                            $scope.vec[0] = $scope.auxDate;
                        }


                        $scope.aux.valor -= $scope.pagar.valor;
                        var data2 =  {
                            //   id: $scope.pagar.id,
                            id_contrato: $scope.pagar.id_contrato,
                            descripcion_pago: 'cuota ' + 'pendiente anterior ',
                            fecha_maxima: $scope.formatedDate1,
                            estado: 1,
                            valor: $scope.aux.valor
                            // final: $scope.formatedDate1,
                            //final: $scope.dateNow,
                            // usuario: $scope.usuario,
                            //  hora: horaActual


                        }
                        console.log(data2);
                        $http({
                            method: 'POST',
                            url: myProvider.getCuotas(),
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                             //   id: $scope.pagar.id,
                                id_contrato: $scope.pagar.id_contrato,
                                descripcion_pago: 'cuota N' + 'pendiente anterior cuota',
                                fecha_maxima: $scope.formatedDate1,
                                estado: 1,
                                valor: $scope.aux.valor
                               // final: $scope.formatedDate1,
                                //final: $scope.dateNow,
                               // usuario: $scope.usuario,
                              //  hora: horaActual


                            }


                        })
                            .then(function (response) {
                                console.log(response);
                                console.log('ingreso correcto');
                                $scope.loadPagos();
                            }, function errorCallback(response) {
                                //console.log(url2);
                                // console.log(response.data);
                            });





                      //  $scope.loadPagos();
                    }, function errorCallback(response) {
                        //console.log(url2);
                        // console.log(response.data);
                    });




            } else {

            
                $http({
                    method: 'POST',
                    url: myProvider.getUpdatePago(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id: $scope.pagar.id,
                        estado: 2,
                        valor: $scope.pagar.valor,
                        final: $scope.dateNow,
                        usuario: $scope.usuario,
                        hora: horaActual


                    }


                })
                    .then(function (response) {

                        console.log('ingreso correcto');
                        $http({
                            method: 'POST',
                            url: myProvider.saveDiary(),
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            data: {
                                id_factura : $scope.id.id_venta,
                                id_cliente: $scope.id.id_cliente,
                                // id_usuario: '1',
                                importe: $scope.pagar.valor,
                                fechacobro:$scope.dateNow




                            }


                        })
                            .then(function (response) {
                            }, function errorCallback(response) {

                                // console.log(response);
                            });
                        $scope.loadPagos();
                    }, function errorCallback(response) {
                        //console.log(url2);
                        // console.log(response.data);
                    });
            }

        }
       


    } 


    $scope.calcular = function () {

        $scope.vec = $scope.pagar.fecha_maxima.split('-');
        $scope.dateNow = new Date();
        $scope.vec1 = JSON.stringify($scope.dateNow).split('T');

        $scope.dateNow = $scope.vec1[0].substring(1);
        $scope.vec1 = $scope.dateNow.split('-');
        $scope.day1 = parseInt($scope.vec[2]);
        $scope.day2 = parseInt($scope.vec1[2]);
        $scope.month = parseInt($scope.vec[1]);
        $scope.month2 = parseInt($scope.vec1[1]);
        if ($scope.month2 >= $scope.month && $scope.day2 > $scope.day1) {
            $scope.id.coninteresmora = $scope.id.coninteresmora / 100;
            $scope.adicional = fixedNumbers(parseFloat($scope.pagar.valor) * parseFloat($scope.id.coninteresmora));

            $scope.pagar.valor = fixedNumbers(parseFloat($scope.adicional)+parseFloat($scope.pagar.valor));

        }
       // $scope.vec1 
        console.log($scope.pagar.valor);
      /*  if ($scope.vec){
            
        }*/

    }

    fixedNumbers = function (cal) {

        var constant100 = 1000;
        var resp = (Math.floor(cal * constant100) / constant100).toFixed(2);
        //   console.log(resp);
        return (resp);
    }

    $scope.modificar = function () {

        var tiempo = new Date();
        var hora = tiempo.getHours();
        var minuto = tiempo.getMinutes();
        var segundo = tiempo.getSeconds();
        var horaActual = hora + ':' + minuto + ':' + segundo;

        $scope.dateNow = new Date();
        $scope.vec1 = JSON.stringify($scope.dateNow).split('T');

        $scope.dateNow = $scope.vec1[0].substring(1);
       
        console.log($scope.dateNow);
        $http({
            method: 'POST',
            url: myProvider.getUpdatePago(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.pagar1.id,
                estado: 1,
                valor: $scope.pagar1.valor,
                final: $scope.dateNow,
                usuario: $scope.usuario,
                hora: horaActual


            }


        })
            .then(function (response) {

                console.log('ingreso correcto');
               var data1= {
                    id_contrato: $scope.pagar1.id_contrato,
                        descripcion_pago: $scope.pagar1.descripcion_pago,
                            fecha_maxima: $scope.pagar1.fecha_maxima,
                                estado: 1,
                                    valor: $scope.pagar1.valor,
                                        // final: $scope.dateNow,
                                        usuario: $scope.usuario,
                                            hora: horaActual


                }
                console.log(data1);

                $http({
                    method: 'POST',
                    url: myProvider.getUpdatePagoDelete(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id_contrato: $scope.pagar1.id_contrato,
                        descripcion_pago: $scope.pagar1.descripcion_pago,
                        fecha_maxima: $scope.pagar1.fecha_maxima,
                        estado: 1,
                        valor: $scope.pagar1.valor,
                       // final: $scope.dateNow,
                        usuario: $scope.usuario,
                        hora: horaActual


                    }


                })
                    .then(function (response) {

                        


                    }, function errorCallback(response) {
                        //console.log(url2);
                        // console.log(response.data);
                    }).then(function (response){


                        $scope.loadPagos();


                }) ;

                
            }, function errorCallback(response) {
                //console.log(url2);
                // console.log(response.data);
            });



    }



    $scope.imprimir = function () {

        if ($scope.id != '' && $scope.id != undefined) {


            var doc = new jsPDF({

                unit: "mm",
                format: "letter"
            });

            var x = 20;
            var y = 35;

            doc.setFontSize(10);
            doc.setFillColor(176, 176, 176);
            doc.rect(0, 0, 300, 20, 'F');
            var name = $scope.empleadoSeleccionado;
            doc.setFontSize(10);
            doc.setFontType("normal");
           
            doc.text(x, y + 5, 'Factura:');
            doc.text(x + 15, y + 5, $scope.id.id_venta);
            doc.text(x, y + 10, 'Descripcion Couta:');
            doc.text(x + 30, y + 10, $scope.id3.descripcion_pago);
            doc.text(x, y+15, 'Codigo Contrato:');
            doc.text(x+10 + 23, y+15, $scope.id.codigo);
            doc.text(x, y+20, 'Cliente:');
            doc.text(x + 15, y+20, $scope.id.nombre);
            doc.text(x, y + 25, 'Cedula:');
            doc.text(x + 15, y + 25, $scope.id.ci_ruc);
            doc.text(x, y + 30, 'Fecha Maxima pago:');
            doc.text(x + 40, y + 30, $scope.id3.fecha_maxima);
            doc.text(x, y + 35, 'Fecha  pago:');
            doc.text(x + 25, y + 35, $scope.id3.fecha_pago);
            doc.text(x, y + 40, 'Valor:');
            doc.text(x + 15, y + 40, $scope.id3.valor);
            
            //doc.text(x, y+20, 'Mes:');
           /* doc.text(x, y + 20, mes);
            //  $scope.aux =  ["A�o:"];
            //doc.text(x + 40, y + 20, $scope.aux[0]);
            doc.text(x + 30, y + 20, $scope.anioSeleccionado);
            doc.text(x, y + 30, 'Dias No Laborados');
            var dates = document.getElementById('datepicker').value;
            if (dates != '' && dates != undefined) {
                var n = dates.split(',');
                var m = n.length;
                console.log(m);
                var days = '';


                for (var i = 0; i < m; i++) {

                    var vec = n[i].split('/');
                    days += vec[0] + ',';
                }
            } else {
                days = 'sin dias'
            }

            doc.text(x, y + 35, days);
            doc.text(x, y + 40, 'Total Dias no Laborados:');
            if (m != undefined) {
                doc.text(x + 50, y + 40, m.toString());
            } else {
                doc.text(x + 50, y + 40, '0');
            }

            doc.text(x, y + 45, 'Sueldo:');
            doc.text(x + 50, y + 45, $scope.id.nombre);
            doc.text(x, y + 50, 'Seguro:');
            doc.text(x + 50, y + 50, $scope.seguroShow.toString());
            doc.text(x, y + 55, 'Descuento:');
            doc.text(x + 50, y + 55, $scope.descuento.toString());
            doc.text(x, y + 60, 'Comision:');
            doc.text(x + 50, y + 60, $scope.comision.toString());
            doc.text(x, y + 65, 'Total:');
            var aux = $scope.total.toFixedDown(2);
            doc.text(x + 50, y + 65, aux.toString());*/
            doc.setFontType("bold");
            doc.setFontSize(14);
            doc.text(100, 10, 'ELECTROPARC CIA. LTDA.', 'center');
            doc.setFontSize(10);
            doc.text(100, 15, 'electroparc10@gmail.com', 'center');
            doc.setFontSize(14);
            doc.text(100, 30, 'PAGO CREDITO', 'center');


            doc.setFontSize(8);
            doc.text(100, y + 40, 'Electroparc Cia. Ltda. ', 'center');

            doc.text(100, y + 43, 'Riobamba Ecuador ', 'center');

            doc.text(100, y + 46, 'Direccion: Matriz Lavalle 30 56 y Olmedo Esquina', 'center');

            doc.text(100, y + 49, 'Telefonos: 0994161053', 'center');


            doc.line(100, y + 20, 140, y + 20);
            doc.line(150, y + 20, 190, y + 20);
            //  doc.setTextColor(255, 0, 0);
            // doc.text(100, 25, 'USD.00');
            $scope.dateN = Date.now;
            $scope.name = 'RolPago' + $scope.dateN;
            doc.save('Pagos.pdf');

        } else {
            alert('Para iomprimir seleccione un pago realizado');
        }



    }
}]);