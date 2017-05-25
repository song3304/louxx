<?php
namespace App;

use App\Model;
use App\Properter;

class ProperterApply extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
	protected $appends = ['full_address'];
	
	public function full_address($format = '%P%C%D %A')
	{
	    $data = [
	        '%P' => $this->province_name->area_name,
	        '%C' => $this->city_name->area_name,
	        '%D' => $this->area_name->area_name,
	        '%A' => $this->address,
	    ];
	    return strtr($format, $data);
	}
	
	public function getFullAddressAttribute()
	{
	    return $this->full_address();
	}
	
	
	public function user(){
	    return $this->hasOne('App\\User','id','uid');
	}
	
	//省
	public function province_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'province');
	}
	//市
	public function city_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'city');
	}
	//区
	public function area_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'area');
	}
	
	public function status_tag()
	{
	    $status_tag = '';
	    switch ($this->status){
	        case 0:$status_tag='未审核';break;
	        case 1:$status_tag='审核通过'; break;
	        case 2:$status_tag='审核不过'; break;
	        default: $status_tag='未知';
	    }
	    return $status_tag;
	}
}

ProperterApply::updated(function($properterApply){
   if ($properterApply->isDirty('status')){
       if($properterApply->status == 1 && !empty($properterApply->uid)){
           $properter = Properter::firstOrCreate(['id'=>$properterApply->uid]);
           $properter->update(['name'=>$properterApply->name,'province'=>$properterApply->province,'city'=>$properterApply->city,
                               'area'=>$properterApply->area,'address'=>$properterApply->address,'phone'=>$properterApply->phone]);
           
           if(!$properterApply->user->hasRole('properter')) $properterApply->user->attachRole(Role::findByName('properter'));
       }
   }
});
