<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreBalanceResource;
use App\Http\Resources\UserResource;
use App\Interfaces\StoreBalanceRepositoryInterface;
use Illuminate\Http\Request;

class StoreBalanceController extends Controller
{

    private StoreBalanceRepositoryInterface $storeBalanceRepository;

    public function __construct(StoreBalanceRepositoryInterface $storeBalanceRepository)
    {
        $this->storeBalanceRepository = $storeBalanceRepository;
    }

    public function index(Request $request)
    {
        try {
            $storeBallance = $this->storeBalanceRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Dompet Toko berhasil ditemukan', StoreBalanceResource::collection($storeBallance), 200);
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
            $users = $this->storeBalanceRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data dompet toko berhasil ditemukan', PaginateResource::make($users, StoreBalanceResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $storeBalance = $this->storeBalanceRepository->getById($id);

            if (!$storeBalance) {
                return ResponseHelper::jsonResponse(false, 'Data dompet toko gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data dompet toko berhasil ditemukan', new StoreBalanceResource($storeBalance), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
