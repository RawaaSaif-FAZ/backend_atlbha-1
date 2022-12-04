<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
     protected $fillable = ['store_name','store_email','domain','icon','description','business_license','phonenumber','ID_file','accept_status',
     'snapchat','facebook','twiter','youtube','instegram','logo','entity_type','user_id','activity_id','package_id','country_id','city_id','category_id','status','is_deleted'];
     public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
          public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');

    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
     public function packages()
    {
          return $this->belongsToMany(
          Store::class,
          'packages_stores',
          'store_id',
          'package_id'

     );
    }
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function page()
    {
        return $this->hasMany(Page::class);
    }
      public function shippingtypes()
    {
     return $this->belongsToMany(
        Shippingtype::class,
        'shippingtypes_stores',
        'store_id',
        'shippingtype_id'


        );
    }
    public function paymenttypes()
    {
     return $this->belongsToMany(
        Paymenttype::class,
        'paymenttypes_stores',
        'store_id',
        'paymenttype_id'


        );
    }

       public function setLogoAttribute($logo)
    {
        if (!is_null($logo)) {
            if (gettype($logo) != 'string') {
                $i = $logo->store('images/storelogo', 'public');
                $this->attributes['logo'] = $logo->hashName();
            } else {
                $this->attributes['logo'] = $logo;
            }
        }
    }

    public function getLogoAttribute($logo)
    {
        if (is_null($logo)) {
            return   asset('assets/media/man.png');
        }
        return asset('storage/images/storelogo') . '/' . $logo;
    }


       public function setIconAttribute($icon)
    {
        if (!is_null($icon)) {
            if (gettype($icon) != 'string') {
                $i = $icon->store('images/storeicon', 'public');
                $this->attributes['icon'] = $icon->hashName();
            } else {
                $this->attributes['icon'] = $icon;
            }
        }
    }

    public function getIconAttribute($icon)
    {
        if (is_null($icon)) {
            return   asset('assets/media/man.png');
        }
        return asset('storage/images/storeicon') . '/' . $icon;
    }


       public function setID_fileAttribute($ID_file)
    {
        if (!is_null($ID_file)) {
            if (gettype($ID_file) != 'string') {
                $i = $ID_file->store('ID_files/store', 'public');
                $this->attributes['ID_file'] = $ID_file->hashName();
            } else {
                $this->attributes['ID_file'] = $ID_file;
            }
        }
    }

    public function getID_fileAttribute($ID_file)
    {
        if (is_null($ID_file)) {
            return   asset('assets/media/man.png');
        }
        return asset('storage/ID_files/store') . '/' . $ID_file;
    }


       public function setBusiness_licenseAttribute($business_license)
    {
        if (!is_null($business_license)) {
            if (gettype($business_license) != 'string') {
                $i = $business_license->store('images/storebusiness_license', 'public');
                $this->attributes['business_license'] = $business_license->hashName();
            } else {
                $this->attributes['business_license'] = $business_license;
            }
        }
    }

    public function getBusiness_licenseAttribute($business_license)
    {
        if (is_null($business_license)) {
            return   asset('assets/media/man.png');
        }
        return asset('storage/images/storebusiness_license') . '/' . $business_license;
    }

}
