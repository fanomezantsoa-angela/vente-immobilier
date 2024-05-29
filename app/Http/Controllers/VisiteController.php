<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use App\Models\Visite;
use App\Models\Immobilier;
use Illuminate\Support\Facades\Log;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class VisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'nom' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'dates' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'imm_id' => 'required|integer',
        ]);

        // Créez la visite
        $visite = $request->user()->visites()->create($validated);
        try{ 
            $immobilier = Immobilier::findOrFail($validated['imm_id']);

            if ($immobilier->user) {
                $destinataireEmail = $immobilier->user->email;
                Mail::to($destinataireEmail)->send(new ReservationConfirmation($visite, $immobilier));
                return response()->json(['message' => 'Visite créée avec succès'], 201);
            }
        }
       
        catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
       

        
    } catch (Exception $e) {
        Log::error($e->getMessage());
        return response()->json(['error' => $e->getMessage()]);
    }
}








    /**
     * Display the specified resource.
     */
    public function show(Visite $visite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visite $visite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visite $visite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visite $visite)
    {
        //
    }
    public function nombre(){
        try{
        $visites = DB::select('select count(*) as nombvis from visites');
        return response()->json($visites);
        }
        catch (Exception $e) {
            echo $e->getMessage(); 
        }
    }
}
