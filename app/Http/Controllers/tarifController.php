<?php

namespace App\Http\Controllers;

use App\Http\Resources\TarifResource;
use App\Models\tarif;
use Illuminate\Http\Request;

class tarifController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/tarifs/list",
     *    tags={"ADMINISTRATION__TARIFS"},
     *     summary="Liste des tarifs par opérateur",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        $tarifs = tarif::all();

        return TarifResource::collection($tarifs);
    }

    /**
     * @OA\Post(
     *     path="/admin/tarifs/store",
     *    tags={"ADMINISTRATION__TARIFS"},
     *     summary="Ajouter un tarif",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "frais_ope",
     *                   type="float",
     *                   example = 2
     *                  ),
     *                @OA\Property(
     *                   property = "frais_perso",
     *                   type="float",
     *                   example = 1
     *                  ),
     *                @OA\Property(
     *                   property = "operator_id",
     *                   type="integer",
     *                   example = 1
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
            'frais_ope' => 'required',
            'frais_perso' => 'required',
            'operator_id' => 'required|unique:tarifs',
        ]);
                
        $tarif = new tarif();

        $tarif->frais_ope = $request->frais_ope;
        $tarif->frais_perso = $request->frais_perso;
        $tarif->operator_id = $request->operator_id;

        $tarif->save();

        return response([
            "message" => "Tarif ajouté avec succés",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/tarifs/show/{id}",
     *    tags={"ADMINISTRATION__TARIFS"},
     *     summary="Renvoie les informations d'un tarif par son ID",
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
        $tarif = tarif::find($id);

        if (!$tarif) {
            return response([
                "message" => "Tarif introuvable",
                "visibility" => true
            ], 404);
        }

        return TarifResource::make($tarif);
    }

    /**
     * @OA\Post(
     *     path="/admin/tarifs/update",
     *    tags={"ADMINISTRATION__TARIFS"},
     *     summary="Editer les informations d'un tarif",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "id",
     *                   type="integer",
     *                   example = 1
     *                  ),
     *                @OA\Property(
     *                   property = "frais_ope",
     *                   type="float",
     *                   example = 2
     *                  ),
     *                @OA\Property(
     *                   property = "frais_perso",
     *                   type="float",
     *                   example = 1
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
            'frais_ope' => 'required',
            'frais_perso' => 'required',
        ]);

        $tarif = tarif::where('id', $request->id)->first();

        if (!$tarif) {
            return response([
                "message" => "tarif introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $tarif->frais_ope = $request->frais_ope;
        $tarif->frais_perso = $request->frais_perso;

        $tarif->save();

        return response([
            "message" => "Tarif modifié avec succés",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/tarifs/activate/{id}",
     *    tags={"ADMINISTRATION__TARIFS"},
     *     summary="Active ou désactive l'état d'une tarif par son ID",
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
        $tarif = tarif::where('id', $id)->first();

        if (!$tarif) {
            return response([
                "message" => "Tarif introuvable",
                "visibility" => true
            ], 404);
        }

        if ($tarif->is_active == 1) {
            $tarif->is_active = 0;
            $tarif->save();
            return response([
                "message" => "Tarif désactivé",
                "visibility" => true
            ], 200);
        } else {
            $tarif->is_active = 1;
            $tarif->save();
            return response([
                "message" => "Tarif activé",
                "visibility" => true
            ], 200);
        }
    }
}
