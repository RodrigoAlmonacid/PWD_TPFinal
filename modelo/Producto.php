<?php
include_once('conector/conector.php');
class Producto
{
    private $idProducto;
    private $nomProducto;
    private $stockProd;
    private $mensaje;
    private $detallesProd;
    private $imgProd;

    public function __construct()
    {
        $this->idProducto = "";
        $this->nomProducto = "";
        $this->stockProd = "";
        $this->mensaje = "";
        $this->detallesProd = "";
        $this->imgProd = "";
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

    public function __toString()
    {
        return "Producto [ID: " . $this->getIdProducto() .
           ", Nombre: " . $this->getNomProducto() .
           ", Stock: " . $this->getStockProducto() .
           ", Detalles: " . $this->getDetallesProd() .
           ", Imagen: " . $this->getImgProd() . "]";
    }

    //Metodos

    //Cargar Producto

    public function cargar($idProducto, $nomProducto, $detallesProd, $stockProducto, $imgProd)
    {
        $this->setIdProducto($idProducto);
        $this->setNomProducto($nomProducto);
        $this->setDetallesProd($detallesProd);
        $this->setStockProducto($stockProducto);
        $this->setImgProd($imgProd);
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
                    $this->setStockProducto($row['procantstock']);
                    $this->setImgProd($row['proimagen']);
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

    public function listar()
    {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM producto;";
        $arregloProducto = [];
        if ($base->iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $row = $base->Registro();
                if ($row) {
                    do {
                        $objProd = new Producto();
                        $objProd->setIdProducto($row['idproducto']);
                        $objProd->setNomProducto($row['pronombre']);
                        $objProd->setDetallesProd($row['prodetalle']);
                        $objProd->setStockProducto($row['procantstock']);
                        $objProd->setImgProd(['proimagen']);
                        array_push($arregloProducto, $objProd);
                    } while ($row = $base->Registro());
                }
            } else {
                $this->setMensaje("producto->listar: " . $base->getError());
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
        $consulta = "INSERT INTO producto (pronombre, prodetalle, procantstock, proimagen) VALUES";
        $consulta .= "('" . $this->getNomProducto() . "', '" . $this->getDetallesProd() . "', '" . $this->getStockProducto() . "', '" . $this->getImgProd() . "');";
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
        $consulta .= "pronombre='" . $this->getNomProducto() . "', prodetalle='" . $this->getDetallesProd() . "', procantstock='" . $this->getStockProducto() . "', proimagen='" . $this->getImgProd();
        $consulta .= "' WHERE idproducto=" . $this->getIdProducto() . ";";
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

    public function eliminar(){
        $base=new BaseDatos();
        $elimina=false;
        $consulta="DELETE FROM producto WHERE idproducto=".$this->getIdProducto().";";
        if($base->iniciar()){
            if($base->Ejecutar($consulta)){
                $elimina=true;
            }
            else {
                $this->setMensaje("producto->eliminar: " . $base->getError());
            } 	
        }
        else {
            $this->setMensaje("producto->eliminar: " . $base->getError());
        }
        return $elimina;
    }
}
