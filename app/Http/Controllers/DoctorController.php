<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Doctors;

class DoctorController extends Controller
{
    public function getDoctors(Request $req)
    {   
        return view('list');
    }
    public function getDoctorsList(Request $req)
    {   
        $doctorQry = Doctors::leftJoin("doctors_availability","doctors.id","doctors_availability.doctor_id")
            ->select("doctors.*",\DB::raw("COUNT(doctors_availability.doctor_id) AS doc_apt"));

        $daySearch = $startTimeSearch = $endTimeSearch = $doctorSearch = "";
        if(isset($req->daySearch))
            $daySearch = $req->daySearch;
        if(isset($req->startTimeSearch))
            $startTimeSearch = $req->startTimeSearch;
        if(isset($req->endTimeSearch))
            $endTimeSearch = $req->endTimeSearch;
        if(isset($req->doctorSearch))
            $doctorSearch = $req->doctorSearch;

        if ($daySearch!='') {
            $doctorQry->where('doctors_availability.days', $daySearch)->where('open_status',1);
        }
        if ($startTimeSearch!='' && $endTimeSearch!='') {
            $doctorQry->where('doctors_availability.start_time', '<=', $startTimeSearch.":00");
            $doctorQry->where('doctors_availability.end_time', '>=', $endTimeSearch.":00");
        }
        if ($doctorSearch!='') {
            $doctorQry->where('doctors.name', 'LIKE', '%'.$doctorSearch.'%');
        }
        $doctors = $doctorQry->groupBy("doctors.id")->get();
        return view('doctorsList', compact('doctors'));
    }
    public function getDoctorsDetails(Request $req)
    {   
        $doctors = Doctors::leftJoin("doctors_availability","doctors.id","doctors_availability.doctor_id")
            ->where('doctor_id',$req->doctorId)
            ->get();
        if(!empty($doctors) && count($doctors)>0)            
        {
            return $doctors->toArray();
        }
        return array();
    }
    
}
