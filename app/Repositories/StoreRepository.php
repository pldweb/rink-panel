<?php

namespace App\Repositories;

use App\Helper\ResponseHelper;
use App\Interfaces\StoreRepositoryInterface;
use App\Models\Store;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class StoreRepository implements StoreRepositoryInterface
{
    public function getAll(?string $search, ?bool $isVerified, ?int $limit, bool $execute)
    {
        $query = Store::where(function ($query) use ($search, $isVerified) {
            if ($search) {
                $query->search($search);
            }

            if ($isVerified !== null) {
                $query->where('is_verified', $isVerified);
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

    public function getAllPaginated(?string $search, ?bool $isVerified, ?int $rowPerPage)
    {
        $query = $this->getAll($search, $isVerified, null, false);
        return $query->paginate($rowPerPage);
    }

    public function getById(string $id)
    {
        $query = Store::find($id);
        return $query;
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $store = new Store;
            $store->user_id = $data['user_id'];
            $store->name = $data['name'];
            $store->logo = $data['logo']->store('assets/store', 'public');
            $store->about = $data['about'];
            $store->phone = $data['phone'];
            $store->address_id = $data['address_id'];
            $store->city = $data['city'];
            $store->address = $data['address'];
            $store->postal_code = $data['postal_code'];
            $store->save();

            $store->storeBallance()->create([
                'balance' => 0,
            ]);

            DB::commit();
            return $store;
        } catch (\Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function updateVerifiedStatus(string $id, bool $isVerified)
    {
        DB::beginTransaction();
        try {
            $store = Store::find($id);
            $store->is_verified = $isVerified;
            $store->save();
            DB::commit();

            return $store;
        }catch (Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());

        }
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();
        try {
            $store = Store::find($id);
            $store->name = $data['name'];

            if (isset($data['logo'])) {
                $store->logo = $data['logo']->store('assets/store', 'public');
            }

            $store->about = $data['about'];
            $store->phone = $data['phone'];
            $store->address_id = $data['address_id'];
            $store->city = $data['city'];
            $store->address = $data['address'];
            $store->postal_code = $data['postal_code'];
            $store->save();

            DB::commit();
            return $store;
        } catch (\Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $store = Store::find($id);
            $store->delete();
            DB::commit();
        } catch (Exception $exception){
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
