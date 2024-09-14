<?php

namespace App\Http\Controllers;

use App\Common\Bitacora;

abstract class Controller
{
    protected function RegistrarOperacion(string $ipEstacion, string $operacion): void {
        Bitacora::AgregarRegistro('informacion', $ipEstacion . ' solicita iniciar ' . $operacion, -9999999, self::class . '.php', __LINE__);
    }

    protected function RegistrarRespuesta(string $ipEstacion, array $paquete): void {
        $jsonPaquete = json_encode($paquete);
        Bitacora::AgregarRegistro('informacion', 'Resolucion a solicitud realizada por ' . $ipEstacion . ' : ' . $jsonPaquete, -9999999, self::class . '.php', __LINE__);
    }
}
