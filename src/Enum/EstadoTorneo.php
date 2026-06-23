<?php

namespace App\Enum;

enum EstadoTorneo: string
{
    case INSCRIPCIONES = 'Inscripciones';
    case EN_CURSO = 'En curso';
    case FINALIZADO = 'Finalizado';
    case CANCELADO = 'Cancelado';
}
