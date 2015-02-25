<?php 
require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
date_default_timezone_set('Asia/Bangkok');

$capsule = new Capsule;

$capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => __DIR__.'/services/fieldlogger.db',
            'prefix'   => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
$pdo = $capsule->getConnection('default');
// class Info extends Model {
//     protected $table = 'field_infoservice';
// }
// $a = "select * from  field_infoservice ";
// $rs = Capsule::select(Capsule::raw($a));//->get();
// var_dump($rs);

// $rs = Info::all();
// $rs = Info::where('serviceNo','=',2)->get()->first();
// var_dump($rs->toArray());
// var_dump($rs->toJson());
// echo json_encode($rs);

function consolelog($status = 200) {
        $lists = func_get_args();
        $status = '';
        foreach ($lists as $list) {
          $status .= json_encode(json_decode(json_encode($list,true)));
        }

       if(isset($_SERVER["REMOTE_ADDR"]) && !empty($_SERVER["REMOTE_ADDR"])){
          $raddr =$_SERVER["REMOTE_ADDR"];
       } else {
          $raddr = '127.0.0.1';
       }

       if(isset($_SERVER["REMOTE_PORT"]) && !empty($_SERVER["REMOTE_PORT"])){
          $rport = $_SERVER["REMOTE_PORT"];
       } else {
          $rport = '8000';
       }

       if(isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])){
          $ruri = $_SERVER["REQUEST_URI"];
       } else {
          $ruri = '/console';
       }

       file_put_contents("php://stdout",
           sprintf("[%s] %s:%s [%s]:%s \n",
               date("D M j H:i:s Y"),
               $raddr,$rport,
               $status,
               $ruri
               )
           );
}
