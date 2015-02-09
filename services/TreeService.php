<?php 
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

class Service extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoservice';
    protected $primaryKey = 'serviceNo';
}

class  Tool extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infotoollist';
    protected $primaryKey = 'toolNo';

      public function children() {
        return $this->hasMany('Asset_tool','asset_toolID','toolID')->where('asset_active','=','1');
    }
 }
 
class  Tool_sensor extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infotoollist';
    protected $primaryKey = 'toolNo';

      public function children() {
        return $this->hasMany('Sensor_tool','toolID','toolID');
    }
 }

class  Sensor_tool extends Illuminate\Database\Eloquent\Model {
     protected $table = 'field_infosensor';
     protected $primaryKey = 'sensorNo';
     
 }
 

class  Asset_tool extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoasset';
    protected $primaryKey = 'assetNo';
        
    public function children() {
        return $this->hasMany('Asset_sensor','ts_assetID','assetID');
    }
    public function tool() {
        return $this->hasOne('Tool','toolID','asset_toolID');
    }
   
 }
 
class  Asset_tool_list extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoasset';
    protected $primaryKey = 'assetNo';
        
    public function children() {
        return $this->hasMany('Tool','toolID','asset_toolID');
    }
    
 }

class  Asset_sensor extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoasset_sensor';
    protected $primaryKey = 'tsNo';
    
    public function sensorinfo(){
      return $this->hasOne('Sensor_tool','sensorID','ts_sensorID');
    }
     
 }

 class  Service_asset extends Illuminate\Database\Eloquent\Model {
    protected $table = 'field_infoservice_toolstring';
    protected $primaryKey = 'toolstringNo';
 }  
    

class  Service_assets extends Illuminate\Database\Eloquent\Model {
     protected $table = 'field_infoservice_asset';
     protected $primaryKey = 'toolStringNo';
}  


class  Asset_default extends Illuminate\Database\Eloquent\Model {
     protected $table = 'field_infoservicelist_assetdefault';
     protected $primaryKey = 'adefaultNo';
}     


//class TreeService {
//
//            public function getAssetsSensors() {
//               $assets = Asset_tool::all();
//                
//               foreach ($assets as $asset) {
//                
//                 $asset->children->toArray();
//                 $asset->tool->toArray();
//                 
//               }
//               return  $assets->toArray();
//            }
//}

//class TreeService {
//
//            public function getAssetsSensors() {
//               $assets = Asset_tool::all();
//               foreach ($assets as $asset) {
//                    $asset->tool->toArray();
//                    $ss = $asset->children;
//                    foreach ($ss as $s) {
//                      $s->sensorinfo->toArray();
//                    }
//               }
//               return  $assets->toArray();
//            }
//
//}

class TreeService {

            public function getAssetsSensors() {
               $assettool =   Asset_tool::leftJoin('field_infotoollist', 'toolID', '=', 'asset_toolID')->leftJoin('field_infoservice_asset','toolstring_assetID','=','assetID')->get()->each( function($asset){              
                      $asset->children  = Asset_sensor::leftJoin('field_infosensor','sensorID','=','ts_sensorID')->where('ts_assetID','=',$asset->assetID)->get()->toArray();
                  });     
                  return $assettool->toArray();
            }
            
            public function getAssetsSensorsByserviceID($serviceID) {
               $assettool =   Asset_tool::leftJoin('field_infotoollist', 'toolID', '=', 'asset_toolID')->leftJoin('field_infoservice_asset','toolstring_assetID','=','assetID')->where('toolstring_serviceID','=', $serviceID)->orderBy('toolstring_1','asc')->get()->each( function($asset){              
                      $asset->children  = Asset_sensor::leftJoin('field_infosensor','sensorID','=','ts_sensorID')->where('ts_assetID','=',$asset->assetID)->get()->toArray();
                  });     
                  return $assettool->toArray();
            }
            
            /** Asset */
             public function getAssetTool_SerialNo() {
                $tool = Tool::orderBy('tool_name','asc')->get();
               foreach ($tool as $asset) {
                    $asset->children->toArray();
               }
               return  $tool->toArray();
            }
            
             public function getAssetTool_Default($slistID) {
                $tool = Tool::leftJoin('field_infoservicelist_assetdefault','adefault_toolID', '=', 'toolID')->where('adefault_slistID','=', $slistID)->orderBy('tool_name','asc')->get();
               foreach ($tool as $asset) {
                    $asset->children->toArray();
               }
               return  $tool->toArray();
            }
            
            /** tool */
             public function getTool_Sensor() {
                $tool = Tool_sensor::where('tool_active','=','1')->orderBy('tool_name','asc')->get();
               foreach ($tool as $asset) {
                    $asset->children->toArray();
               }
               return  $tool->toArray();
            }

}


// $ts = new TreeService();
// $rs = $ts->getAssetsSensors();
// echo json_encode($rs);
//
//$rs = $ts->getAssetsbyServiceID('SV1416981638347');
//echo $rs;
