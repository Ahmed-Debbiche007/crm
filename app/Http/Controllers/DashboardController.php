<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $residences = Residence::with('etage','parking','cellier','image','file','etage.appart', 'etage.appart.charge', 'etage.appart.echance.echeance','etage.appart.echance.echeance')->get();
        return view('pages.dashboard.index',['residences'=>$residences]);
    }
}
