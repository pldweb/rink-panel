<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\BuyerStoreRequest;
use App\Http\Resources\BuyerResource;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Interfaces\BuyerRepositoryInterface;
use Illuminate\Http\Request;

class BuyerController extends Controller
{

    private BuyerRepositoryInterface $buyerRepository;

    public function __construct(BuyerRepositoryInterface $buyerRepository)
    {
        $this->buyerRepository = $buyerRepository;
    }

    public function index(Request $request)
    {
        try {
            $buyer = $this->buyerRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data buyer berhasil ditemukan', BuyerResource::collection($buyer), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'string|nullable',
            'row_per_page' => 'integer|nullable',
        ]);

        try {
            $buyer = $this->buyerRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data buyer berhasil ditemukan', PaginateResource::make($buyer, BuyerResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function store(BuyerStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $buyer = $this->buyerRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data buyer berhasil ditambahkan', new BuyerResource($buyer), 200);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $user = $this->buyerRepository->getById($id);

            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'Data buyer gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data buyer berhasil ditemukan', new BuyerResource($user), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
