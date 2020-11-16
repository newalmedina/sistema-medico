<?php

namespace App\Http\Controllers;

use App\DoctorSpecialty;
use App\Specialty;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $specialties =Specialty::all();
        return view("backoffice.personal.personal",compact("specialties"));
    }
    public function getAdmins(Request $request){
        if ($request->ajax()) {
           return  $personals = User::where("is_admin",1)->get();
        }
    }
    public function getSecretaries(Request $request){
        if ($request->ajax()) {
            return  $personals = User::where("is_secretary",1)->get();
        }
    }
    public function getDoctors(Request $request){
        if ($request->ajax()) {
            return  $personals = User::where("is_doctor",1)->get();
        }
    }

    public function store(Request $request){
        $rules = [
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'surnames' => 'required',
            'identification' => 'required',
            'born_date' => 'required',
            'phone_number' => 'required',
            'gender' => 'required',
            'employee_type' => 'required',
            'born_date' => 'required',
        ];
        $customMessages = [
            'name.required' => __('base.Campo requerido'),
            'surnames.required' => __('base.Campo requerido'),
            'identification.required' => __('base.Campo requerido'),
            'born_date.required' => __('base.Campo requerido'),
            'phone_number.required' => __('base.Campo requerido'),
            'gender.required' => __('base.Campo requerido'),
            'employee_type.required' => __('base.Campo requerido'),
            'email.required' => __('base.Campo requerido'),
            'email.unique' => __('base.Este registro ya existe, si no lo visualizas en el listado puedes restauralo desde la papelera'),
        ];

        $validatedData = $request->validate($rules, $customMessages);

        $active = (isset($request->is_active)) ? 1 : 0 ;
        $admin = (isset($request->is_admin)) ? 1 : 0 ;
        $doctor=0;
        $secretary=0;
        ($request->employee_type==1) ?   $doctor=1 :  $secretary=1;
        $user = User::create([
            'name'=>$request->name,
            'surnames'=>$request->surnames,
            'email'=>$request->email,
            'password'=>Hash::make("secret"),
            'identification'=>$request->identification,
            'born_date'=>$request->born_date,
            'phone_number'=>$request->phone_number,
            'gender'=>$request->gender,
            'direction'=>$request->direction,
            'is_admin'=>$admin,
            'is_doctor'=>$doctor,
            'is_secretary'=>$secretary,
            'active'=>$active
        ]);
        $user=User::orderBy("id","desc")->first();

        foreach ($request->specialties as $specialty) {
            DoctorSpecialty::create([
                "user_id"=>$user->id,
                "specialty_id"=>$specialty
            ]);
        }
        return true;
    }

    public function show($id){
        return User::find($id);
    }
    public function update(Request $request, $id){
        $rules = [
            'specialty_name' => 'required'
        ];
        $customMessages = [
            'specialty_name.required' => __('base.Descripción requerida'),
        ];

        $validatedData = $request->validate($rules, $customMessages);
        return User::find($id)->update([
            "description"=>$request->specialty_name
        ]);
    }
    public function destroy($id){
        return User::find($id)->delete();
    }

    public function logout(){

        Auth::logout();
        return redirect('/login');
    }
}
