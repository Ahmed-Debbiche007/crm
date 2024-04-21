<?php

namespace App\Http\Controllers;

use App\Models\Appart;
use App\Models\Client;
use App\Models\Etage;
use App\Models\Image;
use App\Models\Residence;
use Exception;
use Illuminate\Http\Request;

class AppartsController extends Controller
{
    

    public function get($id)
    {
        $appart = Appart::with('image', 'client')->findOrFail($id);
        return response()->json($appart);
    }

}
