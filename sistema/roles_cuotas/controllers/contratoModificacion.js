app.controller('contratoMod', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {

    $scope.id_contrato;

    $scope.tipconcodigo = 'Mensual';
    $scope.estconcodigo = 'Vigente';
    $scope.venid = 1;
    $scope.idcliente = 4052;
    $scope.connumero = '';
    $scope.concedulacliente = '';
    $scope.connombrescompletoscliente = '';
    $scope.conciudadcliente = '';
    $scope.condirecciondomiciliocliente = '';

    $scope.concasapropiaarrendadacliente = '';

    $scope.concaracteristicasdomiciliocliente = '';
    $scope.conreferenciadomiciliocliente = '';
    $scope.contelefonodomiciliocliente = '';
    $scope.concelularcliente = '';
    $scope.conlugartrabajocliente = '';
    $scope.concargotrabajocliente = '';
    $scope.contiempolugartrabajocliente = '';
    $scope.condirecciontrabajocliente = '';
    $scope.contelefonostrabajocliente = '';
    $scope.conreferencialugartrabajocliente = '';
    $scope.concedulagaranteconyugue = '';
    $scope.connombrescompletosgaranteconyugue = '';
    $scope.conciudadgaranteconyugue = '';
    $scope.condirecciondomiciliogaranteconyugue = '';
    $scope.concaracteristicasdomiciliogaranteconyugue = '';

    $scope.concasapropiaarrendadagaranteconyugue = '';
    $scope.conreferenciadomiciliogaranteconyugue = '';
    $scope.contelefonocasagaranteconyugue = '';
    $scope.concelulargaranteconyugue = '';
    $scope.conlugartrabajogaranteconyugue = '';
    $scope.concargotrabajogaranteconyugue = '';
    $scope.contiempolugartrabajogaranteconyugue = '';
    $scope.condirecciontrabajogaranteconyugue = '';
    $scope.contelefonostrabajogaranteconyugue = '';
    $scope.concedulareferenciapersonal = '';
    $scope.connombrescompletosreferenciapersonal = '';
    $scope.condirecciondomicilioreferenciapersonal = '';
    $scope.concaracteristicasdomicilioreferenciapersonal = '';

    $scope.concasapropiaarrendadareferenciapersonal = '';
    $scope.conreferenciadomicilioreferenciapersonal = '';
    $scope.contelefonocasareferenciapersonal = '';
    $scope.concelularreferenciapersonal = '';
    $scope.conlugartrabajoreferenciapersonal = '';
    $scope.concargotrabajoreferenciapersonal = '';
    $scope.contiempolugartrabajoreferenciapersonal = '';
    $scope.condirecciontrabajoreferenciapersonal = '';
    $scope.contelefonostrabajoreferenciapersonal = '';
    $scope.concedulareferenciaestudiantil = '';
    $scope.connombrescompletosreferenciaestudiantil = '';
    $scope.conparentescoreferenciaestudiantil = '';
    $scope.coninstitucionreferenciaestudiantil = '';
    $scope.connivelreferenciaestudiantil = '';
    $scope.conplazocredito = '';

    $scope.coninterescredito = 3;
    $scope.coninteresmora = 1.5;
    $scope.concuotainicial = '';
    $scope.conentradapendiente = '';
    $scope.concostocuota = '';
    $scope.mod1 = '';
    $scope.obj;
    $scope.usuario;
    $scope.totalCompra = 1000;

    $scope.test = false;

    $scope.imprimir = function () {





            var doc = new jsPDF({

                unit: "mm",
                format: "letter"
            });

            var x = 20;
            var y = 35;

            doc.setFontSize(10);
            doc.setFillColor(176, 176, 176);
            doc.rect(0, 0, 300, 20, 'F');



            doc.text(x + 25, y + 10, $scope.conplazocredito.toString()+' meses');

            doc.text(x + 75, y + 10, $scope.coninterescredito.toString()+'%');

            doc.text(x + 105, y + 10, $scope.coninteresmora.toString() + '%');


            doc.text(x + 25, y + 15, '$' + $scope.concuotainicial.toString());

            $scope.confechacontrato = document.getElementById('datepicker').value;
            doc.text(x + 85, y + 15, $scope.confechacontrato.toString());


            doc.text(x + 35, y + 20, $scope.conentradapendiente.toString());


            //  $scope.id_contrato = '1';
            doc.text(x + 20, y + 35, $scope.id_contrato);

            var now = new Date();
            var month = now.getMonth() + 1;
            now = now.getDate() + '-' + month+ '-'+now.getFullYear();
            doc.text(x + 57, y + 35, now.toString());

            doc.text(x + 92, y + 35, $scope.clientePrint.ci_ruc);

            doc.text(x + 20, y + 40, $scope.clientePrint.nombre);

            doc.text(x + 20, y + 45, $scope.clientePrint.direccion);


            doc.text(x + 20, y + 50, $scope.concasapropiaarrendadacliente);

            doc.text(x + 75, y + 50, $scope.contelefonodomiciliocliente);

            doc.text(x + 130, y + 50, $scope.concelularcliente);

            doc.text(x, y + 60, $scope.concaracteristicasdomiciliocliente);

            doc.text(x, y + 70, $scope.conreferenciadomiciliocliente);

            doc.text(x , y + 85, $scope.conlugartrabajocliente);

            doc.text(x, y + 95, $scope.concargotrabajocliente);

            doc.text(x, y + 105, $scope.conreferencialugartrabajocliente);

            doc.text(x, y + 115, $scope.condirecciontrabajocliente);

            doc.text(x+20, y + 120, $scope.contiempolugartrabajocliente);

            doc.text(x+80, y + 120, $scope.contelefonostrabajocliente);


            doc.text(x+20, y + 135, $scope.concedulagaranteconyugue);

            doc.text(x + 65, y + 135, $scope.conciudadgaranteconyugue);

            doc.text(x + 95, y + 135, $scope.concasapropiaarrendadagaranteconyugue);

            doc.text(x, y + 145, $scope.connombrescompletosgaranteconyugue);

            doc.text(x, y + 155, $scope.condirecciondomiciliogaranteconyugue);

            doc.text(x, y + 165, $scope.concaracteristicasdomiciliogaranteconyugue);




            doc.text(x, y + 180, $scope.conlugartrabajogaranteconyugue);

            doc.text(x, y + 190, $scope.concargotrabajogaranteconyugue);

            doc.text(x, y + 200, $scope.condirecciontrabajogaranteconyugue);

            doc.text(x + 20, y + 205, $scope.contiempolugartrabajogaranteconyugue);

            doc.text(x + 80, y + 205, $scope.contiempolugartrabajogaranteconyugue);



            doc.setFontType("bold");
            doc.setFontSize(12);
            doc.text(x, y + 5, 'INFORMACION DEL CONTRATO:');
            //doc.text(x, y + 15, $scope.id_contrato);
            doc.setFontSize(10);
            doc.text(x, y + 10, 'Plazo Credito:');
            doc.text(x + 45, y + 10, 'Interes Credito:');
            doc.text(x + 85, y + 10, 'Interes Mora: ');
            doc.text(x, y + 15, 'Cuota Inicial:');
            doc.text(x + 45, y + 15, 'Fecha Cuota Inicial:');
            doc.text(x, y + 20, 'Entrada Pendiente:');
            doc.setFontSize(12);
            doc.text(x, y + 30, 'INFORMACION DEL CLIENTE:');
            doc.setFontSize(10);

            doc.text(x, y + 35, 'Id Contrato:');
            doc.text(x + 30, y + 35, 'Fecha Contrato');
            doc.text(x + 75, y + 35, 'Cedula:');
            doc.text(x, y + 40, 'Cliente:')
            doc.text(x, y + 45, 'Direccion:');
            doc.text(x, y + 50, 'Casa :');
            doc.text(x + 45, y + 50, 'Telefono Domicilio :');
            doc.text(x + 100, y + 50, 'Telefono Celular :');
            doc.text(x, y + 55, 'Caracteristicas de Domicilio :');
            doc.text(x, y + 65, 'Referencia de Domicilio :');
            doc.setFontSize(12);
            doc.text(x, y + 75, 'INFORMACION DEL CLIENTE TRABAJO:');
            doc.setFontSize(10);


            doc.text(x, y + 80, 'Trabajo :');
            doc.text(x, y + 90, 'Cargo :');
            doc.text(x, y + 100, 'Referencias :');
            doc.text(x, y + 110, 'Direccion :');
            doc.text(x, y + 120, 'Tiempo :');
            doc.text(x + 55, y + 120, 'Telefono :');

            doc.setFontSize(12);
            doc.text(x, y + 130, 'INFORMACION DEL CONYUGUE/GARANTE:');
            doc.setFontSize(10);
            doc.text(x, y + 135, 'Cedula :');
            doc.text(x + 45, y + 135, 'Ciudad :');
            doc.text(x + 85, y + 135, 'Casa :');
            doc.text(x, y + 140, 'Nombre :');
            doc.text(x, y + 150, 'Direccion :');
            doc.text(x, y + 160, 'Caracteristicas del domicilio :');
            doc.setFontSize(12);
            doc.text(x, y + 170, 'INFORMACION DEL CONYUGUE/GARANTE TRABAJO:');
            doc.setFontSize(10);
            doc.text(x, y + 175, 'Trabajo :');
            doc.text(x, y + 185, 'Cargo :');
            doc.text(x, y + 195, 'Direccion :');
            doc.text(x, y + 205, 'Tiempo :');
            doc.text(x + 55, y + 205, 'Telefono :');
            doc.setFontSize(14);
            doc.text(100, 10, 'ELECTROPARC CIA. LTDA.', 'center');
            doc.setFontSize(10);
            doc.text(100, 15, 'electroparc10@gmail.com', 'center');
            doc.setFontSize(14);
            doc.text(100, 30, 'CONTRATO', 'center');


            doc.setFontSize(8);
            doc.line(0, y + 230, 220, y + 230);
            doc.text(100, y + 235, 'Electroparc Cia. Ltda. ', 'center');

            doc.text(100, y + 238, 'Riobamba Ecuador ', 'center');

            doc.text(100, y + 241, 'Direccion: Matriz Lavalle 30 56 y Olmedo Esquina', 'center');

            doc.text(100, y + 244, 'Telefonos: 0994161053', 'center');
            doc.addPage();
            //doc.text(x, y + 65, 'Referencia de Domicilio :');
            // doc.text(x, y + 70, $scope.conreferenciadomiciliocliente);
            /*  doc.text(x, y + 20, 'CI:');
             doc.text(x + 20, y + 20, $scope.clientePrint.ci_ruc);
             var name = $scope.empleadoSeleccionado;
             doc.setFontSize(10);
             doc.setFontType("normal");

             doc.text(x, y + 5, 'Factura:');
             doc.text(x + 15, y + 5, $scope.id.id_venta);
             doc.text(x, y + 10, 'Descripcion Couta:');
             doc.text(x + 30, y + 10, $scope.id3.descripcion_pago);
             doc.text(x, y + 15, 'Codigo Contrato:');
             doc.text(x + 10 + 23, y + 15, $scope.id.codigo);
             doc.text(x, y + 20, 'Cliente:');
             doc.text(x + 15, y + 20, $scope.id.nombre);
             doc.text(x, y + 25, 'Cedula:');
             doc.text(x + 15, y + 25, $scope.id.ci_ruc);
             doc.text(x, y + 30, 'Fecha Maxima pago:');
             doc.text(x + 40, y + 30, $scope.id3.fecha_maxima);
             doc.text(x, y + 35, 'Fecha  pago:');
             doc.text(x + 25, y + 35, $scope.id3.fecha_pago);
             doc.text(x, y + 40, 'Valor:');
             doc.text(x + 15, y + 40, $scope.id3.valor);*/

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

            var x = 20;
            var y = 35;

            doc.setFontSize(10);
            doc.setFillColor(176, 176, 176);
            doc.rect(0, 0, 300, 20, 'F');
            doc.setFontType("normal");


            doc.text(x + 20, y + 10, $scope.concedulareferenciapersonal);

            doc.text(x + 65, y + 10, $scope.concasapropiaarrendadareferenciapersonal);

            doc.text(x, y + 20, $scope.connombrescompletosreferenciapersonal);

            doc.text(x, y + 30, $scope.condirecciondomicilioreferenciapersonal);

            doc.text(x, y + 40, $scope.concaracteristicasdomicilioreferenciapersonal);



            doc.text(x, y + 55, $scope.conlugartrabajoreferenciapersonal);

            doc.text(x, y + 65, $scope.concargotrabajoreferenciapersonal);

            doc.text(x, y + 75, $scope.condirecciontrabajoreferenciapersonal);

            doc.text(x + 20, y + 80, $scope.contiempolugartrabajoreferenciapersonal);

            doc.text(x + 80, y + 80, $scope.contelefonostrabajoreferenciapersonal);



            doc.text(x + 20, y + 90, $scope.concedulareferenciaestudiantil);

            doc.text(x + 65, y + 90, $scope.connivelreferenciaestudiantil);

            doc.text(x, y + 100, $scope.connombrescompletosreferenciaestudiantil);

            doc.text(x, y + 110, $scope.conparentescoreferenciaestudiantil);

            doc.text(x, y + 120, $scope.coninstitucionreferenciaestudiantil);



            doc.setFontType("bold");
            doc.setFontSize(12);
            doc.text(x, y + 5, 'INFORMACION REFERENCIA PERSONAL:');
            doc.setFontSize(10);
            doc.text(x, y + 10, 'Cedula :');
            doc.text(x + 45, y + 10, 'Casa :');
            doc.text(x, y + 15, 'Nombre :');
            doc.text(x, y + 25, 'Direccion :');
            doc.text(x, y + 35, 'Caracteristicas del domicilio :');
            doc.setFontSize(12);
            doc.text(x, y + 45, 'INFORMACION REFERENCIA PERSONAL TRABAJO:');
            doc.setFontSize(10);

            doc.text(x, y + 50, 'Trabajo :');
            doc.text(x, y + 60, 'Cargo :');
            doc.text(x, y + 70, 'Direccion :');
            doc.text(x, y + 80, 'Tiempo :');
            doc.text(x + 55, y + 80, 'Telefono :');
            doc.setFontSize(12);
            doc.text(x, y + 85, 'INFORMACION REFERENCIA ESTUDIANTIL:');
            doc.setFontSize(10);
            doc.text(x, y + 90, 'Cedula :');
            doc.text(x + 45, y + 90, 'Nivel :');
            doc.text(x, y + 95, 'Nombre :');
            doc.text(x, y + 105, 'Parentezco :');
            doc.text(x, y + 115, 'Institucion :');
            doc.setFontSize(14);
            doc.text(100, 10, 'ELECTROPARC CIA. LTDA.', 'center');
            doc.setFontSize(10);
            doc.text(100, 15, 'electroparc10@gmail.com', 'center');
            doc.setFontSize(14);
            doc.text(100, 30, 'CONTRATO', 'center');


            doc.setFontSize(8);
            doc.line(0, y + 230, 220, y + 230);
            doc.text(100, y + 235, 'Electroparc Cia. Ltda. ', 'center');

            doc.text(100, y + 238, 'Riobamba Ecuador ', 'center');

            doc.text(100, y + 241, 'Direccion: Matriz Lavalle 30 56 y Olmedo Esquina', 'center');

            doc.text(100, y + 244, 'Telefonos: 0994161053', 'center');


            doc.line(80, y + 190, 120, y + 190);
            doc.line(150, y + 190, 190, y + 190);
            doc.line(x, y + 190, x+40, y + 190);
            doc.text(x, y + 195, 'Realizado por  '+  $scope.usuario.nombre );
            doc.text(80, y + 195, 'Cliente ' );
            doc.text(150, y + 195, 'Autorizado por' );
            //  doc.setTextColor(255, 0, 0);
            // doc.text(100, 25, 'USD.00');
            $scope.dateN = Date.now;
            $scope.name = 'Contrato' + $scope.dateN;
            doc.save('Contrato.pdf');


    };
    $scope.iniciar = function () {


        $scope.mod1 = window.localStorage.getItem('mod1');
        console.log($scope.mod1);

        if ($scope.mod1 != undefined && $scope.mod1 != '') {

            $scope.obj = JSON.parse($scope.mod1);
            console.log($scope.obj);
            console.log($scope.obj.codigo);
            console.log($scope.obj.id_venta);
           
        }


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
        $scope.compra;
        $scope.clientePrint;

        $http({
            method: 'POST',
            url: myProvider.getAllCompra(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id_factura: $scope.venid

            }
        })
            .then(function (response) {

                $scope.compra = response.data;
                console.log($scope.compra);

            }, function errorCallback(response) {
                // console.log(url2);
                //console.log(response.data);
            });

        $http({
            method: 'POST',
            url: myProvider.getClientePrint(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id_cliente: $scope.idcliente

            }
        })
            .then(function (response) {

                $scope.clientePrint = response.data[0];
                console.log($scope.clientePrint);
                $http({
                    method: 'POST',
                    url: myProvider.getClientePrint(),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: {
                        id_cliente: $scope.idcliente

                    }
                }).then(function (response) {


                }, function errorCallback(response) {
                    // console.log(url2);
                    //console.log(response.data);
                });
            }, function errorCallback(response) {
                // console.log(url2);
                //console.log(response.data);
            });


    }


    $scope.guardar = function () {
        $http({
            method: 'POST',
            url: myProvider.getAllContratosActiMod1(),
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.obj.codigo,
                tipconcodigo: $scope.obj.tipconcodigo,
                estconcodigo: $scope.obj.estconcodigo,
                venid: $scope.obj.id_venta,
                idcliente:  $scope.obj.id_cliente,

                concasapropiaarrendadacliente: $scope.obj.concasapropiaarrendadacliente,

                concaracteristicasdomiciliocliente: $scope.obj.concaracteristicasdomiciliocliente,
                conreferenciadomiciliocliente: $scope.obj.conreferenciadomiciliocliente,
                contelefonodomiciliocliente: $scope.obj.contelefonodomiciliocliente,
                concelularcliente: $scope.obj.concelularcliente,
                conlugartrabajocliente: $scope.obj.conlugartrabajocliente,
                concargotrabajocliente: $scope.obj.concargotrabajocliente,
                contiempolugartrabajocliente: $scope.obj.contiempolugartrabajocliente,
                condirecciontrabajocliente: $scope.obj.condirecciontrabajocliente,
                contelefonostrabajocliente: $scope.obj.contelefonostrabajocliente,
                conreferencialugartrabajocliente: $scope.obj.conreferencialugartrabajocliente,
                concedulagaranteconyugue: $scope.obj.concedulagaranteconyugue,
                connombrescompletosgaranteconyugue: $scope.obj.connombrescompletosgaranteconyugue,
                conciudadgaranteconyugue: $scope.obj.conciudadgaranteconyugue,
                condirecciondomiciliogaranteconyugue: $scope.obj.condirecciondomiciliogaranteconyugue,
                concaracteristicasdomiciliogaranteconyugue: $scope.obj.concaracteristicasdomiciliogaranteconyugue,

                concasapropiaarrendadagaranteconyugue: $scope.obj.concasapropiaarrendadagaranteconyugue,
                conreferenciadomiciliogaranteconyugue: $scope.obj.conreferenciadomiciliogaranteconyugue,
                contelefonocasagaranteconyugue: $scope.obj.contelefonocasagaranteconyugue,
                concelulargaranteconyugue: $scope.obj.concelulargaranteconyugue,
                conlugartrabajogaranteconyugue: $scope.obj.conlugartrabajogaranteconyugue,
                concargotrabajogaranteconyugue: $scope.obj.concargotrabajogaranteconyugue,
                contiempolugartrabajogaranteconyugue: $scope.obj.contiempolugartrabajogaranteconyugue,
                condirecciontrabajogaranteconyugue: $scope.obj.condirecciontrabajogaranteconyugue,
                contelefonostrabajogaranteconyugue: $scope.obj.contelefonostrabajogaranteconyugue,
                concedulareferenciapersonal: $scope.obj.concedulareferenciapersonal,
                connombrescompletosreferenciapersonal: $scope.obj.connombrescompletosreferenciapersonal,
                condirecciondomicilioreferenciapersonal: $scope.obj.condirecciondomicilioreferenciapersonal,
                concaracteristicasdomicilioreferenciapersonal: $scope.obj.concaracteristicasdomicilioreferenciapersonal,

                concasapropiaarrendadareferenciapersonal: $scope.obj.concasapropiaarrendadareferenciapersonal,
                conreferenciadomicilioreferenciapersonal: $scope.obj.conreferenciadomicilioreferenciapersonal,
                contelefonocasareferenciapersonal: $scope.obj.contelefonocasareferenciapersonal,
                concelularreferenciapersonal: $scope.obj.concelularreferenciapersonal,
                conlugartrabajoreferenciapersonal: $scope.obj.conlugartrabajoreferenciapersonal,
                concargotrabajoreferenciapersonal: $scope.obj.concargotrabajoreferenciapersonal,
                contiempolugartrabajoreferenciapersonal: $scope.obj.contiempolugartrabajoreferenciapersonal,
                condirecciontrabajoreferenciapersonal: $scope.obj.condirecciontrabajoreferenciapersonal,
                contelefonostrabajoreferenciapersonal: $scope.obj.contelefonostrabajoreferenciapersonal,
                concedulareferenciaestudiantil: $scope.obj.concedulareferenciaestudiantil,
                connombrescompletosreferenciaestudiantil: $scope.obj.connombrescompletosreferenciaestudiantil,
                conparentescoreferenciaestudiantil: $scope.obj.conparentescoreferenciaestudiantil,
                coninstitucionreferenciaestudiantil: $scope.obj.coninstitucionreferenciaestudiantil,
                connivelreferenciaestudiantil: $scope.obj.connivelreferenciaestudiantil
               


            }


        })
            .then(function (response) {
                console.log(response.data);
                localStorage.removeItem('mod1');
                window.location = 'tableContrato.html';

            },


            function errorCallback(response) {

                   console.log(response.data);

            });



    }

    $scope.regresar = function () {
        localStorage.removeItem('mod1');
        window.location = 'tableContrato.html';
    }
}]);