<?php

namespace App\Http\Controllers;

use App\Temporal_File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class ConfigurationController extends Controller
{
    public function index()
    {
        $setting = [
            "hospital_name" => setting('hospital_name'),
            "schedule" => setting('schedule'),
            "email" => setting('email'),
            "phone_number" => setting('phone_number'),
            "direction" => setting('direction'),
            "logo_photo" => setting('logo_photo'),
        ];
        return view('backoffice.configuration.configuration', compact("setting"));
    }
    public function store(Request $request)
    {

        $rules = [
            'hospital_name' => 'required',
            'schedule' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'direction' => 'required',
        ];
        $customMessages = [
            'hospital_name.required' => 'Nombre requerido',
            'schedule.required' => 'Horario requerido',
            'email.required' => 'Correo requerido',
            'email.email' => 'No es un correo valido',
            'phone_number.required' => 'Telefono requerido',
            'direction.required' => 'Dirección requerida',
        ];

        $validatedData = $request->validate($rules, $customMessages);

        setting()->set('hospital_name', $request->hospital_name);
        setting()->set('schedule', $request->schedule);
        setting()->set('email', $request->email);
        setting()->set('phone_number', $request->phone_number);
        setting()->set('direction', $request->direction);


        if ($request->hasFile('file')) {
            $this-> deleteResource();
            $image = $request->file('file');
            // $filename = round(microtime(true)) . $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = round(microtime(true)) . '.' . $extension;
            $image_course = Image::make($image->getRealPath());
            $image_course->save(public_path('config_photo/' . $filename));
            $file_name = "config_photo/" . $filename;
            setting()->set('logo_photo',  $file_name);
        }
        setting()->save();
        return 1;
    }
    public function deleteResource(){
        if(file_exists(setting('logo_photo'))){
            unlink(setting('logo_photo'));
        }
         setting()->forget('logo_photo');
         return  setting()->save();
    }
    public function getConfigResource(){
       $setting = setting('logo_photo');
        return view("backoffice.configuration.ajax_get_config_resource",compact("setting"));
    }

}
