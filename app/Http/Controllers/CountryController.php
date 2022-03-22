<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/pays/list",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Liste des pays",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        $countries = country::all();

        return CountryResource::collection($countries);
    }

    /**
     * @OA\Get(
     *     path="/admin/pays/listoccupe",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Liste des pays",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function listOccupe()
    {
        $countries = country::where('id', '=', 50)->orWhere('id', '=', 77)->get();

        return CountryResource::collection($countries);
    }

    /**
     * @OA\Post(
     *     path="/admin/pays/store",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Ajouter un pays",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "libelle",
     *                   type="string",
     *                   example = "Gabon"
     *                  ),
     *                @OA\Property(
     *                   property = "devise",
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
            'libelle' => 'required',
            'devise' => 'required'
        ]);

        $country = new country();

        $country->libelle = $request->libelle;
        $country->devise_id = $request->devise;
        $country->save();

        return response([
            "message" => "Pays ajouté avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/pays/show/{id}",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Renvoie les informations d'un pays par son ID",
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
        $country = country::find($id);

        if (!$country) {
            return response([
                "message" => "Pays introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return $country;
    }

    /**
     * @OA\Post(
     *     path="/admin/pays/update",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Editer les informations d'un pays",
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
     *                   example = "Gabon"
     *                  ),
     *               @OA\Property(
     *                   property = "devise",
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
    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
            "libelle" => "required",
            "devise" => "required",
        ]);

        $country = country::where('id', $request->id)->first();

        if (!$country) {
            return response([
                "message" => "Pays introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $country->libelle = $request->libelle;
        $country->devise_id = $request->devise;
        $country->save();

        return response([
            "message" => "Pays modifié avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/pays/activate/{id}",
     *    tags={"ADMINISTRATION__PAYS"},
     *     summary="Active ou désactive l'état d'un pays par son ID",
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
        $country = country::where('id', $id)->first();

        if (!$country) {
            return response([
                "message" => "Pays introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($country->is_active == 1) {
            $country->is_active = 0;
            $country->save();

            return response([
                "message" => "Pays désactivée",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $country->is_active = 1;
            $country->save();

            return response([
                "message" => "Pays activée",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }
}
