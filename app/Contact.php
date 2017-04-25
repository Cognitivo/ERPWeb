<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $primaryKey = 'id_contact';

    protected $table = 'contacts';

    protected $fillable = ['alias', 'name', 'gov_code', 'code', 'telephone', 'email', 'address', 'gender', 'id_contact_role', 'date_birth', 'comment'];

    public $timestamps = false;

    public function ContactRole()
    {
        return $this->belongsTo('App\ContactRole', 'id_contact_role');
    }

    //get addrees contact
    public static function addressContact($contact_id){
        $object_contact = new static;
        //if contact is principal return adreess else return adress parent
         $contact = $object_contact->find($contact_id);

        if($contact){
            $is_principal = $contact->ContactRole->is_principal;
            if($is_principal && $contact->parent_id_contact == null){
                return $contact->address;
            }else{
                $parent = $contact->parentContact;
                if($parent){
                    return $parent->address;
                }
                return null;
            }
        }

        return null;
    }

    public function scopelast_contact($query)
    {
        $result = \DB::select('SELECT max(cast(code as unsigned)) as code FROM contacts');
        return $result;
    }

    public function field_value()
    {
        return $this->hasMany('App\ContactField', 'id_contact_field');
    }

    public function scopeget_contact_subscription($query, $value)
    {
        return $query->where(function ($query) {
            $query->where('id_contact', \Session::get('idcontact'))->orWhere('parent_id_contact', \Session::get('idcontact'));
        })->where('name', 'LIKE', "%$value%");
    }

    public function scopeAllContacts($query, $name)
    {

        if (trim($name) != "") {
            return $query->leftJoin('contacts as cont','contacts.parent_id_contact','=','cont.id_contact')->where('contacts.name', 'LIKE', "%$name%")->join('contact_role','contacts.id_contact_role','=','contact_role.id_contact_role')
            ->select('cont.name as parent_name','contacts.name','contacts.id_contact','contacts.geo_lat','contacts.geo_long','contacts.address','cont.address as address_parent','contacts.parent_id_contact','contact_role.is_principal','contacts.geo_longlat');
        }
        return null;
    }


    /**
     * Contact belongs to ParentContact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentContact()
    {
        // belongsTo(RelatedModel, foreignKey = parentContact_id, keyOnRelatedModel = id)
        return $this->belongsTo(Contact::class,'parent_id_contact');
    }

    /**
     * Contact has many Projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = contact_id, localKey = id)
        return $this->hasMany(Project::class,'id_contact');
    }
}
