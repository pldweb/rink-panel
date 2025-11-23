<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreBalanceHistoryResource;
use App\Http\Resources\UserResource;
use App\Interfaces\StoreBalanceHistoryRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class StoreBalanceHistoryController extends Controller
{
    private StoreBalanceHistoryRepositoryInterface $storeBalanceHistoryRepository;

    public function __construct(StoreBalanceHistoryRepositoryInterface $storeBalanceHistoryRepository)
    {
        $this->storeBalanceHistoryRepository = $storeBalanceHistoryRepository;
    }

    public function index(Request $request)
    {
        try {
            $storeBalanceHistory = $this->storeBalanceHistoryRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Riwayat Dompet toko berhasil ditemukan', StoreBalanceHistoryResource::collection($storeBalanceHistory), 200);
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
            $storeBalanceHistory = $this->storeBalanceHistoryRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data riwayat dompet toko berhasil ditemukan', PaginateResource::make($storeBalanceHistory, StoreBalanceHistoryResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $storeBalanceHistory = $this->storeBalanceHistoryRepository->getById($id);
            if (is_null($storeBalanceHistory)) {
                return responseHelper::jsonResponse(true, 'Data riwayat dompet toko tidak ditemukan', null, 404);
            }

            return responseHelper::jsonResponse(true, 'Data riwayat dompet toko berhasil ditemukan', null, 200);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
