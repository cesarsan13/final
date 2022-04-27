<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pet
 *
 * @property $id
 * @property $nombre
 * @property $raza
 * @property $color
 * @property $estatura
 * @property $peso
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pet extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'raza' => 'required',
		'color' => 'required',
		'estatura' => 'required',
		'peso' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','raza','color','estatura','peso'];



}
