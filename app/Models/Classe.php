<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'niveau'];

    // Relation: Une classe contient plusieurs étudiants
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}