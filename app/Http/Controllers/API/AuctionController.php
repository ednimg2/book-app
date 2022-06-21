<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuctionRequest;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\BadRequestResource;
use App\Models\Auction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(title="Book API", version="1.0.1")
 */
class AuctionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/auctions",
     *      operationId="getAuctionsList",
     *      tags={"Auction"},
     *      summary="Get list of auctions",
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/AuctionResource")
     *       )
     *     )
     */
    public function index(): AnonymousResourceCollection
    {
        return AuctionResource::collection(Auction::with('book')->get());
    }

    /**
     * @OA\Get(
     *      path="/auctions/{id}",
     *      operationId="getAuctionsById",
     *      tags={"Auction"},
     *      summary="Get Auctions by ID",
     *      description="Returns Auctions data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Auction id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/Auction")
     *       ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/BadApiRequest")
     *     )
     * )
     */
    public function show(string $id): AuctionResource|Response
    {
        /** @var Auction $auction */
        $auction = Auction::find($id);

        if (null !== $auction) {
            return new AuctionResource($auction);
        }

        return response([
            'statusCode' => 404,
            'message' => 'Auction does not exist'
        ], 404);
    }

    /**
     * @OA\Post(
     *      path="/auctions",
     *      operationId="postAuction",
     *      tags={"Auction"},
     *      summary="Create new Auction",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreAuctionRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auction")
     *       )
     * )
     */
    public function store(StoreAuctionRequest $request): Response|AuctionResource
    {
        $auction = new Auction();
        $auction->price = $request->price;
        $auction->enabled = $request->enabled;
        $auction->quantity = $request->quantity;
        $auction->book_id = $request->book_id;
        //$auction = Auction::create($request->all());
        $auction->user_id = Auth::user()->id;
        $auction->save();

        return new AuctionResource($auction);
    }

    public function update(int $sellerId, string $auctionId, Request $request): Response|AuctionResource
    {
        $auction = Auction::where('id', '=', $auctionId)->where('user_id', '=', $sellerId)->first();

        if (!$auction) {
            return response(['error' => 'Auction does not exist'], 404);
        }

        if (!Gate::allows('update-auction', $auction)) {
            return response(['error' => 'You do not have permissions to edit auction'], 403);
        }

        $validation = Validator::make(
            $request->all(),
            [
                'price' => 'required',
                'enabled' => 'required',
                'quantity' => 'required',
            ]
        );

        if ($validation->errors()->count() > 0) {
            return response(['errors' => $validation->errors()], 400);
        }

        /*$auction->price = $request->price;
        $auction->enabled = $request->enabled;
        $auction->quantity = $request->quantity;*/
        $auction->update($request->all());
        $auction->save();

        return new AuctionResource($auction);
    }
}
