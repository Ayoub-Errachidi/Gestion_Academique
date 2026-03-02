<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Etudiant extends Model
{
    use HasFactory;
    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'age',
    ];
}
