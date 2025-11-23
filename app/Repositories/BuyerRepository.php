<?php

namespace App\Repositories;

use App\Helper\ResponseHelper;
use App\Interfaces\BuyerRepositoryInterface;
use App\Interfaces\StoreBalanceHistoryRepositoryInterface;
use App\Interfaces\StoreBalanceRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Buyer;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class BuyerRepository implements BuyerRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = Buyer::where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
            }
        });

        if($limit){
            $query->take($limit);
        }

        if($execute){
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAll($search, null, false);
        return $query->paginate($rowPerPage);
    }

    public function getById(string $id)
    {
        $query = Buyer::where('id', $id);
        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $buyer = new Buyer;
            $buyer->user_id = $data['user_id'];
            $buyer->profile_picture = $data['profile_picture']->store('assets/buyer', 'public');
            $buyer->phone_number = $data['phone_number'];
            $buyer->save();
            DB::commit();
            return $buyer;
        } catch (\Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $buyer = Buyer::find($id);
            if (isset($data['profile_picture'])) {
                $buyer->profile_picture = $data['profile_picture']->store('assets/buyer', 'public');
            }
            $buyer->phone_number = $data['phone_number'];
            $buyer->save();
            DB::commit();
            return $buyer;
        } catch (\Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
