<?php

namespace App\Models;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Etudiant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'age',
        'classe_id'
    ];

    // Chaque étudiant appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
