<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\TransactionResource;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        try {
            $transaction = $this->transactionRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data transaksi berhasil ditemukan', TransactionResource::collection($transaction), 200);
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
            $transactions = $this->transactionRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            return ResponseHelper::jsonResponse(true, 'Data user berhasil ditemukan', PaginateResource::make($transactions, TransactionResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function store(TransactionStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $transaction = $this->transactionRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data transaksi berhasil ditambahkan', TransactionResource::make($transaction), 200);
        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $transaction = $this->transactionRepository->getById($id);

            if (! $transaction) {
                return ResponseHelper::jsonResponse(false, 'Data transaksi gagal ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data transaksi berhasil ditemukan', new TransactionResource($transaction), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function showByCode(string $code)
    {
        try {
            $transaction = $this->transactionRepository->getByCode($code);

            if (! $transaction) {
                return ResponseHelper::jsonResponse(false, 'Data transaksi gagal ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data transaksi berhasil ditemukan', new TransactionResource($transaction), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
