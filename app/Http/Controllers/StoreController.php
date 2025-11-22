<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\StoreResource;
use App\Http\Resources\UserResource;
use App\Interfaces\StoreRepositoryInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    private StoreRepositoryInterface $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        try {
            $stores = $this->storeRepository->getAll(
                $request->search,
                $request->is_verified,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data user berhasil ditemukan', StoreResource::collection($stores), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'string|nullable',
            'is_verified' => 'boolean|nullable',
            'row_per_page' => 'integer|nullable',
        ]);

        try {
            $stores = $this->storeRepository->getAllPaginated($request['search'] ?? null, $request['is_verified'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data toko berhasil ditemukan', PaginateResource::make($stores, StoreResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function store(StoreStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $user = $this->storeRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data toko berhasil disimpan', new StoreResource($user), 201);
        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }

    }


    public function show(string $id)
    {
        try {
            $store = $this->storeRepository->getById($id);

            if (!$store) {
                return ResponseHelper::jsonResponse(false, 'Data toko gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data toko berhasil ditemukan', new StoreResource($store), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function updateVerifiedStatus(string $id)
    {
        try {
            $store = $this->storeRepository->getById($id);

            if (!$store) {
                return ResponseHelper::jsonResponse(false, 'Data toko gagal ditemukan', null, 404);
            }

            $store = $this->storeRepository->updateVerifiedStatus($id, true);
            return ResponseHelper::jsonResponse(true, 'Data toko berhasil diverifikasi', new StoreResource($store), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function update(StoreUpdateRequest $request, string $id)
    {
        try {
            $store = $this->storeRepository->getById($id);

            if (!$store) {
                return ResponseHelper::jsonResponse(false, 'Data toko gagal ditemukan', null, 404);
            }

            $storeValidated = $request->validated();
            $store = $this->storeRepository->update($storeValidated, $id);

            return ResponseHelper::jsonResponse(true, 'Data toko berhasil diupdate', new StoreResource($store), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $user = $this->storeRepository->getById($id);
            if (!$user) {
                return ResponseHelper::jsonResponse(false, 'Data toko tidak ditemukan', null, 404);
            }

            $store = $this->storeRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data toko berhasil dihapus', new StoreResource($store), 201);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
