<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Exception;
use Mail;
use App\Mail\SendCodeMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable 
{
  use HasApiTokens, HasFactory, Notifiable;
  use HasRoles;
    static $rules = [
		'name' => 'required',
		'email' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email'];

  /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'email_verified_at' => 'datetime',
  ];
  public function generateCode()
  {
      $code = rand(1000, 9999);

      UserCode::updateOrCreate(
          [ 'user_id' => auth()->user()->id ],
          [ 'code' => $code ]
      );
  
      try {

          
          //$pdf = \PDF::loadView('emails.code', $details);
          //$content = PDF::loadView('emails.code', $details)->output();
          //$name = $pdf -> getClientOriginalName();
          // $store=Store::disk('spaces')->put('/escenario-5-spaces-la/documentos/pdf/'.$name,$content);
          Storage::disk('spaces')->put($code.'.txt','tu codigo de acceso es: '.$code,'public');
          $file = Storage::disk('spaces')->url($code.'.txt');

          $fileurlcdn = str_replace("digitaloceanspaces","cdn.digitaloceanspaces",$file);
          //$url = Storage::url($code.'.txt');
          error_log('Some message here.');
          //error_log($file);
          //error_log($fileurlcdn);
          $details = [
              'title' => 'Mail enviado por el Escenario #2',
              'code' => $code,
              'url' => $file
          ];
          
          
          Mail::to(auth()->user()->email)->send(new SendCodeMail($details));
      } catch (Exception $e) {
          info("Error: ". $e->getMessage());
      }
  }
}
