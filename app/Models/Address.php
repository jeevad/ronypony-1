<?php

namespace App\Models;

use App\Contracts\Repository\ConfigurationInterface;

class Address extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'first_name',
        'last_name',
        'office_name',
        'email',
        'locality',
        'address',
        'zip_code',
        'city',
        'state_id',
        'landmark',
        'country_id',
        'phone_number',
        'default'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = ['id', 'first_name', 'last_name', 'user_id', 'office_name', 'locality', 'address',
        'landmark', 'email', 'phone_number', 'city', 'state', 'zip_code', 'default', 'type'];

    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * The address belongs to an Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The address belongs to a state.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * The address belongs to an Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    /**
     * Set the user's first name.
     *
     * @param  string $firstName
     * @return void
     */
    public function setFirstNameAttribute($firstName)
    {
        $this->attributes['first_name'] = ucwords($firstName);
    }

    /**
     * Set the user's last name.
     *
     * @param  string $lastName
     * @return void
     */
    public function setLastNameAttribute($lastName)
    {
        $this->attributes['last_name'] = ucwords($lastName);
    }

    /**
     * Set the user's office name.
     *
     * @param  string $office
     * @return void
     */
    public function setOfficeNameAttribute($office)
    {
        $this->attributes['office_name'] = ucwords($office);
    }

    /**
     * Set the user's locality.
     *
     * @param  string $locality
     * @return void
     */
    public function setLocalityAttribute($locality)
    {
        $this->attributes['locality'] = ucfirst($locality);
    }

    /**
     * Set the user's address.
     *
     * @param  string $address
     * @return void
     */
    public function setAddressAttribute($address)
    {
        $this->attributes['address'] = strip_tags($address);
    }

    /**
     * Set the user's landmark.
     *
     * @param  string $landmark
     * @return void
     */
    public function setLandmarkAttribute($landmark)
    {
        $this->attributes['landmark'] = ucfirst($landmark);
    }

    public function getEmailAttribute($email)
    {
        return $email ?? $this->user->email;
    }

    public function getPhoneNumberAttribute($phoneNumber)
    {
        return $phoneNumber ?? $this->user->mobile_number;
    }

    /**
     * To Check If Country Id is Null then it Returns Default Country ID from Configuration
     *
     * @return int|null $countryId
     */
    public function getCountryIdAttribute()
    {
        if (isset($this->attributes['country_id']) && $this->attributes['country_id'] > 0) {
            return $this->attributes['country_id'];
        }

        $configRepository = app(ConfigurationInterface::class);
        $defaultCountry = $configRepository->getValueByKey('user_default_country');

        if (isset($defaultCountry)) {
            return $defaultCountry;
        }

        return null;
    }
}
