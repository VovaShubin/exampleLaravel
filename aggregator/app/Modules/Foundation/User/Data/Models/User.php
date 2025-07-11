<?php

namespace App\Modules\Foundation\User\Data\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticate;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * @property int id
 * @property string email
 * @property string password
 * @property string first_nam
 * @property string middle_na
 * @property string last_name
 * @property DateTime birthdate
 * @property string phone
 */
class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'phone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Find the user instance for the given username.
     */
    public function findForPassport(string $username): User
    {
        $user = $this->where('email', $username)->first();

        if (is_null($user?->email_verified_at)) {
            throw new OAuthServerException('User account is not activated', 6, 'account_inactive', 401);
        }

        return $user;
    }
}
