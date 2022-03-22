<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/admins/list",
     *     security = {"bearer"},
     *     tags={"ADMINISTRATION__ADMINISTRATEUR"},
     *     summary="Liste des administrateurs",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        $admins =  User::where('is_admin', 1)->get();

        return AdminResource::collection($admins);
    }

    /**
     * @OA\Post(
     *     path="/admin/admins/store",
     *     tags={"ADMINISTRATION__ADMINISTRATEUR"},
     *     summary="Ajouter un administrateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "name",
     *                   type="string",
     *                   example = "Mulamba"
     *                  ),
     *                @OA\Property(
     *                   property = "prenom",
     *                   type="string",
     *                   example = "Enock"
     *                  ),
     *                @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "bgi@gmail.com"
     *                  ),
     *                @OA\Property(
     *                   property = "sexe",
     *                   type="string",
     *                   example = "M"
     *                  ),
     *                @OA\Property(
     *                   property = "country",
     *                   type="integer",
     *                   example = 1
     *                  ),
     *              @OA\Property(
     *                   property = "admin_level",
     *                   type="integer",
     *                   example = 1
     *                  ),
     *                @OA\Property(
     *                   property = "password",
     *                   type="string",
     *                   example = "12345678"
     *                  ),
     *                @OA\Property(
     *                   property = "password_confirmation",
     *                   type="string",
     *                   example = "12345678"
     *                  )
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
            "name" => "required",
            "prenom" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
            "sexe" => "required|string",
            "country" => "required|integer",
            "admin_level" => "required",
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->sexe = $request->sexe;
        $user->country_id = $request->country;
        $user->is_admin = 1;
        $user->admin_level = $request->admin_level;
        $user->password = Hash::make($request->password);
        $user->save();

        return response(["message" => "Administrateur enregistré avec succes"], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/admins/show/{id}",
     *     tags={"ADMINISTRATION__ADMINISTRATEUR"},
     *     summary="Renvoie les informations d'un administrateur par son ID",
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
        $user = User::where('id', $id)->where("is_admin", 1)->first();

        if (!$user) {
            return response([
                "message" => "Administrateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return $user;
    }

    /**
     * @OA\Post(
     *     path="/admin/admins/update",
     *     tags={"ADMINISTRATION__ADMINISTRATEUR"},
     *     summary="Editer les informations d'un administrateur",
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
     *                   property = "name",
     *                   type="string",
     *                   example = "Mulamba"
     *                  ),
     *                @OA\Property(
     *                   property = "prenom",
     *                   type="string",
     *                   example = "Enock"
     *                  ),
     *                @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "bgi@gmail.com"
     *                  ),
     *                @OA\Property(
     *                   property = "admin_level",
     *                   type="integer",
     *                   example = 2
     *                  ),
     *                @OA\Property(
     *                   property = "password",
     *                   type="string",
     *                   example = "12345678"
     *                  )
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
            "name" => "required",
            "prenom" => "required",
            "email" => "required|email",
            "sexe" => "required",
            "country" => "required",
            "admin_level" => "required",
        ]);

        $user = User::where('id', $request->id)->where('is_admin', 1)->first();

        if (!$user) {
            return response([
                "message" => "Administrateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $email = User::where('email', $request->email)
            ->where('id', '<>', $request->id)
            ->first();

        if ($email) {
            return response([
                "message" => "Adresse mail déjà utilisée",
                "type" => "danger",
                "visibility" => true
            ], 200);
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $image = $request->file('profile');

        if (!empty($image)) {

            $completeFileName = $image->getClientOriginalName();

            $completeFileName = $image->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly) . '_' . rand() . '_' . time() . '.' . $extension;
            $image->storeAs('public/profile', $compPic);

            $user->profile = $compPic;
        }

        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->sexe = $request->sexe;
        $user->country_id = $request->country;
        $user->admin_level = $request->admin_level;
        $user->save();

        return response([
            "message" => "Administrateur modifié avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/admins/activate/{id}",
     *     tags={"ADMINISTRATION__ADMINISTRATEUR"},
     *     summary="Active ou désactive l'état d'un administrateur par son ID",
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
        $user = User::where('id', $id)->where("is_admin", 1)->first();

        if (!$user) {
            return response([
                "message" => "Administrateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($user->is_active == 1) {
            $user->is_active = 0;
            $user->save();
            return response([
                "message" => "Administrateur désactivé",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $user->is_active = 1;
            $user->save();
            return response([
                "message" => "Administrateur activé",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }
}
