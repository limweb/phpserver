<?php 
require_once __DIR__.'/../database.php';

class Service extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoservice';
    protected $primaryKey = 'serviceNo';
    
    public function children(){
        return $this->hasMany('Servicetool','toolString_serviceID','serviceID');
    }
}

class Assets extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoasset';
     // protected $primaryKey = 'admin_id';
 }  

class  Toolsensor extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_toolstring_sensor';
 // protected $primaryKey = 'admin_id';
    public function sensors() {
       return  $this->hasMany('Sensor','sensorID','ts_sensorID');
    }

 }  

 class  Servicetool extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_toolstring';
     // protected $primaryKey = 'admin_id';
    public function assets(){
        return $this->hasMany('Assets','','asset');
    }
 }  

class  Sensor extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infosensor';
     // protected $primaryKey = 'admin_id';
 }  

class  Asset extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoasset';
     // protected $primaryKey = 'admin_id';
 }  

class  Tool extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infotoollist';
     // protected $primaryKey = 'admin_id';
 }  

//
//$ts = new TreeService();
//$rs = $ts->getall();
//echo json_encode($rs);
//exit();

class TreeService {

            public function getall() {
                $rs = Toolsensor::all();
                foreach ($rs as $item) {
                    $item->sensors->toArray();
                }
                return $rs->toArray();
                // $services = Service::where('serviceID','=','SV1416981638347')->get();
                // foreach ($services as $service) {
                //     $service->children;
                // }
                // $services->children;
                // return $services;
            }

}

