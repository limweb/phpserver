<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;


class Realtimehidl extends Illuminate\Database\Eloquent\Model {
        protected $table = 'field_realtime_hidl';
        public $timestamps = false;
        protected $primaryKey = 'alarmNo';
}

// //===== test -------
// $sv = new RealtimehidlsService();
// // $rs = $sv->getAll();
// $rs = $sv->getbyid(1);
// var_dump($rs);
// exit();

class RealtimehidlsService  {

	/**
	 * Display a listing of realtimehidls
	 *
	 * @return Response
	 */
	public function getAll()
	{
		$realtimehidls = Realtimehidl::all();
		return $realtimehidls->toArray();
	}



	public function insert($item)
	{
		$realtimehidl = Realtimehidl::create($item);
		return $realtimehidl;

	}

	public function getbyid($id)
	{
		$realtimehidl = Realtimehidl::find($id);
		if($realtimehidl){
		         return $realtimehidl->toArray();
		}  else {
		         return -1;
		}

	}


	/**
	 * Update the specified realtimehidl in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($item)
	{

		$realtimehidl = Realtimehidl::find($item->id);
		if($realtimehidl){
			// $realtimehidl->update(Request::get());
			$realtimehidl->update(Input::get());
			return  $realtimehidl;		
		} else {
			return -1;
		}
	}

	/**
	 * Remove the specified realtimehidl from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$rq = json_encode(Input::get());
		consolelog('id='.$id);
		consolelog('obj='.$rq);
		$realtimehidl =  Realtimehidl::find($id);
		if(realtimehidl){
			$realtimehidl =  Realtimehidl::destroy($id);
			return  $realtimehidl;  // 1 sucess
		} else {
			return -1;
		}
	}



    /**
    * Display a listing of the resource.
    * GET /api/realtimehidlsearch
    * @POST("/api/realtimehidltssearch")
    * @return stdClass
    */
    public function searchs(){

	// {        "type":0,
	//          "paramars":{"product_code":"1","barcode":"34660" },
	//          "params":["11","22"],
	//          "params":"11",
	//          "cols":["product_code","barcode","name","category","typegroup"],
	//  		 "opr":"and",
	//          "order":"asc",
	//          "result_lenght":"10",
	//          "pageNo":"1" 
	// }

    	$rq = Input::get();
    	if( $rq == NULL )  return  '-1';

    	if($rq['result_lenght'] < 0 || $rq['pageNo'] <= 0 ) return '-2';
	 $skip = ( $rq['pageNo'] -1 )  *  $rq['result_lenght'];	


    	DB::enableQueryLog();
	$rs =  Realtimehidl::whereRaw('1= ?',[1]);


    	//type == 1
    	if($rq['type'] == 1 ) {
		$rs->where( function($query) use ($rq)  {
			 foreach ( $rq['paramars'] as $key => $value) {
				($rq['opr'] == 'or')  ? $query->orWhere($key,'like','%'.$value.'%') :  $query->where($key,'like','%'.$value.'%') ;
			 }
		});

    	// type == 0
    	 }else {
	     if($rq['cols'] == NULL ) return '-3';
	     // if(trim($rq['params']) == NULL ) return '-4';
	     $s = 'CONCAT_WS("",`'.implode("`,`",$rq['cols']).'`)';
	 // Parametor 
	     if(!is_array($rq['params'])) {
			$params = $rq['params'];
			$character_mask = " \t\n\r\0\x0B";
			$params = trim($params, $character_mask);
			$params = preg_replace('/\s+/', ' ', $params);
			$arparms = explode(' ', $params);
	      } else {
			$arparms  = $rq['params'];
	     }

	     $rs->where(function($query) use ($rq,$s,$arparms) {
	     
	     foreach ($arparms as $key => $value) {
	              ($rq['opr'] == 'or')  ? $query->whereRaw($s.' like ?',['%'.$value.'%'],'or') :  $query->whereRaw($s.' like ?',['%'.$value.'%'],'and') ;
	     	}
	     });

		foreach ($arparms as $key => $value) {
			$rs->orderByRaw('locate(?,?) ASC',[$value,$s]);	
		}
		$rs->orderByRaw( '? ASC',[$s]);

    	 } // end if

	$result = new \stdClass();
 	$result->count = $rs->count();
 	if($rq['result_lenght'] >0 ) $rs->take($rq['result_lenght'])->skip($skip);
    	 $result->pageNo = $rq['pageNo'];
    	 ($rq['result_lenght'] > 0 ) ?  $result->result_lenght = $rq['result_lenght'] : $result->result_lenght = count($rs);
	 $result->items = $rs->get();
    	 // $queries = DB::getQueryLog();
    	 // dd($queries);
	 $result->querys = $queries = DB::getQueryLog();
    	 return json_encode($result);
    }


}
