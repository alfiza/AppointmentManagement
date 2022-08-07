<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Doctors;
use App\DoctorsAvailability;

class DoctorsAvailabilityController extends Controller
{
    public function addDoctorsAvailability(Request $req)
    {   
        $doctors = Doctors::all();
        
        return view('addEditDoctorsAvailability', compact('doctors'));
    }
    public function EditDoctorsAvailability(Request $req)
    {           
        $doctors = Doctors::all();
        $doctor_id = $req->id;
        $doctor_details = DoctorsAvailability::DoctorsAvailabilApt($doctor_id);
        return view("addEditDoctorsAvailability", compact('doctors','doctor_details','doctor_id'));
    }
    public function saveDoctorsAvailability(Request $req)
    {   
        $validator_name_req = Validator::make($req->all(), [
            'doctor_id' => "required"
        ]);
        $validator_name_unique = Validator::make($req->all(), [
            'doctor_id' => "unique:doctors_availability,doctor_id,$req->doctor_id"
        ]);
        if ($validator_name_req->fails()) {
            $arr['status']= 'danger';
            $arr['message'] = "Doctor name is required.";
            return redirect(url('DoctorsAvailability'))->with($arr);
        }
        if ($validator_name_unique->fails()) {
            $arr['status']= 'danger';
            $arr['message'] = "Doctor's availability details already exist.<a href=''>Click here </a>to update details.";
            return redirect(route('addEditDoctorsAvailability'))->with($arr);
        }
        DoctorsAvailability::storeDoctorsAvailability($req);
        $arr["status"]="success";
        $arr["message"]="Appointment added successfully.";
        return redirect(url('/DoctorsAvailability'))->with($arr);
    }
    public function updateDoctorsAvailability(Request $req)
    {   
        $validator_name_req = Validator::make($req->all(), [
            'doctor_id' => "required"
        ]);
        DoctorsAvailability::updateDoctorsAvailability($req);
        $arr["status"]="success";
        $arr["message"]="Appointment updated successfully.";
        return redirect(url("/DoctorsAvailability/$req->doctor_id"))->with($arr);
    }
    public function deleteDoctorsAvailability($doctor_id)
    {   
        DoctorsAvailability::where('doctor_id',$doctor_id)->delete();
        $arr["status"]="success";
        $arr["message"]="Appointment deleted successfully.";
        return $arr;
    }
    public function showDoctorsAvailability($doctor_id)
    {   
        $doctors = Doctors::leftJoin("doctors_availability","doctors.id","doctors_availability.doctor_id")
            ->where("open_status",1) 
            ->where("doctor_id",$doctor_id) 
            ->orderBy("days") 
            ->get();       
            return view("showEditDoctorsAvailability", compact('doctors')); 

    }
}
