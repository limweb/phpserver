<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

class FReportinput extends  Illuminate\Database\Eloquent\Model  {
     // id, numstart, numend, totalrows, totalsales, sumcash, sumcc, sumchk, sumdebit, sumtotal, datesearch
   protected $table = 'field_report_input';
   public $timestamps = false;
   protected $guarded = array('id');
     // protected $hidden = ['created_at = 'updated_at'];
};


class ImportExcelService {   

    var $tbname = "field_report_input";
    public function __construct()  { 
    }

    public function getAllField_report_input() { 
        $rs = Capsule::select("SELECT * FROM $this->tbname");
        return $rs;
    } 


    public function getField_report_inputByID($itemID) {
        $rs  = Capsule::select("SELECT * from $this->tbname where id= ? ",[$itemID]);
       return $rs;
   }


   public function deleteField_report_input($itemID) { 
    $rs  = Capsule::delete("delete from $this->tbname where  id = ?  ",[$itemID]);
    return $rs; 
}

public function createField_report_input($item) { 

        $fri = new FReportinput();
        $fri->id = $item->id;
        $fri->inputID = $item->inputID;
        $fri->fieldID = $item->fieldID;
        $fri->input_status = $item->input_status;
        $fri->input_discription = $item->input_discription;
        $fri->input_date = $item->input_date;
        $fri->input_time = $item->input_time;
        $fri->input_1 = $item->input_1;
        $fri->input_2 = $item->input_2;
        $fri->input_3 = $item->input_3;
        $fri->input_4 = $item->input_4;
        $fri->input_5 = $item->input_5;
        $fri->input_6 = $item->input_6;
        $fri->input_7 = $item->input_7;
        $fri->input_8 = $item->input_8;
        $fri->input_9 = $item->input_9;
        $fri->input_10 = $item->input_10;
        $fri->input_11 = $item->input_11;
        $fri->input_12 = $item->input_12;
        $fri->input_13 = $item->input_13;
        $fri->input_14 = $item->input_14;
        $fri->input_15 = $item->input_15;
        $fri->input_16 = $item->input_16;
        $rs = $fri->save();
        return $rs;
}

public function updateField_report_input($item) { 
    $fri = FReportinput::find($item->id);
    $fri->inputID = $item->inputID;
    $fri->fieldID = $item->fieldID;
    $fri->input_status = $item->input_status;
    $fri->input_discription = $item->input_discription;
    $fri->input_date = $item->input_date;
    $fri->input_time = $item->input_time;
    $fri->input_1 = $item->input_1;
    $fri->input_2 = $item->input_2;
    $fri->input_3 = $item->input_3;
    $fri->input_4 = $item->input_4;
    $fri->input_5 = $item->input_5;
    $fri->input_6 = $item->input_6;
    $fri->input_7 = $item->input_7;
    $fri->input_8 = $item->input_8;
    $fri->input_9 = $item->input_9;
    $fri->input_10 = $item->input_10;
    $fri->input_11 = $item->input_11;
    $fri->input_12 = $item->input_12;
    $fri->input_13 = $item->input_13;
    $fri->input_14 = $item->input_14;
    $fri->input_15 = $item->input_15;
    $fri->input_16 = $item->input_16;
    $rs = $fri->save();
    return $rs;
}

public function count() { 
    $rs = Capsule::select("select count(*) AS COUNT from $this->tbname ");
    return $rs[0]['COUNT']; 
}

public function getField_report_input_paged($startIndex, $numItems) {
    $rs = Capsule::select("SELECT * FROM $this->tbname LIMIT ?, ?",[$startIndex, $numItems]);
    return $rs; 
} 

public function createField_report_inputByImportExcel($arrlist) {
        consolelog('start create report input by import excel');
        try {
                Capsule::beginTransaction();
                foreach ($arrlist as $item) {
                    if(! empty($item->inputID) ){
                        $fri =  new  FReportinput();
                        $fri->inputID=$item->inputID;
                        $fri->fieldID=$item->fieldID;
                        $fri->input_status=$item->input_status;
                        $fri->input_discription=$item->input_discription;
                        $fri->input_date=$item->input_date;
                        $fri->input_time=$item->input_time;
                        $fri->input_1=$item->input_1;
                        $fri->input_2=$item->input_2;
                        $fri->input_3=$item->input_3;
                        $fri->input_4=$item->input_4;
                        $fri->input_5=$item->input_5;
                        $fri->input_6=$item->input_6;
                        $fri->input_7=$item->input_7;
                        $fri->input_8=$item->input_8;
                        $fri->input_9=$item->input_9;
                        $fri->input_10=$item->input_10;
                        $fri->input_11=$item->input_11;
                        $fri->input_12=$item->input_12;
                        $fri->input_13=$item->input_13;
                        $fri->input_14=$item->input_14;
                        $fri->input_15=$item->input_15;
                        $fri->input_16=$item->input_16;
                        $fri->save();
                        consolelog($rs);
                    } //if
                } // foreach

                  Capsule::commit();
                  return 1;
              } catch (Exception $e) {
                  consolelog($e);
                  Capsule::rollback();
                  throw new  Exception($e, 1);
              }
    }
} 