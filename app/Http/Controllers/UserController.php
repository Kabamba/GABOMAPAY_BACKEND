<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/users/list",
     *    tags={"ADMINISTRATION__UTILISATEUR"},
     *     summary="Liste des utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        $users =  User::where('is_admin', 2)->get();

        return UserResource::collection($users);
    }

    /**
     * @OA\Get(
     *     path="/admin/users/show/{id}",
     *    tags={"ADMINISTRATION__UTILISATEUR"},
     *     summary="Renvoie les informations d'un utilisateur par son ID",
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
        $user = User::where('id', $id)->where('is_admin', 2)->first();

        if (!$user) {
            return response([
                "message" => "Utilisateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return UserResource::make($user);
    }

    /**
     * @OA\Get(
     *     path="/admin/users/activate/{id}",
     *    tags={"ADMINISTRATION__UTILISATEUR"},
     *     summary="Active ou désactive l'état d'un utilisateur par son ID",
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
        $user = User::where('id', $id)->where("is_admin", 2)->first();

        if (!$user) {
            return response([
                "message" => "Utilisateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($user->is_active == 1) {
            $user->is_active = 0;
            $user->save();
            return response([
                "message" => "Utilisateur désactivé",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $user->is_active = 1;
            $user->save();
            return response([
                "message" => "Utilisateur activé",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }
}
