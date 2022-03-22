<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/stats/usersnumber",
     *    tags={"ADMINISTRATION__STATISTIQUE"},
     *     summary="Nombre des utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function nbreUsers()
    {
        return User::where('is_admin', 2)->count();
    }

    /**
     * @OA\Get(
     *     path="/admin/stats/transacnumber",
     *    tags={"ADMINISTRATION__STATISTIQUE"},
     *     summary="Nombre des transactions",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function nbreTransac()
    {
        return Transaction::count();
    }

    /**
     * @OA\Get(
     *     path="/admin/stats/depotnumber",
     *    tags={"ADMINISTRATION__STATISTIQUE"},
     *     summary="Nombre des depots",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function nbreDepot()
    {
        return Transaction::where('type_trans',1)->count();
    }

    /**
     * @OA\Get(
     *     path="/admin/stats/envoienumber",
     *    tags={"ADMINISTRATION__STATISTIQUE"},
     *     summary="Nombre des envoies",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function nbreEnvoie()
    {
        return Transaction::where('type_trans',2)->count();
    }
}
