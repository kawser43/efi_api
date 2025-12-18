<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'record_id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'whatsapp_phone_number',
        'date_of_birth',
        'gender',
        'become_investor_at',
        'close_date',
        'days_to_close',
        'is_unworked',
        'kyc_status',
        'kyc_staus_em',
        'kyc_staus_ex',
        'entity',
        'investor_type',
        'membership_type',
        'currency',
        'contact_owner',
        'email_preference',

        'ethis_eg',
        'ethis_global',
        'ethis_my_investor',
        'ethis_ae',
        'ethis_id',
        'ethis_my',
        'ethis_x',
        'gs',
        'last_engaged_at',
        'last_activity',
        'last_modified_at',
        'updated_by',
        'create_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function userBilling(): HasOne
    {
        return $this->hasOne(UserBilling::class);
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function userCompany(): HasOne
    {
        return $this->hasOne(UserCompany::class);
    }

    public function userFinancial(): HasOne
    {
        return $this->hasOne(UserFinancial::class);
    }

    public function userMeta(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }
}
