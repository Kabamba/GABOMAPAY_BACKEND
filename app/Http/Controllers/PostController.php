<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/posts/list",
     *    tags={"ADMINISTRATION__PUBLICATION"},
     *     summary="Liste des publications",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * @OA\Post(
     *     path="/admin/posts/store",
     *    tags={"ADMINISTRATION__PUBLICATION"},
     *     summary="Ajouter une publication",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "description",
     *                   type="string",
     *                   example = "Un exemple de description"
     *                  ),
     *                @OA\Property(
     *                   property = "image",
     *                   type="file"
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
            'image' => 'required|mimes:jpeg,png,jpg|max:5120'
        ]);

        $post = new Post();

        $image = $request->file('image');

        if (!empty($image)) {

            $completeFileName = $image->getClientOriginalName();

            $completeFileName = $image->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            
            $compPic = str_replace(' ', '_', $fileNameOnly) . '_' . rand() . '_' . time() . '.webp';

            $img = Image::make($image);

            $img->resize(374, 373);

            $img->save(public_path('storage/posts/'.$compPic),40);

            $post = new Post();

            $post->description = $request->description;
            $post->chemin = $compPic;
            $post->save();

            return response([
                'message' => 'Publication enregistrée avec succés',
                'type' => 'success',
                'visibility' => true
            ], 200);
        } else {
            return response([
                'message' => 'Aucune image chargée',
                'type' => 'danger',
                'visibility' => true
            ], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/posts/show/{id}",
     *    tags={"ADMINISTRATION__PUBLICATION"},
     *     summary="Renvoie les informations d'une publications par son ID",
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
        $post = Post::find($id);

        if (!$post) {
            return response([
                "message" => "Publication introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        return $post;
    }

    /**
     * @OA\Post(
     *     path="/admin/posts/update",
     *    tags={"ADMINISTRATION__PUBLICATION"},
     *     summary="Modifie une publication",
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
     *                   property = "description",
     *                   type="string",
     *                   example = "Un exemple de description"
     *                  ),
     *                @OA\Property(
     *                   property = "image",
     *                   type="file"
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
        ]);

        $post = Post::find($request->id);

        if (!$post) {

            return response([
                'message' => 'Publicatuion introuvable',
                'type' => 'danger',
                'visibility' => true
            ], 404);
        }

        $image = $request->file('image');

        if (!empty($image)) {

            $completeFileName = $image->getClientOriginalName();

            $completeFileName = $image->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly) . '_' . rand() . '_' . time() . '.webp';
            $image->public_path('storage/posts', $compPic);

            $post->description = $request->description;
            $post->chemin = $compPic;
            $post->save();
        } else {
            $post->description = $request->description;
            $post->save();
        }

        return response([
            'message' => 'Publicatuion modifiée avec succés',
            'type' => 'success',
            'visibility' => true
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/admin/posts/activate/{id}",
     *    tags={"ADMINISTRATION__PUBLICATION"},
     *     summary="Active ou désactive l'état d'une publication par son ID",
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
        $post = Post::where('id', $id)->first();

        if (!$post) {
            return response([
                "message" => "Publication introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        if ($post->is_active == 1) {
            $post->is_active = 0;
            $post->save();
            return response([
                "message" => "Publication désactivée",
                "type" => "success",
                "visibility" => true
            ], 200);
        } else {
            $post->is_active = 1;
            $post->save();
            return response([
                "message" => "Publication activée",
                "type" => "success",
                "visibility" => true
            ], 200);
        }
    }
}
