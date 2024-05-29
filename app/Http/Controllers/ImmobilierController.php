<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Immobilier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class ImmobilierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $immobiliers = Immobilier::all();
            $imagePaths = [];
    
            foreach ($immobiliers as $immobilier) {
                $imagePaths[] = json_decode($immobilier->images);
            }
    
            // Return the image paths as a JSON response
            return response()->json([
                'images' => $imagePaths,
                'ville' => $immobilier->ville,
                'type' => $immobilier->type,
                'description' => $immobilier->description,
                'datedebut' => $immobilier->datedebut,
                'typologie' => $immobilier->typologie,
                'status' => $immobilier->status
        ]);
        } catch (Exception $e) {
            // Return an error JSON response
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        try {
            $validated = $request->validate([
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:8192',
                'datedebut' => 'required|date',
                'ville' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'typologie' => 'required|string|max:255',
                'droitvisite' => 'required|integer',
                'description' => 'required|string',
                
            ]);
    
            $uploadedImages = [];
    
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $path = str_replace('public/', '', $path);
                $uploadedImages[] = $path; // Save the path, not the entire model
            }
    
            // Assurez-vous que l'utilisateur est authentifié avant de créer l'immobilier
            $user = $request->user();
            if ($user) {
                $user->immobiliers()->create([
                    'images' => json_encode($uploadedImages),
                    'datedebut' => $validated['datedebut'],
                    'ville' => $validated['ville'],
                    'droitvisite' => $validated['droitvisite'],
                    'description' => $validated['description'],
                    'typologie' => $validated['typologie'],
                    'status' => $validated['status'],
                ]);
    
                return response()->json(['success' => true, 'message' => 'Immobilier enregistré']);
            } else {
                return response()->json(['error' => 'Utilisateur non authentifié']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred during image upload.', 'details' => $e->getMessage()]);
        }
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Immobilier $immobilier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Immobilier $immobilier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Immobilier $immobilier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Immobilier $immobilier)
    {
        //
    }
    public function filtreType($typologie)
    {
        $immobiliers = [];
        try {
            $immobiliers = DB::select('select * from immobiliers where typologie=?', [$typologie]);
            $filteredData = [];
    
            foreach ($immobiliers as $immobilier) {
                $imagePaths = json_decode($immobilier->images);
                
                // Append data for each immobilier to the result array
                $filteredData[] = [
                    'Num_immobil' => $immobilier->Num_immobil,
                    'images' => $imagePaths,
                    'ville' => $immobilier->ville,
                    'droitvisite' => $immobilier->droitvisite,
                    'description' => $immobilier->description,
                    'datedebut' => $immobilier->datedebut,
                    'typologie' => $immobilier->typologie,
                    'status' => $immobilier->status
                ];
            }
    
            // Return the result array as a JSON response
            return response()->json($filteredData);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function filtreRegion($region){
        try {
            $immobiliers = DB::table('immobiliers')
            ->where('ville', 'like', '%' . $region . '%')
            ->orWhere('description', 'like', '%' . $region . '%')
            ->orWhere('typologie', 'like', '%' . $region . '%')
            ->orWhere('status', 'like', '%' . $region . '%')
            ->get();
            $filteredData = [];
    
            foreach ($immobiliers as $immobilier) {
                $images = json_decode($immobilier->images);
    
                // Ajoutez ici d'autres conditions de filtrage si nécessaire
    
                $filteredData[] = [
                    'Num_immobil' => $immobilier->Num_immobil,
                    'images' => $images, // Assurez-vous que la conversion est nécessaire
                    'ville' => $immobilier->ville,
                    'droitvisite' => $immobilier->droitvisite,
                    'description' => $immobilier->description,
                    'datedebut' => $immobilier->datedebut,
                    'typologie' => $immobilier->typologie,
                    'status' => $immobilier->status
                ];
            }
    
            return response()->json($filteredData);
        } catch (Exception $e) {
            echo $e->getMessage(); 
        }
    }
    
    public function filtreId(){
        try {
            $immobiliers = DB::select('SELECT * FROM immobiliers ORDER BY Num_immobil DESC');
            $filteredData = [];
    
            foreach ($immobiliers as $immobilier) {
                $images = json_decode($immobilier->images);
    
                // Ajoutez ici d'autres conditions de filtrage si nécessaire
    
                $filteredData[] = [
                    'Num_immobil' => $immobilier->Num_immobil,
                    'images' => $images, 
                    'ville' => $immobilier->ville,
                    'droitvisite' => $immobilier->droitvisite,
                    'description' => $immobilier->description,
                    'datedebut' => $immobilier->datedebut,
                    'typologie' => $immobilier->typologie,
                    'status' => $immobilier->status
                ];
            }
    
            return response()->json($filteredData);
        } catch (Exception $e) {
            echo $e->getMessage(); 
        }
    }
    
}
