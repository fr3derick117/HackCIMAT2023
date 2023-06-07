<?php

    //Establecer la conexión con la base de datos
    //$conexion = 1;
    $conexion=mysqli_connect('localhost','root','','hackcimat');

    //Verificar que se pudo conectar a la base de datos
    if(!$conexion){
        die("Error al conectarse a la base de datos: ".mysqli_connect_error());
    }

    $Respuesta = array();
    $accion = $_POST['accion'];
    

    switch ($accion) {
        case 'update':
            actionUpdatePHP($conexion);
            break;

        case 'read':
            actionReadPHP($conexion);
        
        default:
            # code...
            break;
    }
    

    function actionReadPHP($conexion){
        $QueryRead = "SELECT * FROM cultivo WHERE id_cultivo=1;";
        $ResultadoRead = mysqli_query($conexion, $QueryRead);
        $numeroRegistros = mysqli_num_rows($ResultadoRead);
        if ($numeroRegistros > 0 ) {
            $Respuesta['estado']=1;
            $Respuesta['mensaje']="Los registros se listan correctamente";
            $Respuesta['Cultivo']=array();
            while ($RenglonEntrega = mysqli_fetch_assoc($ResultadoRead)) {
                $Cultivo = array();
                $Cultivo['id_cultivo'] = $RenglonEntrega['id_cultivo'];
                $Cultivo['tipo_cultivo'] = $RenglonEntrega['tipo_cultivo'];
                $Cultivo['tipo_huerto'] = $RenglonEntrega['tipo_huerto'];
                $Cultivo['tipo_suelo'] = $RenglonEntrega['tipo_suelo'];
                $Cultivo['etapa'] = $RenglonEntrega['etapa'];
                $Cultivo['ph'] = $RenglonEntrega['ph'];
                $Cultivo['nitrogeno'] = $RenglonEntrega['nitrogeno'];
                $Cultivo['potasio'] = $RenglonEntrega['potasio'];
                $Cultivo['fosforo'] = $RenglonEntrega['fosforo'];
                $Cultivo['fertilizante'] = $RenglonEntrega['fertilizante'];
                $Cultivo['temperatura'] = $RenglonEntrega['temperatura'];
                $Cultivo['humedad'] = $RenglonEntrega['humedad'];
                array_push($Respuesta['Cultivo'], $Cultivo);
            }
        }else {
            $Respuesta['estado']=0;
            $Respuesta['mensaje']="Lo siento, no hay registros";
        }
        //echo json_encode($Respuesta);
    }


    function actionUpdatePHP($conexion){
        $id_cultivo = $_POST['id_cultivo'];
        $tipo_cultivo = $_POST['tipo_cultivo'];
        $tipo_huerto = $_POST['tipo_huerto'];
        $tipo_suelo = $_POST['tipo_suelo'];
        $etapa = $_POST['etapa'];
        $ph = $_POST['ph'];
        $nitrogeno = $_POST['nitrogeno'];
        $potasio = $_POST['potasio'];
        $fosforo = $_POST['fosforo'];
        $fertilizante = $_POST['fertilizante'];
        $temperatura = $_POST['temperatura'];
        $humedad = $_POST['humedad'];

        $QueryUpdate = "UPDATE cultivo 
        SET tipo_cultivo ='".$tipo_cultivo."', 'tipo_huerto' = '".$tipo_huerto."', tipo_suelo ='".$tipo_suelo."', 'etapa' = '".$etapa."', 
        ph ='".$ph."', 'nitrogeno' = '".$nitrogeno."', potasio ='".$potasio."', 'fosforo' = '".$fosforo."', fertilizante ='".$fertilizante."', 
        'temperatura' = '".$temperatura."', humedad ='".$humedad."' WHERE id_cultivo=".$id_cultivo ;
        mysqli_query($conexion, $QueryUpdate);
        if (mysqli_affected_rows($conexion)>=1) {
            $Respuesta['estado']=1; 
            $Respuesta['mensaje']="El registro se actualizo correctamente";
            $Respuesta['tipo_cultivo'] = $tipo_cultivo;
            $Respuesta['tipo_huerto'] = $tipo_huerto;
            $Respuesta['tipo_suelo'] = $tipo_suelo;
            $Respuesta['etapa'] = $etapa;
            $Respuesta['ph'] = $ph;
            $Respuesta['nitrogeno'] = $nitrogeno;
            $Respuesta['potasio'] = $potasio;
            $Respuesta['fosforo'] = $fosforo;
            $Respuesta['fertilizante'] = $fertilizante;
            $Respuesta['temperatura'] = $temperatura;
            $Respuesta['humedad'] = $humedad;
        }else {
            $Respuesta['estado']=0; 
            $Respuesta['mensaje']="No se pudo actualizar en la base de datos";
        }

        //echo json_encode($Respuesta);
        mysqli_close($conexion);
    }

?>
