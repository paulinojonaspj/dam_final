<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'prioridade',
        'data_inicio',
        'data_fim',
        'hora_inicio',
        'hora_fim',
        'atividade_id',
        'estado',
        'user_id'
    ];
}
