<?php

namespace Modelos;
// require_once "conexion.php";
use Conect\Conexion;
use PDO;

class ModeloClientes
{

    // MOSTRAR CLIENTES
    public static function mdlMostrarClientes($tabla, $item, $valor)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }


        $stmt->close();
        $stmt = null;
    }
    // OBJETO MODELO CREAR CLIENTE
    public static function mdlCrearCliente($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, documento, ruc, razon_social, email, telefono,  direccion, ubigeo, fecha_nacimiento) VALUES (:nombre, :documento, :ruc, :razon_social, :email, :telefono, :direccion, :ubigeo, :fecha_nacimiento)");

        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":documento", $datos['documento'], PDO::PARAM_STR);
        $stmt->bindParam(":ruc", $datos['ruc'], PDO::PARAM_STR);
        $stmt->bindParam(":razon_social", $datos['razon_social'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(":ubigeo", $datos['ubigeo'], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos['fecha_nacimiento'], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt->close();
        $stmt = null;
    }
    // EDITAR CLIENTE
    public static function mdlEditarCliente($tabla, $datos)
    {

        $stmt = Conexion::conectar();
        $stmt = $stmt->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, ruc = :ruc, razon_social = :razon_social, email = :email, telefono = :telefono, direccion = :direccion, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");

        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":documento", $datos['documento'], PDO::PARAM_STR);
        $stmt->bindParam(":ruc", $datos['ruc'], PDO::PARAM_STR);
        $stmt->bindParam(":razon_social", $datos['razon_social'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_nacimiento", $datos['fecha_nacimiento'], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    // ELIMINAR CLIENTE
    public static function mdlEliminarCliente($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }
    // LISTAR CLIENTES OTRO MÉTODO
    public static function mdlListarClientes()
    {

        $content =  "<tbody class='body-clientes'></tbody>";
        return $content;
    }



    //BUSCAR RUC SUNAT
    public static function mdlBuscarRuc($numDoc, $tipoDoc)
    {
        $numDoc = $numDoc;

        $token =  'a47dd6bb0ba97629fa8d725cc6b423cd3fb6c8531597f586d03761a396fa21ac';

        if ($tipoDoc == 6) {
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apiperu.dev/api/ruc/".$numDoc."?api_token=".$token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $empresa = json_decode($response, TRUE);

            if (!empty($empresa['success'])) {
                $datos = array(
                    'ruc' => $empresa['data']['ruc'],
                    'razon_social' => $empresa['data']['nombre_o_razon_social'],
                    'estado' => $empresa['data']['estado'],
                    'condicion' => $empresa['data']['condicion'],
                    'direccion' => $empresa['data']['direccion'],
                    'ubigeo' => $empresa['data']['ubigeo_sunat'],
                    'departamento' => $empresa['data']['departamento'],
                    'provincia' => $empresa['data']['provincia'],
                    'distrito' => $empresa['data']['distrito'],
                    'token' => $token
                );

                echo json_encode($datos);
            } else {
                echo json_encode('error');
            }
        }


        if ($tipoDoc == 1) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apiperu.dev/api/dni/".$numDoc."?api_token=".$token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false

            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $empresa = json_decode($response, TRUE);

            if (!empty($empresa['success'])) {
                $datos = array(
                    'ruc' => $empresa['data']['numero'],
                    'razon_social' => $empresa['data']['nombre_completo'],
                    'nombres' => $empresa['data']['nombres'],
                    'apellidos' => $empresa['data']['apellido_paterno']." ".$empresa['data']['apellido_materno']

                );

                echo json_encode($datos);
            } else {
                echo json_encode('error');
            }
        }
    }

    // BUSCAR CLIENTE EN LA EMISIÓN DE COMPROBANTES
    public static function mdlBuscarCliente($tabla, $valor)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE (nombre LIKE :valor OR documento LIKE :valor) OR (razon_social LIKE :valor OR ruc LIKE :valor) LIMIT 50");
        $parametros = array(':valor' => '%' . $valor . '%');

        $stmt->execute($parametros);
        return $stmt->fetchall();
    }
}
