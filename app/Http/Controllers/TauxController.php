<?php

namespace App\Http\Controllers;

use App\Models\taux;
use Illuminate\Http\Request;

class TauxController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/taux/list",
     *    tags={"ADMINISTRATION__TAUX"},
     *     summary="Liste des taux",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        return taux::all();
    }

    /**
     * @OA\Get(
     *     path="/admin/taux/getaux/{id}",
     *     tags={"ADMINISTRATION__TAUX"},
     *     summary="Récupére un taux d'échange",
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
    public function getaux($id)
    {
        $taux = taux::find($id);

        return $taux;
    }

    /**
     * @OA\Post(
     *     path="/admin/taux/update",
     *    tags={"ADMINISTRATION__TAUX"},
     *     summary="Modifie le taux d'échange",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *               @OA\Property(
     *                   property = "taux_id",
     *                   type="integer",
     *                   example = 1
     *                 ),
     *                @OA\Property(
     *                   property = "taux_amount",
     *                   type="float",
     *                   example = 572.50
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
            'taux_id' => 'required',
            'taux_amount' => 'required',
        ]);

        $taux = taux::find($request->taux_id);

        if (!$taux) {
            return response([
                "message" => "Taux introuvable",
                "visibility" => false
            ], 404);
        }

        $taux->taux_change = $request->taux_amount;
        $taux->save();

        return response([
            "message" => "Taux modifié avec succés",
            "visibility" => true
        ], 200);
    }

}
