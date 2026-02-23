<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'slug' => 'required|string|unique:schools,slug',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $user = $request->user();

        // Créer l'école
        $school = School::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug), // S'assurer que le slug est bien formaté
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        // Lier l'utilisateur à l'école et le définir comme propriétaire
        $user->update([
            'school_id' => $school->id,
            'is_owner' => true,
        ]);

        return response()->json([
            'message' => 'École créée avec succès.',
            'school' => $school,
        ]);
    }

    public function update(Request $request)
    {
        $school = $request->user()->school;

        if (!$school) {
            return response()->json(['message' => 'Établissement non trouvé.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $school->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'message' => 'Informations mises à jour avec succès.',
            'school' => $school,
        ]);
    }

    public function show(Request $request)
    {
        return response()->json($request->user()->school);
    }
}
