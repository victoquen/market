app.controller('test', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {




    $scope.listEmpleados;
    $scope.search;
    $scope.empleadoSeleccionado;
    $scope.contrato = {
        codigo: '',

    };
    $scope.listaanios=[];
    $scope.anioSeleccionado;
    $scope.mesSeleccionado;
    $scope.diasNoLaborados;
    $scope.seguro;
    $scope.comision=0;
    $scope.descuento=0;
    $scope.total;
    $scope.totalDiasMes;
    $scope.diaslaborados;
    $scope.flag = false;
    $scope.fechasNoLaboradas;
    $scope.inicializar = function(){
        $scope.vec1;



        for (var i = 2016; i < 2100; i++) {

            $scope.listaanios.push(i);
        }
        var url = myProvider.getEmpleados();
        console.log(url);
        $http({
            method: 'POST',
            url: myProvider.getEmpleados(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
               


            }


        })
            .then(function (response) {

                $scope.listEmpleados = response.data;
          
            }, function errorCallback(response) {
            
                console.log(response);
            });


        $scope.mod = window.localStorage.getItem('mod');
      
        if ($scope.mod != undefined && $scope.mod != '') {

            $scope.obj = JSON.parse($scope.mod);
            console.log($scope.obj);
            $scope.empleadoSeleccionado = {
                id:$scope.obj.id_empleado,
                nombre: $scope.obj.nombre_empleado
            }
            $scope.contrato.codigo = $scope.obj.codigo;
            $scope.contrato.sueldo = $scope.obj.sueldo;
            $scope.contrato.id = $scope.obj.id_contrato;
            $scope.anioSeleccionado = $scope.obj.anio;
            $scope.mesSeleccionado = $scope.obj.mes;
            console.log($scope.obj);
           
          //  console.log($scope.vec1);
           // document.getElementById('datepicker').value = "18/04/2017";


            if ($scope.obj.dias_no_laborados.toString() == 'null') {

                $scope.diasNoLaborados = 0;
            } else {
                $scope.vec1 = $scope.obj.dias_no_laborados.split(',');
                var vec = $scope.obj.dias_no_laborados.split(',');
                var num = vec.length;
                console.log(num);
                $scope.diasNoLaborados = num;
                console.log(vec[0]);
                document.getElementById('datepicker').value =vec[0];
            }
            $scope.seguroShow = parseFloat($scope.obj.seguro);
            $scope.seguro = parseFloat($scope.obj.seguro);
            $scope.descuento = parseFloat($scope.obj.descuento);
            $scope.comision = parseFloat($scope.obj.comision);
            $scope.total = parseFloat($scope.obj.total_pagar);
            console.log($scope.contrato);
            
        }

       
    }

    $(function () {




        $('.datepicker').datepicker({
            multidate: true,
            language: 'es',
        });



        $('.datepicker').datepicker('setDates', $scope.vec1)

    });

    $scope.buscarContratoEmpleado = function () {

        if ($scope.empleadoSeleccionado != undefined && $scope.empleadoSeleccionado != '') {

      
            $scope.auxempleadoSeleccionado = JSON.parse($scope.empleadoSeleccionado);
 
            
            $http({
                method: 'POST',
                url: myProvider.getContrato(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    taskID: $scope.auxempleadoSeleccionado.id


                }


            })
                .then(function (response) {

                    $scope.contrato = response.data[0];
                    $scope.seguro = $scope.contrato.sueldo * 0.2160;
                    $scope.seguroShow = parseFloat($scope.fixedNumbers($scope.seguro));
                 //   console.log($scope.seguroShow);
                }, function errorCallback(response) {
         
                    console.log(response);
                });
        }
    }


    $scope.contarDias = function () {

        if ($scope.contrato != undefined && $scope.contrato != '' && $scope.mesSeleccionado != undefined && $scope.mesSeleccionado != '' && $scope.anioSeleccionado != undefined && $scope.anioSeleccionado != '') {
           // console.log($scope.mesSeleccionado);
          //  console.log($scope.anioSeleccionado);
            var aux = document.getElementById('datepicker').value;
            $scope.fechasNoLaboradas = aux;
            if (aux != '' && aux != undefined) {
                var vec = aux.split(',');
                var num = vec.length;
               // console.log(num);
                $scope.diasNoLaborados = num;

            } else {
                $scope.diasNoLaborados = 0;
                $scope.fechasNoLaboradas = 'null';
            }
            

            switch ($scope.mesSeleccionado) {

                case '1': $scope.totalDiasMes = 31; break;
                case '2':


                    if ($scope.anioSeleccionado % 4 == 0 || $scope.anioSeleccionado % 100 != 0 && $scope.anioSeleccionado % 400 == 0) {
                        $scope.totalDiasMes = 29;
                      //  console.log($scope.totalDiasMes);

                    } else {
                        $scope.totalDiasMes = 28;
                      //  console.log($scope.totalDiasMes);
                    }

                    break;
                case '3': $scope.totalDiasMes = 31; break;
                case '4': $scope.totalDiasMes = 30; break;
                case '5': $scope.totalDiasMes = 31; break;
                case '6': $scope.totalDiasMes = 30; break;
                case '7': $scope.totalDiasMes = 31; break;
                case '8': $scope.totalDiasMes = 31; break;
                case '9': $scope.totalDiasMes = 30; break;
                case '10': $scope.totalDiasMes = 31; break;
                case '11': $scope.totalDiasMes = 30; break;
                case '12': $scope.totalDiasMes = 31; break;



            }
            // console.log($scope.totalDiasMes);
            $scope.diaslaborados = $scope.totalDiasMes - $scope.diasNoLaborados;
         //   console.log($scope.diaslaborados);
            if ($scope.diasNoLaborados != 0) {

                $scope.descuento = $scope.diasNoLaborados * $scope.fixedNumbers($scope.contrato.sueldo / $scope.totalDiasMes);
                $scope.descuento = parseFloat($scope.fixedNumbers($scope.descuento));
               // console.log($scope.descuento);
            } else {
                $scope.descuento = 0;
            }
            
            $scope.total = $scope.contrato.sueldo - $scope.seguroShow - $scope.descuento + $scope.comision;
          //  console.log($scope.total);
            $scope.flag = true;
        } else {

            alert('Ingrese todos los campos para poder realizar el calculo');
        }
    }

    $scope.fixedNumbers = function (cal) {

        var constant100 = 100;
        var resp = (Math.floor(cal * constant100) / constant100).toFixed(2);
        console.log(resp);
        return (resp);
    }

    $scope.save = function () {


        if ($scope.flag == true) {

            
            //console.log(url);
            $http({
                method: 'POST',
                url: myProvider.getRol(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    id_contrato_empleado: $scope.contrato.id ,
                     seguro: $scope.seguroShow ,
                    sueldo:$scope.contrato.sueldo ,
                    descuento: $scope.descuento ,
                    comision: $scope.comision ,
                    total_dias:$scope.diaslaborados ,
                    total_pagar: $scope.total ,
                    mes:$scope.mesSeleccionado ,
                    anio:$scope.anioSeleccionado ,
                    dias_no_laborados:$scope.fechasNoLaboradas


                }


            })
                .then(function (response) {

                    if (response.data[0] == 1) {

                        alert('guardado exitosamente');
                        $scope.listEmpleados=[];
                        $scope.search='';
                        $scope.empleadoSeleccionado='';
                        $scope.contrato='';
                        $scope.listaanios = [];
                        $scope.anioSeleccionado='';
                        $scope.mesSeleccionado='';
                        $scope.diasNoLaborados='';
                        $scope.seguro = '';
                        $scope.seguroShow = '';
                        $scope.comision='';
                        $scope.descuento='';
                        $scope.total='';
                        $scope.totalDiasMes='';
                        $scope.diaslaborados='';
                        $scope.flag = false;
                        $scope.fechasNoLaboradas = '';
                        document.getElementById('datepicker').value = '';
                        $scope.inicializar();
                    } else {
                        alert('erro al guardar ');
                    }
                    
                }, function errorCallback(response) {

                  //  console.log(response);
                });

        } else {
            alert('Para guardar debe calcular la información');
        }



    }



    $scope.modificar = function () {


        if ($scope.flag == true) {


   

            $http({
                method: 'POST',
                url: myProvider.getModRol(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    id_contrato_empleado:$scope.contrato.id ,
                     seguro:$scope.seguroShow ,
                    sueldo: $scope.contrato.sueldo,
                    descuento:$scope.descuento,
                    comision: $scope.comision,
                    total_dias:$scope.diaslaborados,
                    total_pagar: $scope.total ,
                    mes:$scope.mesSeleccionado ,
                    anio: $scope.anioSeleccionado ,
                    dias_no_laborados: $scope.fechasNoLaboradas ,
                    id: $scope.obj.id

                }


            })
                .then(function (response) {

                    if (response.data[0] == 1) {

                        alert('guardado exitosamente');
                        $scope.listEmpleados = [];
                        $scope.search = '';
                        $scope.empleadoSeleccionado = '';
                        $scope.contrato = '';
                        $scope.listaanios = [];
                        $scope.anioSeleccionado = '';
                        $scope.mesSeleccionado = '';
                        $scope.diasNoLaborados = '';
                        $scope.seguro = '';
                        $scope.seguroShow = '';
                        $scope.comision = '';
                        $scope.descuento = '';
                        $scope.total = '';
                        $scope.totalDiasMes = '';
                        $scope.diaslaborados = '';
                        $scope.flag = false;
                        $scope.fechasNoLaboradas = '';
                        document.getElementById('datepicker').value = '';
                        $scope.inicializar();
                        localStorage.removeItem('mod');
                        window.location = 'table.html';
                    } else {
                        alert('erro al guardar ');
                    }

                }, function errorCallback(response) {

                    //  console.log(response);
                });

        } else {
            alert('Para guardar debe calcular la información');
        }


    }

    $scope.testPrint = function(){
        var doc = new jsPDF({

            unit: "mm",
            format: "letter"
        });

        var x = 20;
        var y = 50;


        doc.setFillColor(176, 176, 176);
        doc.rect(0, 0, 300, 30, 'F');
        var name = JSON.parse($scope.empleadoSeleccionado);
        doc.setFontSize(12);
        doc.setFontType("normal");
        doc.text(x, y, 'Empleado:');
        doc.text(x+23, y, name.nombre);
        doc.text(x, y+10, 'Codigo Contrato:');
        if ($scope.contrato.codigo != null) {
             doc.text(x+40, y+10, $scope.contrato.codigo);
        }else{

              doc.text(x+40, y+10, 'Sin Codigo');

        }
        var mes;
        switch ($scope.mesSeleccionado) {

            case '1': mes = 'Enero'; break;
            case '2':mes = 'Febrero'; break;
            case '3':mes = 'Marzo'; break;
            case '4': mes = 'Abril'; break;
            case '5': mes = 'Mayo'; break;
            case '6': mes = 'Junio'; break;
            case '7': mes = 'Julio'; break;
            case '8': mes = 'Agosto'; break;
            case '9': mes = 'Septiembre'; break;
            case '10': mes = 'Octubre'; break;
            case '11': mes = 'Noviembre'; break;
            case '11': mes = 'Diciembre'; break;
        }
        //doc.text(x, y+20, 'Mes:');
        doc.text(x , y+20, mes);
      //  $scope.aux =  ["Año:"];
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
            days='sin dias'
        }
        
        doc.text(x, y + 35, days);
        doc.text(x, y + 40, 'Total Dias no Laborados:');
        if (m != undefined) {
            doc.text(x + 50, y + 40, m.toString());
        } else {
            doc.text(x + 50, y + 40, '0');
        }
        
        doc.text(x, y + 45, 'Sueldo:');
        doc.text(x + 50, y + 45, $scope.contrato.sueldo);
        doc.text(x, y + 50, 'Seguro:');
        doc.text(x + 50, y + 50, $scope.seguroShow.toString());
        doc.text(x, y + 55, 'Descuento:');
        doc.text(x + 50, y + 55, $scope.descuento.toString());
        doc.text(x, y + 60, 'Comision:');
        doc.text(x + 50, y + 60, $scope.comision.toString());
        doc.text(x, y + 65, 'Total:');
        var aux = $scope.total.toFixedDown(2);
        doc.text(x + 50, y + 65, aux.toString());
        //doc.setFontType("bold");
        doc.text(100, 10, 'ELECTROPARC CIA. LTDA.', 'center');
        doc.setFontSize(10);
        doc.text(100, 20, 'electroparc10@gmail.com', 'center');
        doc.setFontSize(14);
        doc.text(100, 40, 'ROL DE PAGO', 'center');


        doc.setFontSize(10);
        doc.text(100, y + 75, 'Electroparc Cia. Ltda. ', 'center');

        doc.text(100, y + 80, 'Riobamba Ecuador ', 'center');

        doc.text(100, y + 85, 'Direccion: Matriz Lavalle 30 56 y Olmedo Esquina', 'center');

        doc.text(100, y + 90, 'Telefonos: 0994161053', 'center');


        doc.line(100, y + 65, 140, y + 65);
        doc.line(150, y + 65, 190, y + 65);
        //  doc.setTextColor(255, 0, 0);
        // doc.text(100, 25, 'USD.00');
        $scope.dateN = Date.now;
        $scope.name = 'RolPago' + $scope.dateN;
        doc.save('RolPago.pdf');
    }
    $scope.testPrint2 = function () {

        var doc = new jsPDF({
            
            unit: "mm",
            format: "letter"
        });

        var x = 20;
        var y = 50;


        doc.setFillColor(176, 176, 176);
        doc.rect(0, 0, 300, 30, 'F');
        var name = $scope.empleadoSeleccionado;
        doc.setFontSize(12);
        doc.setFontType("normal");
        doc.text(x, y, 'Empleado:');
        doc.text(x + 23, y, name.nombre);
        doc.text(x, y + 10, 'Codigo Contrato:');
        if ($scope.contrato.codigo != null) {
            doc.text(x + 40, y + 10, $scope.contrato.codigo);
        } else {

            doc.text(x + 40, y + 10, 'Sin Codigo');

        }
        var mes;
        switch ($scope.mesSeleccionado) {

            case '1': mes = 'Enero'; break;
            case '2': mes = 'Febrero'; break;
            case '3': mes = 'Marzo'; break;
            case '4': mes = 'Abril'; break;
            case '5': mes = 'Mayo'; break;
            case '6': mes = 'Junio'; break;
            case '7': mes = 'Julio'; break;
            case '8': mes = 'Agosto'; break;
            case '9': mes = 'Septiembre'; break;
            case '10': mes = 'Octubre'; break;
            case '11': mes = 'Noviembre'; break;
            case '11': mes = 'Diciembre'; break;
        }
        //doc.text(x, y+20, 'Mes:');
        doc.text(x, y + 20, mes);
        //  $scope.aux =  ["Año:"];
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

        doc.text(x , y + 35, days);
        doc.text(x, y + 40, 'Total Dias no Laborados:');
        if (m != undefined) {
            doc.text(x + 50, y + 40, m.toString());
        } else {
            doc.text(x + 50, y + 40, '0');
        }

        doc.text(x , y + 45, 'Sueldo:');
        doc.text(x + 50, y + 45, $scope.contrato.sueldo);
        doc.text(x  , y + 50, 'Seguro:');
        doc.text(x + 50, y + 50, $scope.seguroShow.toString());
        doc.text(x , y + 55, 'Descuento:');
        doc.text(x + 50, y + 55, $scope.descuento.toString());
        doc.text(x , y + 60, 'Comision:');
        doc.text(x + 50, y + 60, $scope.comision.toString());
        doc.text(x, y + 65, 'Total:');
        var aux = $scope.total.toFixedDown(2);
        doc.text(x + 50, y + 65,aux.toString());
        //doc.setFontType("bold");
        doc.text(100, 10, 'ELECTROPARC CIA. LTDA.', 'center');
        doc.setFontSize(10);
        doc.text(100, 20, 'electroparc10@gmail.com', 'center');
        doc.setFontSize(14);
        doc.text(100, 40, 'ROL DE PAGO', 'center');


        doc.setFontSize(10);
        doc.text(100, y + 75, 'Electroparc Cia. Ltda. ', 'center');

        doc.text(100, y + 80, 'Riobamba Ecuador ', 'center');

        doc.text(100, y + 85, 'Direccion: Matriz Lavalle 30 56 y Olmedo Esquina', 'center');

        doc.text(100, y + 90, 'Telefonos: 0994161053', 'center');


        doc.line(100, y+65, 140, y+65);
        doc.line(150, y + 65, 190, y + 65);
        //  doc.setTextColor(255, 0, 0);
        // doc.text(100, 25, 'USD.00');
        $scope.dateN = Date.now;
        $scope.name = 'RolPago' + $scope.dateN;
        doc.save('RolPago.pdf');
    }


    $scope.cancelar = function () {

        $scope.inicializar();
        localStorage.removeItem('mod');
        window.location = 'table.html';


    }
    $scope.cancelar2 = function () {

       // $scope.inicializar();
      //  localStorage.removeItem('mod');
        window.location = 'table.html';


    }

    Number.prototype.toFixedDown = function (digits) {
        var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
            m = this.toString().match(re);
        return m ? parseFloat(m[1]) : this.valueOf();
    };
} ]);