<?php
include_once('conector/conector.php');
class Producto
{
    private $idProducto;
    private $nomProducto;
    private $stockProd;
    private $proPrecio;
    private $mensaje;
    private $detallesProd;
    private $imgProd;
    private $proDeshabilitado;

    public function __construct()
    {
        $this->idProducto = "";
        $this->nomProducto = "";
        $this->stockProd = "";
        $this->proPrecio = "";
        $this->mensaje = "";
        $this->detallesProd = "";
        $this->imgProd = "";
        $this->proDeshabilitado = 0;
    }

    //Metodos de acceso Get
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    public function getNomProducto()
    {
        return $this->nomProducto;
    }

    public function getStockProducto()
    {
        return $this->stockProd;
    }

    public function getProPrecio()
    {
        return $this->proPrecio;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function getDetallesProd()
    {
        return $this->detallesProd;
    }

    public function getImgProd()
    {
        return $this->imgProd;
    }

    public function getProDeshabilitado()
    {
        return $this->proDeshabilitado;
    }

    //Metodos de acceso Set

    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setNomProducto($nomProducto)
    {
        $this->nomProducto = $nomProducto;
    }

    public function setStockProducto($stockProd)
    {
        $this->stockProd = $stockProd;
    }

    public function setProPrecio($proPrecio)
    {
        $this->proPrecio = $proPrecio;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function setDetallesProd($detallesProd)
    {
        $this->detallesProd = $detallesProd;
    }

    public function setImgProd($imgProducto)
    {
        $this->imgProd = $imgProducto;
    }

    public function setProDeshabilitado($proDeshabilitado)
    {
        $this->proDeshabilitado = $proDeshabilitado;
    }

    public function __toString()
    {
        return "Producto [ID: " . $this->getIdProducto() .
            ", Nombre: " . $this->getNomProducto() .
            ", Stock: " . $this->getStockProducto() .
            ", Precio: " . $this->getProPrecio() .
            ", Detalles: " . $this->getDetallesProd() .
            ", Imagen: " . $this->getImgProd() .
            ", Deshabilitado: " . $this->getProDeshabilitado() . "]";
    }

    //Metodos

    //Cargar Producto

    public function cargar($idProducto, $nomProducto, $detallesProd, $stockProducto, $proPrecio, $imgProd, $proDeshabilitado)
    {
        $this->setIdProducto($idProducto);
        $this->setNomProducto($nomProducto);
        $this->setDetallesProd($detallesProd);
        $this->setStockProducto($stockProducto);
        $this->setProPrecio($proPrecio);
        $this->setImgProd($imgProd);
        $this->setProDeshabilitado($proDeshabilitado);
    }

    //Buscar un producto por id

    public function buscar($id)
    {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM producto WHERE idProducto=" . $id . ";";
        $respuesta = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $row = $base->Registro();
                if ($row) {
                    $respuesta = true;
                    $this->setIdProducto($row['idproducto']);
                    $this->setNomProducto($row['pronombre']);
                    $this->setDetallesProd($row['prodetalle']);
                    $this->setProPrecio($row['proprecio']);
                    $this->setStockProducto($row['procantstock']);
                    $this->setImgProd($row['proimagen']);
                    $this->setProDeshabilitado($row['prodeshabilitado']);
                }
            } else {
                $this->setMensaje("producto->buscar: " . $base->getError());
            }
        } else {
            $this->setMensaje("producto->buscar: " . $base->getError());
        }
        return $respuesta;
    }

    //Listar todos los productos

    public function listar($parametro = "")
    {
        $arregloProducto = array();
        $base = new BaseDatos();
        $consulta = "SELECT * FROM producto ";

        if ($parametro != "") {
            $consulta .= "WHERE " . $parametro;
        }

        $res = $base->Ejecutar($consulta);

        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $objProd = new Producto();

                    $objProd->setIdProducto($row['idproducto']);
                    $objProd->setNomProducto($row['pronombre']);
                    $objProd->setDetallesProd($row['prodetalle']);
                    $objProd->setProPrecio($row['proprecio']);
                    $objProd->setStockProducto($row['procantstock']);
                    $objProd->setImgProd($row['proimagen']);
                    $objProd->setProDeshabilitado($row['prodeshabilitado']);

                    array_push($arregloProducto, $objProd);
                }
            }
        } else {
            $this->setMensaje("producto->listar: " . $base->getError());
        }

        return $arregloProducto;
    }

    //Insertar un producto

    public function insertar()
{
    $agrega = false;
    $base = new BaseDatos();
    $deshabilitado = (int)$this->getProDeshabilitado(); 
    $consulta = "INSERT INTO producto (pronombre, prodetalle, procantstock, proimagen, proprecio, prodeshabilitado) VALUES";
    $consulta .= "('" . $this->getNomProducto() . "', ";
    $consulta .= "'" . $this->getDetallesProd() . "', ";
    $consulta .= $this->getStockProducto() . ", "; 
    $consulta .= "'" . $this->getImgProd() . "', ";
    $consulta .= $this->getProPrecio() . ", ";
    $consulta .= $deshabilitado . ");";
    
    if ($base->iniciar()) {
        if ($base->Ejecutar($consulta)) {
            $agrega = true; 
        } else {
            $this->setMensaje("producto->insertar: " . $base->getError());
        }
    } else {
        $this->setMensaje("producto->insertar: " . $base->getError());
    }
    return $agrega;
}


    //Modificar un producto 

    public function modificar()
    {
        $base = new BaseDatos();
        $modifica = false;
        $consulta = "UPDATE producto SET ";
        $consulta .= "pronombre='" . $this->getNomProducto() . "', prodetalle='" . $this->getDetallesProd() . "', procantstock=" . $this->getStockProducto() . ", proimagen='" . $this->getImgProd();
        $consulta .= "', proprecio=" . $this->getProPrecio() . ", prodeshabilitado=" . $this->getProDeshabilitado() . " WHERE idproducto=" . $this->getIdProducto() . ";";
        if ($base->iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $modifica = true;
            } else {
                $this->setMensaje("producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensaje("producto->modificar: " . $base->getError());
        }
        return $modifica;
    }

    //eliminar un producto

    public function eliminar()
    {
        $base = new BaseDatos();
        $elimina = false;
        $consulta = "UPDATE producto SET prodeshabilitado = 1 WHERE idproducto=" . $this->getIdProducto() . ";";

        if ($base->iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $elimina = true;
                $this->setProDeshabilitado(1);
            } else {
                $this->setMensaje("producto->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensaje("producto->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}

    }
}

