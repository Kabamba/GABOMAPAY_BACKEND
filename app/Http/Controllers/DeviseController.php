<?php

namespace App\Http\Controllers;

use App\Models\Devise;
use Illuminate\Http\Request;

class DeviseController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/devises/list",
     *    tags={"ADMINISTRATION__DEVISE"},
     *     summary="Liste des devises",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        return Devise::all();
    }

    /**
     * @OA\Post(
     *     path="/admin/devises/store",
     *    tags={"ADMINISTRATION__DEVISE"},
     *     summary="Ajouter une devise",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "libelle",
     *                   type="string",
     *                   example = "dollars"
     *                  ),
     *                @OA\Property(
     *                   property = "symbole",
     *                   type="string",
     *                   example = "$"
     *                  ),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            'symbole' => 'required'
        ]);

        $devise = new Devise();

        $devise->libelle = $request->libelle;
        $devise->symbole = $request->symbole;
        $devise->save();

        return response([
            "message" => "Devise ajoutée avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/devises/show/{id}",
     *    tags={"ADMINISTRATION__DEVISE"},
     *     summary="Renvoie les informations d'une devise par son ID",
     *      @OA\Parameter(
     *          name = "id",
     *          required = true,
     *          in = "path",
     *          example = 18,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function show($id)
    {
        $devise = Devise::find($id);

        if (!$devise) {
            return response([
                "message" => "Devise introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return $devise;
    }

    /**
     * @OA\Post(
     *     path="/admin/devises/update",
     *    tags={"ADMINISTRATION__DEVISE"},
     *     summary="Editer les informations d'une devise",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "id",
     *                   type="integer",
     *                   example = 10
     *                  ),
     *                @OA\Property(
     *                   property = "libelle",
     *                   type="string",
     *                   example = "dollars"
     *                  ),
     *                @OA\Property(
     *                   property = "symbole",
     *                   type="string",
     *                   example = "$"
     *                  ),
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
            "libelle" => "required",
            "symbole" => "required",
        ]);

        $devise = Devise::where('id', $request->id)->first();

        if (!$devise) {
            return response([
                "message" => "Devise introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $devise->libelle = $request->libelle;
        $devise->symbole = $request->symbole;
        $devise->save();

        return response([
            "message" => "Devise modifiée avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/devises/activate/{id}",
     *    tags={"ADMINISTRATION__DEVISE"},
     *     summary="Active ou désactive l'état d'une devise par son ID",
     *      @OA\Parameter(
     *          name = "id",
     *          required = true,
     *          in = "path",
     *          example = 18,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function activate($id)
    {
        $devise = Devise::where('id', $id)->first();

        if (!$devise) {
            return response([
                "message" => "Devise introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($devise->is_active == 1) {
            $devise->is_active = 0;
            $devise->save();
            return response([
                "message" => "Devise désactivée",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $devise->is_active = 1;
            $devise->save();
            return response([
                "message" => "Devise activée",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }

 
}
