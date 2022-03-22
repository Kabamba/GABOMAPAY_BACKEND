<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\EmailExistRule;
use App\Rules\PhoneLengthRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Authentifie l'utilisateur avant de se connecter",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "bgi@gmail.com"
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
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|max:255",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");

        if (!Auth::attempt($credentials)) {
            return response([
                "message" => "Adresse mail ou mot de passe invalide",
                "visibility" => false
            ], 200);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();
        $token = $user->createToken($user->name);

        return response([
            "id" => $user->id,
            "name" => $user->name,
            "prenom" => $user->prenom,
            "visibility" => true,
            "email" => $user->email,
            "is_admin" => $user->is_admin,
            "is_active" => $user->is_active,
            "country_name" => $user->country->name,
            "country_id" => $user->country->id,
            "profile" => $user->profile,
            "identite" => $user->identite,
            "sexe" => $user->sexe,
            "adresse" => $user->adresse,
            "created_at" => $user->created_at,
            "update_at" => $user->update_at,
            "token" => $token->accessToken,
            "token_expires_at" => $token->token->expires_at
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Deconnexion de l'utilisateur",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "token",
     *                   type="string",
     *                   schema="Bearer",
     *                   example = "89er4186gjazuihhiZIOJreioiouEIOJIOZERF814879AE8FEA"
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
    public function logout()
    {
        /**
         * @var user $user
         */
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        $userToken = $user->token();
        $userToken->delete();
        return response([
            "message" => "Déconnexion effectuée"
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Inscription de l'utilisateur",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
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
     *                   property = "country",
     *                   type="integer",
     *                   example = 1
     *                  ),
     *                @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "bgi@gmail.com"
     *                  ),
     *                @OA\Property(
     *                   property = "phone",
     *                   type="string",
     *                   example = "+243852277378"
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
     *                  ),
     *              
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "prenom" => "required",
            "country" => "required",
            "email" => ["required", "email", new EmailExistRule()],
            "phone" => ["required","unique:users",new PhoneLengthRule($request->country)],
            "password" => "required|confirmed",
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->is_admin = 2;
        $user->country_id = $request->country;
        $user->password = Hash::make($request->password);
        $user->save();

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return response([
                "message" => "Adresse mail ou mot de passe invalide",
                "visibility" => false
            ], 200);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();
        $token = $user->createToken($user->name);

        return response([
            "id" => $user->id,
            "name" => $user->name,
            "prenom" => $user->prenom,
            "visibility" => true,
            "email" => $user->email,
            "is_admin" => $user->is_admin,
            "is_active" => $user->is_active,
            "country_name" => $user->country->libelle,
            "country_id" => $user->country->id,
            "profile" => $user->profile,
            "identite" => $user->identite,
            "sexe" => $user->sexe,
            "adresse" => $user->adresse,
            "created_at" => $user->created_at,
            "update_at" => $user->update_at,
            "token" => $token->accessToken,
            "token_expires_at" => $token->token->expires_at
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/forgot",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Demande de rénitialisation de mot de passe par mail",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "bgi@gmail.com"
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
    public function forgot(Request $request)
    {
        $request->validate([
            "email" => "required"
        ]);

        $email = $request->email;

        if (User::where("email", $email)->where('is_admin', 2)->doesntExist()) {
            return response([
                "message" => "Adresse mail introuvable",
                "type" => "danger",
                "visibility" => false
            ], 200);
        }

        $token = Str::random(10);

        DB::table("password_resets")->insert([
            "email" => $email,
            "token" => $token,
            "created_at" => now()->addHours(1)
        ]);

        Mail::send("mail.password_reset_mail", ["token" => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject("Rénitialisation du mot de passe");
        });

        return response([
            "message" => "Un email vous a été envoyé",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/reset",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Renitialisation du mot de passe",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "token",
     *                   type="string",
     *                   example = "ufghzruqgioqzruogrjcuuUIBYRCUR?61154600"
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
    public function reset(Request $request)
    {
        $request->validate([
            "token" => "required|string",
            "password" => "required|confirmed"
        ]);

        $token = $request->token;
        $passwordRest = DB::table("password_resets")->where("token", $token)->first();

        if (!$passwordRest) {
            return response([
                "message" => "Le token de rénitialisation est introuvable",
                "type" => "danger",
                "visibility" => false
            ], 200);
        }

        if ($passwordRest->created_at <= now()) {
            return response([
                "message" => "Le token de rénitialisation a expiré",
                "type" => "danger",
                "visibility" => false
            ], 200);
        }

        $user = User::where("email", $passwordRest->email)->first();

        if (!$user) {
            return response([
                "message" => "Utilisateur inconnu",
                "type" => "danger",
                "visibility" => false
            ], 200);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table("password_resets")->where("token", $token)->delete();

        return response([
            "message" => "Mot de passe rénitialisé avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/profile",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Modification des informations du profile de l'utilisateur",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "id",
     *                   type="integer",
     *                   example = 18
     *                  ),
     *                @OA\Property(
     *                   property = "name",
     *                   type="string",
     *                   example = "Kabamba"
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
     *                   property = "phone",
     *                   type="string",
     *                   example = "+243852277378"
     *                  ),
     *                @OA\Property(
     *                   property = "sexe",
     *                   type="string",
     *                   example = "M"
     *                  ),
     *                 @OA\Property(
     *                   property = "adresse",
     *                   type="string",
     *                   example = "N°5 Bukasa Limete 1iere Rue"
     *                  ),
     *                 @OA\Property(
     *                   property = "profile",
     *                   type="file",
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
    public function profile(Request $request)
    {

        $request->validate([
            "id" => "required",
            "name" => "required",
            "prenom" => "required",
            "email" => "required|email",
            "phone" => "required",
            'profile' => 'nullable|mimes:jpeg,png,jpg|max:5120'
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return response([
                "message" => "Utilisateur introuvable",
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
                "visibility" => true
            ], 200);
        }

        $phone = User::where('phone', $request->phone)
            ->where('id', '<>', $request->id)
            ->first();

        if ($phone) {
            return response([
                "message" => "Numéro de téléphone déjà utilisé",
                "visibility" => true
            ], 200);
        }

        $image = $request->file('profile');

        if (!empty($image)) {

            $completeFileName = $image->getClientOriginalName();

            $completeFileName = $image->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $compPic = str_replace(' ', '_', $fileNameOnly) . '_' . rand() . '_' . time() . '.webp';

            $img = Image::make($image);
            // $img->resize(100, 100);
            $img->save(public_path('storage/profile/' . $compPic), 40);

            $user->profile = $compPic;
        }

        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if (!empty($request->sexe) || $request->sexe != "") {
            $user->sexe = $request->sexe;
        }

        if (!empty($request->adresse) || $request->adresse != "") {
            $user->adresse = $request->adresse;
        }

        $user->save();

        return response([
            "message" => "Profile modifié avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/identite",
     *     tags={"AUHTENTIFICATION"},
     *     summary="Chargement de la piéce d'identité de l'utilisateur",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "id",
     *                   type="integer",
     *                   example = 18
     *                  ),

     *                 @OA\Property(
     *                   property = "identite",
     *                   type="file",
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
    public function identite(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'identite' => 'required|mimes:jpeg,png,jpg|max:5120'
        ]);

        $user = User::find($request->id);

        if (!$user) {
            return response([
                "message" => "Utilisateur introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $image = $request->file('identite');

        if (!empty($image)) {

            $completeFileName = $image->getClientOriginalName();

            $completeFileName = $image->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $compPic = str_replace(' ', '_', $fileNameOnly) . '_' . rand() . '_' . time() . '.webp';

            $img = Image::make($image);
            // $img->resize(100, 100);
            $img->save(public_path('storage/identite/' . $compPic), 40);

            $user->identite = $compPic;
            $user->save();
        }

        return response([
            "message" => "Piéce d'identité modifiée avec succés",
            "type" => "success",
            "visibility" => true
        ], 200);
    }
}
