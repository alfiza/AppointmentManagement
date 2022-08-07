<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorsAvailability extends Model
{
    protected $table = "doctors_availability";
    public $timestamps = false;
    public static function storeDoctorsAvailability($req){

        $docavl = new DoctorsAvailability;
        foreach($req->startTime as $key=>$val)
        {
            if($val!=null)
            {
                $insert = $docavl->insert(
                    [
                        'doctor_id' => $req->doctor_id,
                        'days' => $key,
                        'open_status' => 1,
                        'start_time' => $val,
                        'end_time' => $req->endTime[$key],
                    ]
                );
            }
        }
    }
    public static function updateDoctorsAvailability($req)
    {
//         echo "<pre>";
// print_r($req->toArray());
        $existingApts = DoctorsAvailability::DoctorsAvailabilApt($req->doctor_id);
//dd($existingApts);
        $daysArr = array_keys($existingApts);
        foreach($req->startTime as $key=>$val)
        {  
            if(in_array($key,$daysArr))//update
            {
                $getRecord = DoctorsAvailability::where('doctor_id',$req->id)->where('days',$key)->first();
                if($val!='')
                {
                    $docval = DoctorsAvailability::where('id',$getRecord->id)
                        ->update(
                        [
                            'doctor_id' => $req->doctor_id,
                            'days' => $key,
                            'open_status' => 1,
                            'start_time' => $val,
                            'end_time' => $req->endTime[$key],
                        ]);
                }
                else
                {
                    $docval = DoctorsAvailability::where('id',$getRecord->id)
                        ->update(
                        [
                            'doctor_id' => $req->doctor_id,
                            'days' => $key,
                            'open_status' => 0,
                            'start_time' => "00:00:00",
                            'end_time' => "00:00:00"
                        ]);
                }
            }
            else //insert
            {
                if($val!=null)
                {
                    $docavlStore = new DoctorsAvailability;
                    $insert = $docavlStore->insert(
                        [
                            'doctor_id' => $req->doctor_id,
                            'days' => $key,
                            'open_status' => 1,
                            'start_time' => $val,
                            'end_time' => $req->endTime[$key],
                        ]
                    );
                }
            }
        }
    }
    public static function DoctorsAvailabilApt($doctor_id)
    {
        
        $details = DoctorsAvailability::where('doctor_id','=',$doctor_id)->get();
        $doctor_details = array();
        foreach($details as $key=>$val)
        {  
            $doctor_details[$val->days]['id'] = $val->id;
            $doctor_details[$val->days]['open_status'] = $val->open_status;
            $doctor_details[$val->days]['start_time'] = "";
            $doctor_details[$val->days]['end_time'] = "";
            if($val->open_status==1)
            {
                $doctor_details[$val->days]['start_time'] = $val->start_time;
                $doctor_details[$val->days]['end_time'] = $val->end_time;
            }
        }
        return $doctor_details;
    }
}
