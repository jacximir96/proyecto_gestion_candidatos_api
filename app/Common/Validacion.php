<?php

declare(strict_types = 1);

namespace App\Common;

use Illuminate\Support\Collection;

final class Validacion {
    public static function ValidarDatoTipoCadena( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_string( $dato ) ) $error = true;
        if ( !$error AND trim( $dato ) == '' ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoCadenaNumerica( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_string( $dato ) ) $error = true;
        if ( !$error AND trim( $dato ) == '' ) $error = true;
        if ( !$error AND !is_numeric( $dato ) ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoEntero( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_int( $dato ) ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoDecimal( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_float( $dato ) ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoBooleano( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_bool( $dato ) ) $error = true;
        return $error;
    }
    
    public static function ValidarDatoTipoArray( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_array( $dato ) ) $error = true;
        if ( !$error AND count( $dato ) == 0 ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoJSON( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_string( $dato ) ) $error = true;
        if ( !$error AND trim( $dato ) == '' ) $error = true;
        if ( !$error AND !json_validate( $dato, 2147483647 ) ) $error = true;
        return $error;
    }
    
    public static function ValidarDatoTipoIP( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_string( $dato ) ) $error = true;
        if ( !$error AND trim( $dato ) == '' ) $error = true;
        if ( !$error AND filter_var($dato, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false ) $error = true;
        return $error;
    }

    public static function ValidarDatoInstanciaCollection( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_object( $dato ) ) $error = true;
        if ( !$error AND !( $dato instanceof Collection ) ) $error = true;
        if ( !$error AND count( $dato ) == 0 ) $error = true;
        return $error;
    }

    public static function ValidarDatoTipoObjeto( mixed $dato ): bool {
        $error = false;
        if ( !isset( $dato ) OR !is_object( $dato ) ) $error = true;
        return $error;
    }
}