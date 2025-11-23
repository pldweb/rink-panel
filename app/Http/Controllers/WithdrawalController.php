<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\WithdrawalApproveRequest;
use App\Http\Requests\WithdrawalStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WithdrawalResource;
use App\Repositories\WithdrawalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    private WithdrawalRepository $withdrawalRepository;

    public function __construct(WithdrawalRepository $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->withdrawalRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data withdrawal berhasil ditemukan', WithdrawalResource::collection($users), 200);
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
            $withdrawal = $this->withdrawalRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data withdrawal berhasil ditemukan', PaginateResource::make($withdrawal, WithdrawalResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function store(WithdrawalStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $withdrawal = $this->withdrawalRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data withdrawal berhasil ditambahkan', new WithdrawalResource($withdrawal), 200);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function show(string $id)
    {
        try {
            $withdrawal = $this->withdrawalRepository->getById($id);

            if (!$withdrawal) {
                return ResponseHelper::jsonResponse(false, 'Data withdrawal gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data withdrawal berhasil ditemukan', new WithdrawalResource($withdrawal), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function approve(WithdrawalApproveRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $withdrawal = $this->withdrawalRepository->getById($id);

            if (!$withdrawal) {
                return ResponseHelper::jsonResponse(false, 'Data withdrawal gagal ditemukan', null, 404);
            }

            $withdrawal = $this->withdrawalRepository->approve($id, $request['proof']);
            return ResponseHelper::jsonResponse(true, 'Data withdrawal berhasil ditemukan', new WithdrawalResource($withdrawal), 200);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

}
