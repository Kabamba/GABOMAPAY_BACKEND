<?php

namespace App\Http\Controllers;

use App\Models\operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/operators/list",
     *    tags={"ADMINISTRATION__OPERATEURS"},
     *     summary="Liste des opérateurs",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        return operator::all();
    }

    /**
     * @OA\Post(
     *     path="/admin/operators/store",
     *    tags={"ADMINISTRATION__OPERATEURS"},
     *     summary="Ajouter un opérateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "libelle",
     *                   type="string",
     *                   example = "Orange money"
     *                  ),
     *                @OA\Property(
     *                   property = "agent_number",
     *                   type="string",
     *                   example = "+243852277379"
     *                  ),
     *                @OA\Property(
     *                   property = "min",
     *                   type="float",
     *                   example = 10
     *                  ),
     *                @OA\Property(
     *                   property = "max",
     *                   type="float",
     *                   example = 1000
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
            'agent_number' => 'required',
            'min' => 'required',
            'max' => 'required',
        ]);

        $operator = new operator();

        $operator->libelle = $request->libelle;
        $operator->agent_number = $request->agent_number;
        $operator->min = $request->min;
        $operator->max = $request->max;

        $operator->save();

        return response([
            "message" => "Opérateur ajoutée avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/operators/show/{id}",
     *    tags={"ADMINISTRATION__OPERATEURS"},
     *     summary="Renvoie les informations d'un opérateur par son ID",
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
        $devise = operator::find($id);

        if (!$devise) {
            return response([
                "message" => "Opérateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return $devise;
    }

    /**
     * @OA\Post(
     *     path="/admin/operators/update",
     *    tags={"ADMINISTRATION__OPERATEURS"},
     *     summary="Editer les informations d'un opérateur",
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
     *                   property = "libelle",
     *                   type="string",
     *                   example = "M-pesa"
     *                  ),
     *                 @OA\Property(
     *                   property = "agent_number",
     *                   type="string",
     *                   example = "+243852277379"
     *                  ),
     *                 @OA\Property(
     *                   property = "max",
     *                   type="integer",
     *                   example = 1000
     *                  ),
     *                 @OA\Property(
     *                   property = "min",
     *                   type="integer",
     *                   example = 10
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
            "agent_number" => "required",
            "max" => "required",
            "min" => "required",
        ]);

        $devise = operator::where('id', $request->id)->first();

        if (!$devise) {
            return response([
                "message" => "Opérateur introuvable",
                "visibility" => false
            ], 200);
        }

        if ($request->min >= $request->max) {
            return response([
                "message" => "Montant minimum ne peut etre supérieur au montant maximum",
                "visibility" => false
            ], 200);
        }

        $devise->libelle = $request->libelle;
        $devise->agent_number = $request->agent_number;
        $devise->max = $request->max;
        $devise->min = $request->min;
        $devise->save();

        return response([
            "message" => "Opérateur modifié avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/operators/activate/{id}",
     *    tags={"ADMINISTRATION__OPERATEURS"},
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
        $devise = operator::where('id', $id)->first();

        if (!$devise) {
            return response([
                "message" => "Opérateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($devise->is_active == 1) {
            $devise->is_active = 0;
            $devise->save();
            return response([
                "message" => "Opérateur désactivé",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $devise->is_active = 1;
            $devise->save();
            return response([
                "message" => "Opérateur activé",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }
}
