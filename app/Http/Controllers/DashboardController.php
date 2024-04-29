<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use App\Models\Residence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $residences = Residence::with('etage','parking','cellier','image','file','etage.appart', 'etage.appart.charge', 'etage.appart.echance', 'etage.appart.echance.appart','etage.appart.echance.echeance')->orderBy('id','desc')->get();
        return view('pages.dashboard.index',['residences'=>$residences]);
    }

    public function publicPage($id){
        $residence = Residence::with('etage','parking','cellier','image','file','etage.appart', 'etage.appart.charge', 'etage.appart.echance.echeance','etage.appart.echance.echeance')->where('id',$id)->first();
        return view('pages.public.index',['residence'=>$residence]);
    }

    public function publicPageShow($id){
        $appart = Appart::with('etage','etage.building')->where('id',$id)->first();
        return view('pages.public.show',['appart'=>$appart]);
    }
}
