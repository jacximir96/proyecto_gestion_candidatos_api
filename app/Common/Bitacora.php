<?php

declare(strict_types = 1);

namespace App\Common;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;
use Illuminate\Support\Facades\Log;
use App\Common\Validacion;

final class Bitacora {
    public function __invoke( Logger $Logger ) : void {
        $IPCliente = !Validacion::ValidarDatoTipoIP( $_SERVER['REMOTE_ADDR'] ) ? 'Cliente: ' . trim( $_SERVER['REMOTE_ADDR'] ) . ' - ' : '';       
        $LineFormatter = new LineFormatter("[%datetime%] %channel%.%level_name% => $IPCliente%message%\n", "d-m-Y H:i:s");

        foreach( $Logger->getHandlers() as $StreamHandler ) $StreamHandler->setFormatter( $LineFormatter );
    }

    public static function AgregarRegistro( string $nivel, ?string $mensaje = '', ?int $codigo = -9999999, ?string $fichero = '', ?int $linea = -9999999 ) : void {
        $parametros = array(
            'mensaje' => $mensaje,
            'codigo' => $codigo,
            'fichero' => $fichero,
            'linea' => $linea
        );
        $reporte = '';

        foreach ($parametros as $clave => $valor)
            if ( isset($valor) )
                if ( is_string($valor) ) {
                    if ( $valor != '' ) $reporte .= strtoupper($clave) . ': ' . $valor . ' - ';
                } else {
                    if ( $valor != -9999999 ) $reporte .= strtoupper($clave) . ': ' . $valor . ' - ';
                }

        if ( $reporte != '' ) {
            $reporte = substr($reporte, 0, -3);

            switch ($nivel) {
                case 'depurar':
                    Log::debug($reporte);
                    break;
                case 'informacion':
                    Log::info($reporte);
                    break;
                case 'aviso':
                    Log::notice($reporte);
                    break;
                case 'advertencia':
                    Log::warning($reporte);
                    break;
                case 'error':
                    Log::error($reporte);
                    break;
                case 'critico':
                    Log::critical($reporte);
                    break;
                case 'alerta':
                    Log::alert($reporte);
                    break;
                case 'emergencia':
                    Log::emergency($reporte);
                    break;
                default:
                    ;
            }
        }
    } 
}
