<?php
require_once __DIR__ . '/../../config/database.php';

class VentaController {
    public function obtenerHistorial($idCliente) {
        global $conn; // Conexión a la base de datos.

        $sql = "
            SELECT 
                v.idventa,
                v.tipo_comprobante,
                v.serie_comprobante,
                v.num_comprobante,
                v.fecha_hora,
                v.impuesto,
                v.total,
                v.estado,
                dv.idarticulo,
                dv.cantidad,
                dv.precio,
                dv.descuento,
                a.nombre AS nombre_articulo
            FROM venta v
            JOIN detalle_venta dv ON v.idventa = dv.idventa
            JOIN articulo a ON dv.idarticulo = a.idarticulo
            WHERE v.idcliente = ?
            ORDER BY v.fecha_hora DESC;
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $idCliente);
        $stmt->execute();
        $result = $stmt->get_result();

        $ventas = [];
        while ($row = $result->fetch_assoc()) {
            $idVenta = $row['idventa'];
            if (!isset($ventas[$idVenta])) {
                $ventas[$idVenta] = [
                    'idventa' => $row['idventa'],
                    'tipo_comprobante' => $row['tipo_comprobante'],
                    'serie_comprobante' => $row['serie_comprobante'],
                    'num_comprobante' => $row['num_comprobante'],
                    'fecha_hora' => $row['fecha_hora'],
                    'impuesto' => $row['impuesto'],
                    'total' => $row['total'],
                    'estado' => $row['estado'],
                    'articulos' => [],
                ];
            }

            $ventas[$idVenta]['articulos'][] = [
                'idarticulo' => $row['idarticulo'],
                'nombre' => $row['nombre_articulo'],
                'cantidad' => $row['cantidad'],
                'precio' => $row['precio'],
                'descuento' => $row['descuento'],
            ];
        }

        $stmt->close();
        return $ventas;
    }
}
