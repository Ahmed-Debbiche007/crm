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
    public function index()
    {
        $apparts = [];
        $etage = Etage::with('appart', 'appart.etage', 'appart.client', 'building')->get();
        $residence = request('res');
        $et = request('etage');
        if ($residence) {
            $etage = Etage::with('appart', 'appart.charge', 'appart.etage', 'appart.client', 'building')->where('residence_id', $residence)->get();
        }
        if ($et) {
            $etage = Etage::with('appart', 'appart.etage', 'appart.client', 'building')->where('id', $et)->get();
        }
        foreach ($etage as $et) {
            foreach ($et->appart as $appart) {
                array_push($apparts, $appart);
            }
        }
        
        usort($apparts, function ($a, $b) {
            return $a->created_at < $b->created_at;
        });
        $etages = Etage::with('appart')->get();
        $residences = Residence::with(
            'etage',
            'parking',
            'cellier'
        )->get();
        $clients = Client::all();
        return view('pages.apparts.table', ['apparts' => $apparts, 'etages' => $etages, 'residences' => $residences, 'clients' => $clients]);
    }

    public function store(Request $request)
    {

        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'etage_id' => ['required', 'exists:etages,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['nullable', 'integer'],
            'surface' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric'],
            'bs' => ['nullable', 'integer'],
            'comments' => ['nullable', 'string'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
        ]);

        $appart = Appart::create($formFileds);
        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/apparts/', $filename);
                $image = new Image();
                $image->path = 'uploads/apparts/' . $filename;
                $image->appart_id = $appart->id;
                $image->save();
                $i++;
            }
        }
        $appart->save();

        return redirect()->back()->with('success', 'Appart saved!');
    }

    public function get($id)
    {
        $appart = Appart::with('image', 'client','etage', 'etage.building')->findOrFail($id);
        return response()->json($appart);
    }

    public function show($id)
    {
        $appart = Appart::with('image', 'echance', 'charge', 'echance.client', 'charge.client')->findOrFail($id);
        $etages = Etage::with('appart')->get();
        $residences = Residence::with(
            'etage',
            'parking',
            'cellier'
        )->get();
        $clients = Client::all();
        return view('pages.apparts.show', ['appart' => $appart, 'etages' => $etages, 'residences' => $residences, 'clients' => $clients]);
    }

    public function update(Request $request, $id)
    {
        
        $formFileds = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'etage_id' => ['required', 'exists:etages,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['nullable', 'integer'],
            'surface' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric'],
            'bs' => ['nullable', 'integer'],
            'comments' => ['nullable', 'string'],
            'x' => ['nullable', 'string'],
            'y' => ['nullable', 'string'],
        ]);

        $appart = Appart::findOrFail($id);
        $old_client = $appart->client_id;
        $appart->update($formFileds);
        $images = Image::where('appart_id', $appart->id)->get();
        foreach ($images as $image) {
            //delete old image
            if (file_exists($image->path)) {
                unlink($image->path);
            }
            $image->delete();
        }
        if ($request->has("gallery")) {
            $i = 0;
            foreach ($request->file('gallery') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $i . time() . $i . '.' . $extension;
                $file->move('uploads/apparts/', $filename);
                $image = new Image();
                $image->path = 'uploads/apparts/' . $filename;
                $image->appart_id = $appart->id;
                $image->save();
                $i++;
            }
        }

        return redirect()->back()->with('success', 'Appart updated!');
    }

    public function destroy($id)
    {
        $appart = Appart::findOrFail($id);
        $appart->delete();
        return redirect()->back()->with('success', 'Appart deleted!');
    }

    public function mainLeveePartielle($id)
    {
        $appart = Appart::with('client', 'etage', 'etage.building')->findOrFail($id);
        $date = date('d/m/Y');
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/docs/Modéle-de-demande-de-main-levée-partielle.docx'));
        $my_template->setValue('date', $date);
        $my_template->setValue('residence', $appart->etage->building->name);
        $my_template->setValue('appart', $appart->name);
        $my_template->setValue('name', $appart->client ? $appart->client->name : '');
        $my_template->setValue('lastName', $appart->client ? $appart->client->lastName : '');
        $price = number_format(floatval($appart->price), 3, '.', ',') . 'DT';
        $my_template->setValue('price', $price);
        $priceInLetters = $this->convert_number_to_words($appart->price);
        $my_template->setValue('priceL', $priceInLetters);
        $filename = $appart->client->name . '_' . $appart->client->lastName . '_main_levée_partielle.docx';
        try {
            $my_template->saveAs(storage_path($filename));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la sauvegarde du fichier');
        }

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function mainLevee($id)
    {
        $appart = Appart::with('client', 'etage', 'etage.building', 'echance')->findOrFail($id);
        $date = date('d/m/Y');
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/docs/Modéle-dengagement-de-main-levée.docx'));
        $my_template->setValue('date', $date);
        $my_template->setValue('residence', $appart->etage->building->name);
        $my_template->setValue('appart', $appart->name);
        $my_template->setValue('name', $appart->client ? $appart->client->name : '');
        $my_template->setValue('lastName', $appart->client ? $appart->client->lastName : '');
        $price = number_format(floatval($appart->price), 3, '.', ',') . 'DT';
        $my_template->setValue('price', $price);
        $priceInLetters = $this->convert_number_to_words($appart->price);
        $my_template->setValue('priceL', $priceInLetters);
        // get latest echance 
        $latest_echance = $appart->echance->last();
        $avance = $latest_echance?number_format(floatval($latest_echance->amount_avance), 3, '.', ',') . 'DT': '0 DT';
        $my_template->setValue('avance', $avance);
        $avanceInLetters = $latest_echance? $this->convert_number_to_words($latest_echance->amount_avance) : '0 Dinars';
        $my_template->setValue('avanceL', $avanceInLetters);
        $filename = $appart->client->name . '_' . $appart->client->lastName . '_main_levée.docx';
        try {
            $my_template->saveAs(storage_path($filename));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la sauvegarde du fichier');
        }

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function optionVente($id)
    {
        $appart = Appart::with('client', 'etage', 'etage.building', 'echance')->findOrFail($id);
        $date = date('d/m/Y');
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/docs/Modéle-dune-Option-de-vente.docx'));
        $my_template->setValue('date', $date);
        $my_template->setValue('residence', $appart->etage->building->name);
        $my_template->setValue('address', $appart->etage->building->address);
        $my_template->setValue('appart', $appart->name);
        $type = '';
        if ($appart->type == 0) {
            $type = 'Commerce';
        }
        if ($appart->type == 1) {
            $type = 'Duplex';
        }
        if ($appart->type == 2) {
            $type = 'Duplex - 1';
        }
        if ($appart->type == 3) {
            $type = 'S+1';
        }
        if ($appart->type == 4) {
            $type = 'S+2';
        }
        if ($appart->type == 5) {
            $type = 'S+3';
        }
        if ($appart->type == 6) {
            $type = 'Triplex';
        }
        $my_template->setValue('type', $type);
        $my_template->setValue('surface', $appart->surface);
        $my_template->setValue('etage', $appart->etage->name);
        $my_template->setValue('name', $appart->client ? $appart->client->name : '');
        $my_template->setValue('lastName', $appart->client ? $appart->client->lastName : '');
        $price = number_format(floatval($appart->price), 3, '.', ',') . 'DT';
        $my_template->setValue('price', $price);
        $priceInLetters = $this->convert_number_to_words($appart->price);
        $my_template->setValue('priceL', $priceInLetters);

        $filename = $appart->client->name . '_' . $appart->client->lastName . '_option_vente.docx';
        try {
            $my_template->saveAs(storage_path($filename));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la sauvegarde du fichier');
        }

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    public function renseignement($id)
    {
        $appart = Appart::with('client', 'etage', 'etage.building', 'echance','charge')->findOrFail($id);
        
        $my_template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/public/docs/fiche-de-renseignement-modéle.docx'));
        
        $my_template->setValue('residence', $appart->etage->building->name);
        $my_template->setValue('address', $appart->etage->building->address);
        $my_template->setValue('appart', $appart->name);
        $type = '';
        if ($appart->type == 0) {
            $type = 'Commerce';
        }
        if ($appart->type == 1) {
            $type = 'Duplex';
        }
        if ($appart->type == 2) {
            $type = 'Duplex - 1';
        }
        if ($appart->type == 3) {
            $type = 'S+1';
        }
        if ($appart->type == 4) {
            $type = 'S+2';
        }
        if ($appart->type == 5) {
            $type = 'S+3';
        }
        if ($appart->type == 6) {
            $type = 'Triplex';
        }
        $my_template->setValue('type', $type);
        $my_template->setValue('surface', $appart->surface);
        $my_template->setValue('etage', $appart->etage->name);
        $my_template->setValue('name', $appart->client ? $appart->client->name : '');
        $my_template->setValue('lastName', $appart->client ? $appart->client->lastName : '');
        $my_template->setValue('cin', $appart->client ? $appart->client->cin : '');
        $my_template->setValue('tel', $appart->client ? $appart->client->phone : '');
        $price = number_format(floatval($appart->price), 3, '.', ',') ;
        $my_template->setValue('price', $price);
        $latest_echance = $appart->echance->last();
        $avance = $latest_echance?number_format(floatval($latest_echance->amount_avance), 3, '.', ',') . 'DT': '0 DT';
        $my_template->setValue('avance', $avance);
        $latest_charge = $appart->charge->last();
        $foncier = number_format(floatval($latest_charge->foncier), 3, '.', ',') ;
        $my_template->setValue('foncier', $foncier);
        $syndic = number_format(floatval($latest_charge->syndic), 3, '.', ',') ;
        $my_template->setValue('syndic', $syndic);
        $sonede = number_format(floatval($latest_charge->sonede), 3, '.', ',') ;
        $my_template->setValue('sonede', $sonede);
        $contrat = number_format(floatval($latest_charge->contrat), 3, '.', ',') ;
        $my_template->setValue('contrat', $contrat);

        $filename = $appart->client->name . '_' . $appart->client->lastName . '_renseignement.docx';
        try {
            $my_template->saveAs(storage_path($filename));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la sauvegarde du fichier');
        }

        return response()->download(storage_path($filename))->deleteFileAfterSend(true);
    }

    private function convert_number_to_words($price)
    {
        // Define French words for numbers
        $units = array("", "Un", "Deux", "Trois", "Quatre", "Cinq", "Six", "Sept", "Huit", "Neuf");
        $teens = array("Dix", "Onze", "Douze", "Treize", "Quatorze", "Quinze", "Seize", "Dix-Sept", "Dix-Huit", "Dix-Neuf");
        $tens = array("", "Dix", "Vingt", "Trente", "Quarante", "Cinquante", "Soixante", "Soixante-Dix", "Quatre-Vingt", "Quatre-Vingt-Dix");
        $groups = array(
            array("", "", ""), // No thousands
            array("Mille", "Milles", "Millier"), // Thousands
            array("Million", "Millions", "Million"), // Millions
            array("Milliard", "Milliards", "Milliard") // Billions
        );

        // Split the price into parts
        $parts = explode('.', $price);
        $integerPart = $parts[0];
        $fractionPart = isset($parts[1]) ? $parts[1] : '0';
        $fractionPart = str_pad($fractionPart, 3, '0', STR_PAD_RIGHT);

        // Convert integer part to words
        $integerWords = '';
        $groupsCount = 0;
        while (strlen($integerPart) > 0) {
            $currentGroup = substr($integerPart, -3);
            $integerPart = substr($integerPart, 0, -3);

            if ($currentGroup != '000') {
                $currentGroupWords = '';

                // Convert hundreds
                $hundreds = (int)($currentGroup / 100);
                if ($hundreds > 0) {
                    $currentGroupWords .= $units[$hundreds] . " Cent ";
                }

                // Convert tens and units
                $tensUnits = $currentGroup % 100;
                if ($tensUnits >= 20) {
                    $tensDigit = (int)($tensUnits / 10);
                    $unitsDigit = $tensUnits % 10;
                    $currentGroupWords .= $tens[$tensDigit];
                    if ($unitsDigit > 0) {
                        if ($tensDigit === 8) {
                            $currentGroupWords .= '-';
                        } else {
                            $currentGroupWords .= ' ';
                        }
                        $currentGroupWords .= $units[$unitsDigit];
                    }
                } elseif ($tensUnits >= 10) {
                    $currentGroupWords .= $teens[$tensUnits - 10];
                } elseif ($tensUnits > 0) {
                    $currentGroupWords .= $units[$tensUnits];
                }

                // Add the group label
                $currentGroupLabel = $groups[$groupsCount][(abs($currentGroup) === 1) ? 0 : 1];
                if ($groupsCount > 0 && $currentGroupLabel != '') {
                    $currentGroupWords .= " " . $currentGroupLabel;
                } elseif ($groupsCount == 0 && $currentGroupLabel == 'Millier') {
                    $currentGroupWords .= " " . $currentGroupLabel;
                }

                // Add the group to the result
                $integerWords = $currentGroupWords . " " . $integerWords;
            }

            $groupsCount++;
        }

        // Convert fraction part to words
        $result = trim($integerWords) . " Dinars ";
        $fractionWords = '';
        if ($fractionPart != '000') {
            $fractionWords = " " . $fractionPart;
            $result = $result . $fractionWords . " Millimes";
        }

        return $result;
    }
}
