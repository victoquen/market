/**
 * Created by xaipo on 6/19/2017.
 */
app.controller('CobrosOld', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {


    $scope.listaAbono=[];
    $scope.pago3={id_cuota:'', valor:''};
    $scope.id2;
    $scope.pagar;
    $scope.usuario;
    $scope.faltanteCuota;
    $scope.diasMora;
    $scope.valorInteres;
    $scope.iniciar = function () {
        $http({
            method: 'POST',
            url: myProvider.getOldContract(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {


            }


        })
            .then(function (response) {
                if (response.data.length > 0) {
                    $scope.listaContratos = response.data;
                     console.log(response.data);

                    //$scope.n = $scope.listaContratos.length;
                    console.log('entra');
                    //console.log($scope.n);



                } else {

                }

            }, function errorCallback(response) {

                console.log(response);
            }).then(function (response) {
//


        });
        //$scope.loadContratos();
        $http({
            method: 'POST',
            url: myProvider.getUsr2(),
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
       // $scope.loadContratos();

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
        console.log($scope.id2);
        //window.localStorage.setItem('pago2', JSON.stringify($scope.pagar2));


    }


    $scope.setClickedRow3 = function (index, item) {

        $scope.id3 = item;
        $scope.selectedRow3 = index;
        $scope.pagar1 = item;
        // console.log($scope.id3);

    }


    $scope.loadPagos = function () {

        //   console.log($scope.id);


        $http({
            method: 'POST',
            url: myProvider.getCuotasOld(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.id.codigo,



            }


        })
            .then(function (response) {


                $scope.listaPagosPendiente = response.data;
                var n= $scope.listaPagosPendiente.length;
                $scope.totalDeuda=0;
                for(var i=0;i<n;i++){

                    var months = $scope.countDays($scope.listaPagosPendiente[i].fecha_pago_cuota)
                    var days = $scope.countDays2($scope.listaPagosPendiente[i].fecha_pago_cuota)
                    if(months>0 && days>0){
                        //aplica interes
                        var interes = parseFloat($scope.listaPagosPendiente[i].interes_mora)/100;
                     //   console.log(interes);
                      //  console.log(interes);
                        var totalInteres = fixedNumbers(interes*parseFloat(months));
                        var cuota=parseFloat($scope.listaPagosPendiente[i].costo_cuota);
                        var subtotal= fixedNumbers(totalInteres*cuota);
                       // console.log(subtotal)

                        var number1=parseFloat($scope.listaPagosPendiente[i].costo_cuota);
                        console.log(number1);
                        var aux= parseFloat(number1) +parseFloat(subtotal);

                        console.log('suma interes'+$scope.totalDeuda)
                        $scope.totalDeuda=fixedNumbers(parseFloat(aux)+parseFloat($scope.totalDeuda));
                        console.log('total deuda interes'+$scope.totalDeuda)
                    }else{
                        $scope.totalDeuda=fixedNumbers(parseFloat($scope.listaPagosPendiente[i].costo_cuota)+parseFloat($scope.totalDeuda));
                        console.log('total deuda sin interes'+$scope.totalDeuda )
                        //simplemente suma
                    }

                }

                // console.log($scope.listaPagosPendiente);
            }, function errorCallback(response) {

                // console.log(response);
            }).then(function () {
            $http({
                method: 'POST',
                url: myProvider.getAbonoOld(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    id: $scope.listaPagosPendiente[0].id_cuota



                }


            })
                .then(function (response) {

                    $scope.listaAuxAbono=response.data;
                    var n= $scope.listaAuxAbono.length;
                    $scope.sumaAbono=0;
                    for(var i =0; i<n;i++){
                        $scope.sumaAbono=fixedNumbers(parseFloat($scope.sumaAbono)+parseFloat($scope.listaAuxAbono[i].costo));

                    }
                    $scope.totalDeuda=fixedNumbers(parseFloat($scope.totalDeuda)-parseFloat($scope.sumaAbono));
                    console.log( $scope.totalDeuda);
                    console.log($scope.listaAuxAbono);
                console.log('then ')
                }, function errorCallback(response) {

                    // console.log(response);
                })
        });

/*

        $http({
            method: 'POST',
            url: myProvider.getTotal(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.id.codigo,



            }


        })
            .then(function (response) {


                $scope.listaTotal = response.data;
                var n= listaTotal.length;
                var suma=0
                for(var i=0;i<n;i++) {

                    $http({
                        method: 'POST',
                        url: myProvider.getTotal(),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: {
                            id: $scope. $scope.listaTotal[i].id_cuota,


                        }


                    })
                        .then(function (response) {

                            var sumaAbonos=(response.data[0].suma)
                            if(sumaAbonos>0){
                                suma-=sumaAbonos;

                            }
                        }, function errorCallback(response) {

                            // console.log(response);
                        });
                }
                // console.log($scope.listaPagosPendiente);
            }, function errorCallback(response) {

                // console.log(response);
            });*/
    }
    
    
    $scope.loadAbono=function(){

   //     console.log($scope.pagar);
        $http({
            method: 'POST',
            url: myProvider.getAbonoOld(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.pagar.id_cuota,



            }


        })
            .then(function (response) {


                $scope.listaAbono = response.data;
                var n = $scope.listaAbono.length;
                $scope.cont=0;
                for(var i=0; i<n;i++){
                 //   console.log($scope.cont);
                    $scope.cont+=parseFloat($scope.listaAbono[i].costo)


                }
             //   console.log('meses');
                $scope.diasMora=$scope.countDays($scope.id2.fecha_pago);
            //    console.log('meses '+$scope.diasMora)
                $scope.dias2=$scope.countDays2($scope.id2.fecha_pago);
            //    console.log('dias '+$scope.dias2)
                if($scope.diasMora>0 && $scope.dias2>0){
                    console.log('entra mora')
                    var interes = parseFloat($scope.id2.interes_mora)/100;
                    //console.log(interes);
                    var totalInteres = fixedNumbers(interes*parseFloat($scope.diasMora));
                    var cuota=parseFloat($scope.id2.costo_cuota);
                    var subtotal= fixedNumbers(totalInteres*cuota);
                    $scope.valorInteres=subtotal;

                    var number1=parseFloat($scope.id2.costo_cuota);
                    var number2=parseFloat($scope.cont);
                   // console.log(subtotal);
                  //  console.log(cuota);
                  //  console.log(number1);
                 //   console.log(number2);
                    $scope.faltanteCuota=number1-number2;
                    $scope.faltanteCuota+=parseFloat(subtotal)
                    $scope.faltanteCuota=fixedNumbers($scope.faltanteCuota);
                }else{
                    console.log('no entra mora')
                    var number1=parseFloat($scope.id2.costo_cuota);
                    var number2=parseFloat($scope.cont);
                  //  console.log(number1);
                  //  console.log(number2);
                    $scope.valorInteres=0;
                    $scope.faltanteCuota=parseFloat(fixedNumbers(number1-number2));
                }

              //  console.log($scope.faltanteCuota);
            //    console.log($scope.id2.costo_cuota);
           //     console.log($scope.id2.costo_cuota);
            //    console.log(fixedNumbers($scope.id2.costo_cuota));
           //     console.log($scope.cont);
                 //console.log($scope.listaAbono);
            }, function errorCallback(response) {

                // console.log(response);
            });

    }

    fixedNumbers = function (cal) {

        var constant100 = 10000;
        var resp = (Math.floor(cal * constant100) / constant100).toFixed(2);
        //   console.log(resp);
        return (resp);
    }

    $scope.ingresar=function (){

        var dt = new Date();
        console.log($scope.valorInteres);
// Display the month, day, and year. getMonth() returns a 0-based number.
        var month = dt.getMonth()+1;
        var day = dt.getDate();
        var year = dt.getFullYear();
        var now=(year + '-' + month + '-' + day);


        var hora = dt.getHours();
        var minuto = dt.getMinutes();
        var segundo = dt.getSeconds();

        var time=hora+':'+minuto+":"+segundo;

       // console.log(now);
      //  console.log(time);
        var subtotal=0;
        var n= $scope.listaAbono.length;
        for(var i=0;i<n;i++){


            subtotal+=parseFloat($scope.listaAbono[i].costo);

        }

        subtotal+=parseFloat($scope.pago3.costo);
      //  console.log(subtotal);
        var sub2=parseFloat($scope.id2.costo_cuota);
     //   console.log(parseFloat($scope.id2.costo_cuota));

        if(subtotal<sub2){

            $http({
                method: 'POST',
                url: myProvider.saveOld(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    id_cuota : $scope.id2.id_cuota,
                    id_usuario: $scope.usuario,
                   // id_usuario: '1',
                    costo: $scope.pago3.costo,
                    fecha_abono:now,
                    numero_comprobante: $scope.id2.id_cuota,
                    interes_mora: $scope.valorInteres,
                    dias_mora: "0",
                    costo_cobrado:  $scope.pago3.costo,
                    observacion: "obs",
                    hora: time



                }


            })
                .then(function (response) {
                    console.log(response.data);
                    $scope.loadAbono();
                            
                    //$scope.listaAbono.push(data);
                    // console.log($scope.listaAbono);

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
                            importe: $scope.pago3.costo,
                            fechacobro:now




                        }


                    })
                        .then(function (response) {
                        }, function errorCallback(response) {

                            // console.log(response);
                        });
                        
                }, function errorCallback(response) {

                    // console.log(response);
                });

        }else{
          //  console.log($scope.usuario);

            $http({
                method: 'POST',
                url: myProvider.saveOld(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    id_cuota : $scope.id2.id_cuota,
                    id_usuario: $scope.usuario,
                   // id_usuario: '1',
                    costo: $scope.pago3.costo,
                    fecha_abono:now,
                    numero_comprobante: $scope.id2.id_cuota,
                    interes_mora: $scope.valorInteres,
                    dias_mora: "0",
                    costo_cobrado:  $scope.pago3.costo,
                    observacion: "obs",
                    hora: time



                }


            })
                .then(function (response) {


                    $http({
                        method: 'POST',
                        url: myProvider.updateCuota(),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: {
                            id_cuota : $scope.id2.id_cuota,
                            //id_usuario: $scope.usuario.id_usuario,
                            estado_cuota: '2',




                        }


                    })
                        .then(function (response) {





                            console.log(response.data);
                            $scope.loadAbono();
                            $scope.loadPagos();

                            //$scope.listaAbono.push(data);
                            // console.log($scope.listaAbono);
                        }, function errorCallback(response) {

                            // console.log(response);
                        });
                    
                    

                    //$scope.listaAbono.push(data);
                    // console.log($scope.listaAbono);
                }, function errorCallback(response) {

                    // console.log(response);
                });

        }





    }

    $scope.selectPag=function(){
        console.log($scope.id2.id_cuota);
        $scope.pago3.id_cuota=$scope.id2.id_cuota.toString();


    }


    $scope.countDays=function (date) {

        vec=date.split('-');
        var dt = new Date();

// Display the month, day, and year. getMonth() returns a 0-based number.
        var month = dt.getMonth()+1;
        var day = dt.getDate();
        var year = dt.getFullYear();
        var now=(year + '-' + month + '-' + day);

        var fecha1 = moment(now, "YYYY-MM-DD");
        var fecha2 = moment(date, "YYYY-MM-DD");

        var diff = fecha1.diff(fecha2, 'months'); // Diff in days
     //   console.log(diff+'meses');
        diff++;
        return(diff);



    }


    $scope.countDays2=function (date) {

        vec=date.split('-');
        var dt = new Date();

// Display the month, day, and year. getMonth() returns a 0-based number.
        var month = dt.getMonth()+1;
        var day = dt.getDate();
        var year = dt.getFullYear();
        var now=(year + '-' + month + '-' + day);

        var fecha1 = moment(now, "YYYY-MM-DD");
        var fecha2 = moment(date, "YYYY-MM-DD");

        var diff = fecha1.diff(fecha2, 'd'); // Diff in days
    //    console.log(diff+'dias');

        return(diff);



    }



    $scope.imprimir = function () {

        var dt = new Date();

// Display the month, day, and year. getMonth() returns a 0-based number.
        var month = dt.getMonth()+1;
        var day = dt.getDate();
        var year = dt.getFullYear();
        var now=(year + '-' + month + '-' + day);


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
            doc.text(x, y + 10, 'Numero Cuota:');
            doc.text(x + 30, y + 10,  $scope.id2.numero_cuota);
            doc.text(x, y+15, 'Codigo Contrato:');
            doc.text(x+10 + 23, y+15, $scope.id.codigo);
            doc.text(x, y+20, 'Cliente:');
            doc.text(x + 15, y+20, $scope.id.nombre);
            doc.text(x, y + 25, 'Cedula:');
            doc.text(x + 15, y + 25, $scope.id.ci_ruc);
            doc.text(x, y + 30, 'Fecha Maxima pago:');
            doc.text(x + 40, y + 30, $scope.id2.fecha_pago);
            doc.text(x, y + 35, 'Fecha  pago:');
            doc.text(x + 25, y + 35, now);
            doc.text(x, y + 40, 'Valor:');
            doc.text(x + 15, y + 40, $scope.id3.costo);

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