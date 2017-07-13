
app.controller('contrato', ['$scope', '$http', '$location', 'myProvider', '$localStorage', function ($scope, $http, $location, myProvider, $localStorage) {

    $scope.id_contrato;

    $scope.tipconcodigo='Mensual';
    $scope.estconcodigo='Vigente';
    $scope.venid='';
    $scope.idcliente='';
    $scope.connumero='';
    $scope.concedulacliente='';
    $scope.connombrescompletoscliente='';
    $scope.conciudadcliente='';
    $scope.condirecciondomiciliocliente='';

    $scope.concasapropiaarrendadacliente='';
  
    $scope.concaracteristicasdomiciliocliente='';
    $scope.conreferenciadomiciliocliente='';
    $scope.contelefonodomiciliocliente='';
    $scope.concelularcliente='';
    $scope.conlugartrabajocliente='';
    $scope.concargotrabajocliente='';
    $scope.contiempolugartrabajocliente='';
    $scope.condirecciontrabajocliente='';
    $scope.contelefonostrabajocliente='';
    $scope.conreferencialugartrabajocliente='';
    $scope.concedulagaranteconyugue='';
    $scope.connombrescompletosgaranteconyugue='';
    $scope.conciudadgaranteconyugue='';
    $scope.condirecciondomiciliogaranteconyugue='';
    $scope.concaracteristicasdomiciliogaranteconyugue='';

    $scope.concasapropiaarrendadagaranteconyugue='';
    $scope.conreferenciadomiciliogaranteconyugue='';
    $scope.contelefonocasagaranteconyugue='';
    $scope.concelulargaranteconyugue='';
    $scope.conlugartrabajogaranteconyugue='';
    $scope.concargotrabajogaranteconyugue='';
    $scope.contiempolugartrabajogaranteconyugue='';
    $scope.condirecciontrabajogaranteconyugue='';
    $scope.contelefonostrabajogaranteconyugue='';
    $scope.concedulareferenciapersonal='';
    $scope.connombrescompletosreferenciapersonal='';
    $scope.condirecciondomicilioreferenciapersonal='';
    $scope.concaracteristicasdomicilioreferenciapersonal='';

    $scope.concasapropiaarrendadareferenciapersonal='';
    $scope.conreferenciadomicilioreferenciapersonal='';
    $scope.contelefonocasareferenciapersonal='';
    $scope.concelularreferenciapersonal='';
    $scope.conlugartrabajoreferenciapersonal='';
    $scope.concargotrabajoreferenciapersonal='';
    $scope.contiempolugartrabajoreferenciapersonal='';
    $scope.condirecciontrabajoreferenciapersonal='';
    $scope.contelefonostrabajoreferenciapersonal='';
    $scope.concedulareferenciaestudiantil='';
    $scope.connombrescompletosreferenciaestudiantil='';
    $scope.conparentescoreferenciaestudiantil='';
    $scope.coninstitucionreferenciaestudiantil='';
    $scope.connivelreferenciaestudiantil='';
    $scope.conplazocredito='';
    $scope.confechacontrato='';
    $scope.coninterescredito=3;
    $scope.coninteresmora=1.5;
    $scope.concuotainicial='';
    $scope.conentradapendiente='';
    $scope.concostocuota='';
    $scope.compra;
    $scope.clientePrint;
    $scope.id_contrato;
    $scope.totalCompra=1000;
    $scope.usuario;
    $scope.test=false;
    $scope.telefonos;
    $scope.flag1=false;


    $scope.imprimir = function () {

        if($scope.flag1==true){



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

        }else{

            alert('para imprimir se debe guardar el contrato');

        }
    };

    $scope.inicio = function () {

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
       // $scope.loadContratos();

        $scope.local1 = window.localStorage.getItem('idCliente');
        $scope.local2 = window.localStorage.getItem('idFactura');
        $scope.local3 = window.localStorage.getItem('totalFactura');

        console.log("CHECK INI: " + $scope.local1 + " -- " +$scope.local2);


        $scope.id_contrato;

        $scope.tipconcodigo = 'Mensual';
        $scope.estconcodigo = 'Vigente';
        $scope.venid = $scope.local2;
        $scope.idcliente = $scope.local1;
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
        $scope.confechacontrato = '';
        $scope.coninterescredito = 3;
        $scope.coninteresmora = 1.5;
        $scope.concuotainicial = '';
        $scope.conentradapendiente = '';
        $scope.concostocuota = '';

        $scope.totalCompra = $scope.local3;

        $scope.test = false;
        $scope.telefonos;
        document.getElementById('datepicker').value = '';


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

    $scope.calculos = function () {
        $scope.confechacontrato = document.getElementById('datepicker').value;
        $scope.vec1 = $scope.confechacontrato.split('/');

        $scope.formatedDate = $scope.vec1[2] + '-' + $scope.vec1[1] + '-' + $scope.vec1[0];
        console.log($scope.formatedDate);
        if ($scope.conplazocredito <= 4) {

            $scope.coninterescredito = 0;
            $scope.costoCuota = parseFloat(fixedNumbers(($scope.totalCompra - $scope.concuotainicial) / $scope.conplazocredito));
            $scope.concostocuota = parseFloat(fixedNumbers(($scope.totalCompra) ));
            console.log($scope.concostocuota);

        } else {
            $scope.coninterescredito = parseFloat(fixedNumbers($scope.coninterescredito / 100));
           
          
            $scope.total1 = fixedNumbers((($scope.totalCompra - $scope.concuotainicial) / $scope.conplazocredito) * ($scope.coninterescredito + 1));
            //console.log($scope.total1);
            $scope.costoCuota = parseFloat($scope.total1);
            $scope.concostocuota = fixedNumbers($scope.concuotainicial + ($scope.totalCompra - $scope.concuotainicial) * ($scope.coninterescredito + 1));
            console.log($scope.concostocuota);
        }


    }







    $scope.guardar = function () {

        console.log("CHECK 1: " +$scope.idcliente);
        $scope.confechacontrato = document.getElementById('datepicker').value;

        $scope.vec1 = $scope.confechacontrato.split('/');

        $scope.formatedDate = $scope.vec1[2] + '-' + $scope.vec1[1] + '-' + $scope.vec1[0];
     
        //$scope.confechacontrato = document.getElementById('datepicker').value;
        //$scope.vec1 = $scope.confechacontrato.split('/');

        //$scope.formatedDate = $scope.vec1[2] + '-' + $scope.vec1[1] + '-' + $scope.vec1[0];
        console.log($scope.formatedDate);

        if ($scope.conplazocredito <= 4) {

            $scope.coninterescredito = 0;
            $scope.costoCuota = parseFloat(fixedNumbers(($scope.totalCompra - $scope.concuotainicial) / $scope.conplazocredito));
            $scope.concostocuota = parseFloat(fixedNumbers(($scope.totalCompra)));
           // console.log($scope.concostocuota);

        } else {
            $scope.coninterescreditoAux = parseFloat(fixedNumbers($scope.coninterescredito / 100));


            $scope.total1 = fixedNumbers((($scope.totalCompra - $scope.concuotainicial) / $scope.conplazocredito) * ($scope.coninterescreditoAux + 1));
            //console.log($scope.total1);
            $scope.costoCuota = parseFloat($scope.total1);
            $scope.concostocuota = fixedNumbers($scope.concuotainicial+($scope.totalCompra - $scope.concuotainicial) * ($scope.coninterescredito + 1));
           // console.log($scope.costoCuota);
        }
      




            $http({
                method: 'POST',
                url: myProvider.getContratoIns(),
                headers: {
                    'Content-Type': 'application/json'
                },
                data: {
                    tipconcodigo: $scope.tipconcodigo,
                    estconcodigo: $scope.estconcodigo,
                    venid: $scope.venid,
                    idcliente: $scope.idcliente,
                 
                    concasapropiaarrendadacliente: $scope.concasapropiaarrendadacliente,
          
                    concaracteristicasdomiciliocliente: $scope.concaracteristicasdomiciliocliente,
                    conreferenciadomiciliocliente: $scope.conreferenciadomiciliocliente,
                    contelefonodomiciliocliente: $scope.contelefonodomiciliocliente,
                    concelularcliente: $scope.concelularcliente,
                    conlugartrabajocliente: $scope.conlugartrabajocliente,
                    concargotrabajocliente: $scope.concargotrabajocliente,
                    contiempolugartrabajocliente: $scope.contiempolugartrabajocliente,
                    condirecciontrabajocliente: $scope.condirecciontrabajocliente,
                    contelefonostrabajocliente: $scope.contelefonostrabajocliente,
                    conreferencialugartrabajocliente: $scope.conreferencialugartrabajocliente,
                    concedulagaranteconyugue: $scope.concedulagaranteconyugue,
                    connombrescompletosgaranteconyugue: $scope.connombrescompletosgaranteconyugue,
                    conciudadgaranteconyugue: $scope.conciudadgaranteconyugue,
                    condirecciondomiciliogaranteconyugue: $scope.condirecciondomiciliogaranteconyugue,
                    concaracteristicasdomiciliogaranteconyugue: $scope.concaracteristicasdomiciliogaranteconyugue,
                  
                    concasapropiaarrendadagaranteconyugue: $scope.concasapropiaarrendadagaranteconyugue,
                    conreferenciadomiciliogaranteconyugue: $scope.conreferenciadomiciliogaranteconyugue,
                    contelefonocasagaranteconyugue: $scope.contelefonocasagaranteconyugue,
                    concelulargaranteconyugue: $scope.concelulargaranteconyugue,
                    conlugartrabajogaranteconyugue: $scope.conlugartrabajogaranteconyugue,
                    concargotrabajogaranteconyugue: $scope.concargotrabajogaranteconyugue,
                    contiempolugartrabajogaranteconyugue: $scope.contiempolugartrabajogaranteconyugue,
                    condirecciontrabajogaranteconyugue: $scope.condirecciontrabajogaranteconyugue,
                    contelefonostrabajogaranteconyugue: $scope.contelefonostrabajogaranteconyugue,
                    concedulareferenciapersonal: $scope.concedulareferenciapersonal,
                    connombrescompletosreferenciapersonal: $scope.connombrescompletosreferenciapersonal,
                    condirecciondomicilioreferenciapersonal: $scope.condirecciondomicilioreferenciapersonal,
                    concaracteristicasdomicilioreferenciapersonal: $scope.concaracteristicasdomicilioreferenciapersonal,
                
                    concasapropiaarrendadareferenciapersonal: $scope.concasapropiaarrendadareferenciapersonal,
                    conreferenciadomicilioreferenciapersonal: $scope.conreferenciadomicilioreferenciapersonal,
                    contelefonocasareferenciapersonal: $scope.contelefonocasareferenciapersonal,
                    concelularreferenciapersonal: $scope.concelularreferenciapersonal,
                    conlugartrabajoreferenciapersonal: $scope.conlugartrabajoreferenciapersonal,
                    concargotrabajoreferenciapersonal: $scope.concargotrabajoreferenciapersonal,
                    contiempolugartrabajoreferenciapersonal: $scope.contiempolugartrabajoreferenciapersonal,
                    condirecciontrabajoreferenciapersonal: $scope.condirecciontrabajoreferenciapersonal,
                    contelefonostrabajoreferenciapersonal: $scope.contelefonostrabajoreferenciapersonal,
                    concedulareferenciaestudiantil: $scope.concedulareferenciaestudiantil,
                    connombrescompletosreferenciaestudiantil: $scope.connombrescompletosreferenciaestudiantil,
                    conparentescoreferenciaestudiantil: $scope.conparentescoreferenciaestudiantil,
                    coninstitucionreferenciaestudiantil: $scope.coninstitucionreferenciaestudiantil,
                    connivelreferenciaestudiantil: $scope.connivelreferenciaestudiantil,
                    conplazocredito: $scope.conplazocredito,
                    confechacontrato: $scope.formatedDate,
                    coninterescredito: $scope.coninterescredito,
                    coninteresmora: $scope.coninteresmora,
                    concuotainicial: $scope.concuotainicial,
                    conentradapendiente: $scope.conentradapendiente,
                    concostocuota: $scope.concostocuota,
                    conobservacion: $scope.conobservacion


                }


            })
            .then(function (response) {

                $scope.id_contrato = response.data;
                console.log(response.data);





                $scope.auxDate;
                $scope.flag = false;
                $scope.confechacontrato = document.getElementById('datepicker').value;
                $scope.vec1 = $scope.confechacontrato.split('/');
         
                var auxStr = $scope.vec1[1];
                $scope.vec1[1] = parseInt( auxStr.substring(1));
              //  console.log($scope.vec1[1]);
               // $scope.formatedDate = $scope.vec1[2] + '-' + $scope.vec1[1] + '-' + $scope.vec1[0];
                for (var i = 0; i < $scope.conplazocredito; i++) {

                  //  var 
                    
                    console.log($scope.vec1[1]);
                    switch ($scope.vec1[1])

                    {

                        case 1: $scope.vec1[1]+=1;
                            if ($scope.vec1[0]>30){
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 2: 
                          
                                $scope.vec1[1]+=1;
                               // $scope.vec1[1] = 29;
                                //  console.log($scope.totalDiasMes);
                                if ($scope.vec1[0] > 28) {
                                    $scope.auxDate = $scope.vec1[0];
                                    $scope.vec1[0] = 28;
                                    $scope.flag = true;
                                }
                           
                                 
                                //  console.log($scope.totalDiasMes);
                            
                            break;
                        case 3: $scope.vec1[1]=+1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 4: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 5: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 6: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 7: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 8: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 9: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 10: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 11: $scope.vec1[1]+=1;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;
                        case 12: $scope.vec1[1] = 1;
                                $scope.vec1[2]++;
                            if ($scope.vec1[0] > 30) {
                                $scope.vec1[0] = 30;
                            }
                            break;

                    }



                    $scope.formatedDate1 = $scope.vec1[2] + '-' + $scope.vec1[1] + '-' + $scope.vec1[0];
                    if ($scope.flag) {

                        $scope.vec[0] = $scope.auxDate;
                    }
                    console.log($scope.formatedDate1);
                    var url2 = myProvider.getCuotas() 
                        
                    console.log(url2);

                    $http({
                        method: 'POST',
                        url: url2,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: {
                            id_contrato:  $scope.id_contrato,
                            descripcion_pago:'cuota N' + (i + 1) ,
                            fecha_maxima: $scope.formatedDate1 ,
                            estado:1,
                            valor: $scope.costoCuota

                        }


                    })
                       .then(function (response) {
                       //    console.log(i+ 'numero de indicador');
                         /*  if (i + 1 == $scope.conplazocredito) {
                               $scope.inicio();
                           }*/
                          // console.log(url2);
                        }, function errorCallback(response) {
                           // console.log(url2);
                            //console.log(response.data);
                        })
                        .then(function(){
                           $scope.flag1=true;
                            //localStorage.removeItem('idCliente');
                          //  localStorage.removeItem('idFactura');
                          //  localStorage.removeItem('totalFactura');
                          //  window.location = '../facturas_clientes/index.php';
                             })
                        ;
                }
          


            }, function errorCallback(response) {

             //   console.log(response.data);

                });


    }

    fixedNumbers = function (cal) {

        var constant100 = 100;
        var resp = (Math.floor(cal * constant100) / constant100).toFixed(2);
     //   console.log(resp);
        return (resp);
    }


    $scope.finalizar=function(){

        localStorage.removeItem('idCliente');
          localStorage.removeItem('idFactura');
          localStorage.removeItem('totalFactura');
          window.location = '../facturas_clientes/index.php';

    }
}]);