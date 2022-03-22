<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompteGabonToRdc;
use App\Http\Resources\CompteRdcToGabon;
use App\Http\Resources\CompteToCompteGabon;
use App\Http\Resources\CompteToCompteRdc;
use App\Http\Resources\CompteToMobileRdc;
use App\Http\Resources\DepotGabonResource;
use App\Http\Resources\DepotRdcResource;
use App\Http\Resources\gabonToMobileRdc;
use App\Http\Resources\RetraitRdc;
use App\Http\Resources\TransactionResource;
use App\Models\compte_gabon_to_gabon;
use App\Models\compte_gabon_to_rdc;
use App\Models\compte_rdc_to_gabon;
use App\Models\compte_to_compte_rdc;
use App\Models\compte_to_mobile_rdc;
use App\Models\depot_gabon;
use App\Models\depot_rdc;
use App\Models\gabon_to_mobile_rdc;
use App\Models\operator;
use App\Models\Retrait_rdc;
use App\Models\tarif;
use App\Models\taux;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\PhoneLengthRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class TransactionController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/transactions/list",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Liste des transactions",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function index()
    {
        $transactions = Transaction::orderBy('id', 'asc')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/listinvalide",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Liste des transactions invalides",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function listinvalide()
    {
        $transactions = Transaction::where('status', 2)->orderBy('id', 'desc')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/listvalide",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Liste des transactions valides",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function listvalide()
    {
        $transactions = Transaction::where('status', 1)->orderBy('id', 'desc')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/currenthirty",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Liste des transactions en cours ayant eu lieu moins de 30 minutes",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function currenthirty()
    {
        $transactions = Transaction::where('date_time_trans', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 MINUTE)'))->orderBy('id', 'desc')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/listoday",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Liste des transactions du jour",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function listoday()
    {
        $date = date('Y-m-d');

        $transactions = Transaction::where('date_trans', '=', $date)->orderBy('id', 'desc')->get();

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/limitation/{limit}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Donne un nombre limité des transactions",
     *      @OA\Parameter(
     *          name = "limit",
     *          required = true,
     *          in = "path",
     *          example = 10,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function last($limit)
    {
        $transactions = Transaction::all()->take($limit);

        return TransactionResource::collection($transactions);
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/show/{id}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Affiche les informations d'une transaction par son ID",
     *      @OA\Parameter(
     *          name = "id",
     *          required = true,
     *          in = "path",
     *          example = 10,
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
        $transaction = Transaction::where('id', $id)->first();

        if (!$transaction) {
            return response([
                "message" => "Transaction introuvable",
                "visibility" => false
            ], 404);
        }

        if ($transaction->type_trans == 1) {
            return DepotGabonResource::make($transaction);
        } elseif ($transaction->type_trans == 2) {
            return DepotRdcResource::make($transaction);
        } elseif ($transaction->type_trans == 3) {
            return CompteToCompteRdc::make($transaction);
        } elseif ($transaction->type_trans == 4) {
            return CompteToMobileRdc::make($transaction);
        } elseif ($transaction->type_trans == 5) {
            return CompteToCompteGabon::make($transaction);
        } elseif ($transaction->type_trans == 6) {
            return gabonToMobileRdc::make($transaction);
        } elseif ($transaction->type_trans == 7) {
            return RetraitRdc::make($transaction);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/transacuser/{transac}/{user}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Affiche les informations d'une transaction pour un utilisateur précis",
     *      @OA\Parameter(
     *          name = "transac",
     *          required = true,
     *          in = "path",
     *          example = 10,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name = "user",
     *          required = true,
     *          in = "path",
     *          example = 10,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function transacuser($transac, $user)
    {
        $transaction = Transaction::where('id', $transac)->first();

        if (!$transaction) {
            return response([
                "message" => "Transaction introuvable",
                "visibility" => false
            ], 404);
        }

        if ($transaction->user_id == $user || $transaction->second_id == $user) {
            if ($transaction->type_trans == 1) {
                return DepotGabonResource::make($transaction);
            } elseif ($transaction->type_trans == 2) {
                return DepotRdcResource::make($transaction);
            } elseif ($transaction->type_trans == 3) {
                return CompteToCompteRdc::make($transaction);
            } elseif ($transaction->type_trans == 4) {
                return CompteToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 5) {
                return CompteToCompteGabon::make($transaction);
            } elseif ($transaction->type_trans == 6) {
                return gabonToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 7) {
                return RetraitRdc::make($transaction);
            }
        } else {
            return response([
                "message" => "Vous n'avez pas le droit de visualiser cette transaction",
                "visibility" => false
            ], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/transac_user/{id}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Affiche les transactions d'un utilisateur",
     *      @OA\Parameter(
     *          name = "id",
     *          required = true,
     *          in = "path",
     *          example = 10,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function transac_user($id)
    {
        $transactions = Transaction::where('user_id', $id)
            ->Orwhere('second_id', $id)
            ->orderBy('id', 'desc')->get();

        $items = [];

        foreach ($transactions as $transaction) {

            if ($transaction->type_trans == 1) {
                $items[] =  DepotGabonResource::make($transaction);
            } elseif ($transaction->type_trans == 2) {
                $items[] =  DepotRdcResource::make($transaction);
            } elseif ($transaction->type_trans == 3) {
                $items[] =  CompteToCompteRdc::make($transaction);
            } elseif ($transaction->type_trans == 4) {
                $items[] =  CompteToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 5) {
                $items[] =  CompteToCompteGabon::make($transaction);
            } elseif ($transaction->type_trans == 6) {
                $items[] =  gabonToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 7) {
                $items[] =  RetraitRdc::make($transaction);
            }
        }

        return $items;
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/transac_user_last/{id}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Affiche les transactions d'un utilisateur",
     *      @OA\Parameter(
     *          name = "id",
     *          required = true,
     *          in = "path",
     *          example = 10,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     */
    public function transac_user_last($id)
    {
        $transactions = Transaction::where('user_id', $id)
            ->Orwhere('second_id', $id)
            ->take(5)
            ->orderBy('id', 'desc')->get();

        $items = [];

        foreach ($transactions as $transaction) {

            if ($transaction->type_trans == 1) {
                $items[] =  DepotGabonResource::make($transaction);
            } elseif ($transaction->type_trans == 2) {
                $items[] =  DepotRdcResource::make($transaction);
            } elseif ($transaction->type_trans == 3) {
                $items[] =  CompteToCompteRdc::make($transaction);
            } elseif ($transaction->type_trans == 4) {
                $items[] =  CompteToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 5) {
                $items[] =  CompteToCompteGabon::make($transaction);
            } elseif ($transaction->type_trans == 6) {
                $items[] =  gabonToMobileRdc::make($transaction);
            } elseif ($transaction->type_trans == 7) {
                $items[] =  RetraitRdc::make($transaction);
            }
        }

        return $items;
    }

    /**
     * @OA\Get(
     *     path="/admin/transactions/valider/{id}",
     *     tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Valide une transaction par son ID",
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
    public function valider($id)
    {
        $transaction = Transaction::where('id', $id)->first();

        if (!$transaction) {
            return response([
                "message" => "Transaction introuvable",
                "visibility" => true
            ], 404);
        }

        $transaction->status = 1;
        $transaction->save();

        $user = User::find($transaction->user_id);

        if ($transaction->type_trans == 2) {
            $user->solde = $user->solde + $transaction->montant;
        }

        $user->save();

        return response([
            "message" => "Transaction validée",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/admin/transactions/invalider",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Invalider une transaction",
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
     *                   property = "raison",
     *                   type="string",
     *                   example = "RAS"
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
    public function invalider(Request $request)
    {
        $request->validate([
            "id" => "required|numeric",
            "raison" => "required",
        ]);

        $transaction = Transaction::where('id', $request->id)->first();

        if (!$transaction) {
            return response([
                "message" => "Transaction introuvable",
                "visibility" => false
            ], 404);
        }

        $user = User::find($transaction->user_id);

        if ($transaction->type_trans == 3) {
            $user->solde = $user->solde + $transaction->montant_frais;
        }

        if ($transaction->type_trans == 1) {
            $user->solde = $user->solde - $transaction->montant;
        }

        $user->save();

        $transaction->status = 2;
        $transaction->raison = $request->raison;
        $transaction->save();


        return response([
            "message" => "Transaction invalidée",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/admin/transactions/searchperdate",
     *    tags={"ADMINISTRATION__TRANSACTION"},
     *     summary="Recherche les transactions entre deux dates",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "start",
     *                   type="date",
     *                  ),
     *                @OA\Property(
     *                   property = "end",
     *                   type="date",
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
    public function searchPerDate(Request $request)
    {

        $request->validate([
            'start' => 'required',
            'end' => 'required'
        ]);

        $transaction = Transaction::whereBetween('date_trans', [$request->start, $request->end])->get();

        return TransactionResource::collection($transaction);
    }

    /**
     * @OA\Post(
     *     path="/paiement/simuler",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Permet de simuler une transaction",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 5000
     *                  ),
     *                 @OA\Property(
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
    public function simulation(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'operator_id' => 'required|numeric',
        ]);

        $tarif = tarif::where('operator_id', $request->operator_id)->first();

        if (!$tarif) {
            return response([
                'message' => 'Tarif introuvable',
                'visibility' => false
            ], 200);
        }

        $fees = $tarif->frais_ope + $tarif->frais_perso;

        $total_frais = ($request->amount * $fees) / 100;

        $total = (($request->amount * $fees) / 100) + $request->amount;

        return response([
            'montant_hors_frais' => (int)$request->amount,
            'montant_total' => $total,
            'total_frais' => $total_frais,
            'pourcentage' => $fees,
            'message' => '',
            'visibility' => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/paiement/recharge/gab",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Transfert l'argent d'un compte mobile money ou une carte bancaire du gabon vers un compte GABOMAPAY ",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 1500000
     *                  ),
     *               @OA\Property(
     *                   property = "user_id",
     *                   type="integer",
     *                   example = 1
     *                  ),
     *                 @OA\Property(
     *                   property = "name",
     *                   type="string",
     *                   example = "Daniel Kiala"
     *                  ),
     *                 @OA\Property(
     *                   property = "email",
     *                   type="string",
     *                   example = "danielkiala@gmail.com"
     *                  ),
     *                 @OA\Property(
     *                   property = "phone",
     *                   type="string",
     *                   example = "+243852277379"
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
    public function depot_gabon(Request $request)
    {

        $request->validate([
            'user_id' => 'required|numeric',
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'email' => 'required|string',
            'phone' => 'required'
        ]);

        $SERVER_URL = "https://lab.billing-easy.net/api/v1/merchant/e_bills";

        // Username
        $USER_NAME = 'Gabomapay';

        // SharedKey
        $SHARED_KEY = '91c78ea6-c94f-4839-aef7-9fde3f6aec84';

        $expiry_period = 60;
        $reference = uniqid();

        // =============================================================
        // ============== E-Billing server invocation ==================
        // =============================================================

        $trans = new Transaction();

        $trans->montant = $request->amount;
        $trans->reference = $reference;
        $trans->date_trans = now();
        $trans->type_trans = 1;
        $trans->user_id = $request->user_id;
        $trans->country_id = 2;
        $trans->save();

        $global_array =
            [
                'payer_email' => $request->email,
                'payer_msisdn' => $request->phone,
                'amount' => $request->amount,
                'short_description' => "transaction de : " . $request->name,
                'external_reference' => $reference,
                'payer_name' => $request->name,
                'expiry_period' => $expiry_period,
                "payer_id" => $request->user_id
            ];

        $user = user::find($request->user_id);

        if ($user->country_id != 2) {
            return response([
                'message' => "Le pays du compte ne correspond pas à la transaction",
                'visibility' => true
            ], 200);
        }


        $content = json_encode($global_array);
        $curl = curl_init($SERVER_URL);
        curl_setopt($curl, CURLOPT_USERPWD, $USER_NAME . ":" . $SHARED_KEY);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);

        // Get status code
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Check status <> 200
        if ($status < 200 || $status > 299) {
            die("Error: call to URL  failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        curl_close($curl);

        // Get response in JSON format
        $response = json_decode($json_response, true);

        // Get unique transaction id
        $bill_id = $response['e_bill']['bill_id'];

        return $json_response;
    }

    /**
     * @OA\Post(
     *     path="/paiement/success/gab",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Valide une transactrion du gabon venant de l'API Ebilling",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="float",
     *                   example = 1500000
     *                  ),
     *                @OA\Property(
     *                   property = "paymentsystem",
     *                   type="string",
     *                   example = "airtel money"
     *                  ),
     *                @OA\Property(
     *                   property = "billing_id",
     *                   type="string",
     *                   example = "87288728700AGHD"
     *                  ),
     *                @OA\Property(
     *                   property = "reference",
     *                   type="string",
     *                   example = "11545484848GHDGYHDI"
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
    public function paie_success(Request $request)
    {
        $request->validate([
            "paymentsystem" => "required",
            "reference" => "required",
            "billing_id" => "required",
            "amount" => "required"
        ]);

        $transaction = Transaction::where('reference', $request->reference)->first();

        if (!$transaction) {
            return response([
                "message" => "Transaction introuvable",
                "type" => "danger",
                "visibility" => true
            ], 404);
        }

        $transaction->status = 1;
        $transaction->montant = $request->amount;
        $transaction->save();

        $depot_gabon = new depot_gabon();

        $depot_gabon->transaction_id = $transaction->id;
        $depot_gabon->billing_id = $request->billing_id;
        $depot_gabon->paymentsystem = $request->paymentsystem;
        $depot_gabon->save();

        return response([
            "message" => "Transaction effectuée avec succés",
            "visibility" => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/paiement/simulation/envoie_compte_rdc",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Simule le transfert d'argent d'un compte GABOMAPAY RDC vers un autre compte GABOMAPAY RDC",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 1500000
     *                  ),
     *                @OA\Property(
     *                   property = "sender_id",
     *                   type="integer",
     *                   example = 2
     *                  ),
     *                 @OA\Property(
     *                   property = "recever_number",
     *                   type="string",
     *                   example = "+243852277379"
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
    public function simuler_compte_rdc(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'sender_id' => 'required|numeric',
            'recever_number' => ["required",new PhoneLengthRule(50)],
        ]);

        $sender = User::find($request->sender_id);

        if (!$sender) {
            return response([
                'message' => 'Utilisateur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($sender->country_id != 50) {
            return response([
                'message' => 'Le pays du compte ne correspond pas à la transaction',
                'visibility' => false
            ], 200);
        }

        $restant = $sender->solde - $request->amount;

        if ($restant < 0) {
            return response([
                'message' => 'Votre solde est insuffisant pour effectuer cette transaction',
                'visibility' => false
            ], 200);
        }

        $recever = User::where('phone', $request->recever_number)->first();

        if (!$recever) {
            return response([
                'message' => 'Compte recepteur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($recever->country_id != 50) {
            return response([
                'message' => "Le numéro du recepteur n'est pas permis pour ce type de transaction.Veuillez indiquer un numéro valide de la RDC",
                'visibility' => false
            ], 200);
        }

        return response([
            'montant_total' => $request->amount,
            'recever' => $recever,
            'message' => '',
            'visibility' => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/paiement/envoie_compte_rdc",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Transfert l'argent d'un compte GABOMAPAY RDC vers un autre compte GABOMAPAY RDC",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 1500000
     *                  ),
     *                @OA\Property(
     *                   property = "sender_id",
     *                   type="integer",
     *                   example = 2
     *                  ),
     *                 @OA\Property(
     *                   property = "recever_number",
     *                   type="string",
     *                   example = "+243852277379"
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
    public function envoie_compte_rdc(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'sender_id' => 'required|numeric',
            'recever_number' => ["required",new PhoneLengthRule(50)],
        ]);

        $sender = User::find($request->sender_id);

        if (!$sender) {
            return response([
                'message' => 'Utilisateur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($sender->country_id != 50) {
            return response([
                'message' => 'Le pays du compte ne correspond pas à la transaction',
                'visibility' => false
            ], 200);
        }

        $restant = $sender->solde - $request->amount;

        if ($restant < 0) {
            return response([
                'message' => 'Votre solde est insuffisant pour effectuer cette transaction',
                'visibility' => false
            ], 200);
        }

        $recever = User::where('phone', $request->recever_number)->first();

        if (!$recever) {
            return response([
                'message' => 'Compte recepteur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($recever->country_id != 50) {
            return response([
                'message' => "Le compte recepteur n'est pas de votre pays",
                'visibility' => false
            ], 200);
        }

        $trans = new Transaction();

        $reference = uniqid();

        $trans->montant = $request->amount;
        $trans->reference = $reference;
        $trans->date_trans = now();
        $trans->type_trans = 3;
        $trans->user_id = $sender->id;
        $trans->second_id = $recever->id;
        $trans->country_id = 50;
        $trans->status = 1;
        $trans->save();

        $sender->solde = $restant;
        $sender->save();

        $recever->solde = $recever->solde + $request->amount;
        $recever->save();

        $compte_to_compte_rdc = new compte_to_compte_rdc();

        $compte_to_compte_rdc->recever_id = $recever->id;
        $compte_to_compte_rdc->transaction_id = $trans->id;
        $compte_to_compte_rdc->save();

        return response([
            'message' => 'Transaction effectuée avec succés',
            'visibility' => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/paiement/simulation/envoie_compte_gabon",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Simule le transfert d'argent d'un compte GABOMAPAY GABON vers un autre compte GABOMAPAY GABON",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 1500000
     *                  ),
     *                @OA\Property(
     *                   property = "sender_id",
     *                   type="integer",
     *                   example = 2
     *                  ),
     *                 @OA\Property(
     *                   property = "recever_number",
     *                   type="string",
     *                   example = "+243852277379"
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
    public function simuler_compte_gabon(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'sender_id' => 'required|numeric',
            'recever_number' => 'required',
        ]);

        $sender = User::find($request->sender_id);

        if (!$sender) {
            return response([
                'message' => 'Utilisateur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($sender->country_id != 77) {
            return response([
                'message' => 'Le pays du compte expéditeur ne correspond pas à la transaction',
                'visibility' => false
            ], 200);
        }


        $restant = $sender->solde - $request->amount;

        if ($restant < 0) {
            return response([
                'message' => 'Votre solde est insuffisant pour effectuer cette transaction',
                'visibility' => false
            ], 200);
        }

        $recever = User::where('phone', $request->recever_number)->first();

        if (!$recever) {
            return response([
                'message' => 'Compte recepteur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($recever->country_id != 77) {
            return response([
                'message' => "Le numéro du recepteur n'est pas permis pour ce type de transaction.Veuillez indiquer un numéro valide du Gabon",
                'visibility' => false
            ], 200);
        }

        return response([
            'montant_total' => $request->amount,
            'recever' => $recever,
            'message' => '',
            'visibility' => true
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/paiement/envoie_compte_gabon",
     *    tags={"CLIENT__PAIEMENT"},
     *     summary="Transfert l'argent d'un compte GABOMAPAY GABON vers un autre compte GABOMAPAY GABON",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *              @OA\Schema(
     *                @OA\Property(
     *                   property = "amount",
     *                   type="integer",
     *                   example = 1500000
     *                  ),
     *                @OA\Property(
     *                   property = "sender_id",
     *                   type="integer",
     *                   example = 2
     *                  ),
     *                 @OA\Property(
     *                   property = "recever_number",
     *                   type="string",
     *                   example = "0123456783"
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
    public function envoie_compte_gabon(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'sender_id' => 'required|numeric',
            'recever_number' => 'required',
        ]);

        $sender = User::find($request->sender_id);

        if (!$sender) {
            return response([
                'message' => 'Utilisateur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($sender->country_id != 77) {
            return response([
                'message' => 'Le pays du compte expéditeur ne correspond pas à la transaction',
                'visibility' => false
            ], 200);
        }


        $restant = $sender->solde - $request->amount;

        if ($restant < 0) {
            return response([
                'message' => 'Votre solde est insuffisant pour effectuer cette transaction',
                'visibility' => false
            ], 200);
        }

        $recever = User::where('phone', $request->recever_number)->first();

        if (!$recever) {
            return response([
                'message' => 'Compte recepteur introuvable',
                'visibility' => false
            ], 200);
        }

        if ($recever->country_id != 77) {
            return response([
                'message' => "Le numéro du recepteur n'est pas permis pour ce type de transaction.Veuillez indiquer un numéro valide du Gabon",
                'visibility' => false
            ], 200);
        }

        $trans = new Transaction();

        $reference = uniqid();

        $trans->montant = $request->amount;
        $trans->reference = $reference;
        $trans->date_trans = now();
        $trans->type_trans = 5;
        $trans->user_id = $sender->id;
        $trans->second_id = $recever->id;
        $trans->country_id = 77;
        $trans->status = 1;
        $trans->save();

        $sender->solde = $restant;
        $sender->save();

        $recever->solde = $recever->solde + $request->amount;
        $recever->save();

        $compte_gabon_to_gabon = new compte_gabon_to_gabon();

        $compte_gabon_to_gabon->transaction_id = $trans->id;
        $compte_gabon_to_gabon->recever_id = $recever->id;
        $compte_gabon_to_gabon->save();

        return response([
            'message' => 'Transaction effectuée avec succés',
            'visibility' => true
        ], 200);
    }
}
