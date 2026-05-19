<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSUController extends Controller
{
    public function Welcome(){
    return 
    "Mia Shiela Grace Uson <br>
    BSIT-3B";
    }

     public function Mission(){
        return
    "The Pangasinan State University shall provide <br>
    a human-centric, resillent and sustainable
    academic environment to produce dynamic, responsive and future-ready individuals <br>
    capable of meeting the requirement of the <br> ";
    }

     public function Vision(){
    return
    "To be leading industry-driven State University in the ASEAN rehion ny 2030. <br>";
    }
    
    public function EOMSPolicy(){
        return
    "The Pangasinan State University shall  be recognized as an <br>
    ASEAN premier state university that produces quality education <br>
    and satisfactory service delivery through instruction, research, environment and production. <br>
 <br>
    We, commit our  expertise and resources to produce <br>
    professionals who meet the expectation of the industry <br>
    and other interested parties in the national and international community. <br>

    <br>

    We shall continuously improve our operation through systems <br>
    and process innovation guided by ethical, intellectual <br>
    and technology transfer standard in response to the changing <br>
    educational scientific and technological development for <br>
    social responsiveness and in support ofbthe instituions <br>
    strategic direction. <br>";
}

public function student($name,$course){
return 
"Student: $name  | Course: $course";
}


}


// Route::get('/welcome', [PSUController::class, 'Welcome'])->name('WelcomeRoute');
// Route::get('/mission', [PSUController::class, 'Mission'])->name('MissionRoute');
// Route::get('/vision', [PSUController::class, 'Vision'])->name('VisionRoute');
// Route::get('/eoms-policy', [PSUController::class, 'EOMSPolicy'])->name('EOMSPolicyRoute');




    //PANGASINAN STATE UNIVERSITY

    // VISION
    // To be leading industry-driven State University in the ASEAN rehion ny 2030

    // Mission

