<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProductCategoryResource;
use App\Interfaces\ProductCategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(Request $request)
    {
        try {
            $productCategory = $this->productCategoryRepository->getAll(
                $request->search,
                $request->is_parent,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil ditemukan', ProductCategoryResource::collection($productCategory), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'string|nullable',
            'is_parent' => 'boolean|nullable',
            'row_per_page' => 'integer|nullable',
        ]);

        try {
            $productCategory = $this->productCategoryRepository->getAllPaginated($request['search'] ?? null, $request['parent_id'] ?? null, $request['row_per_page']);
            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil ditemukan', PaginateResource::make($productCategory, ProductCategoryResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function store(ProductCategoryStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $productCategory = $this->productCategoryRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil ditambahkan', PaginateResource::make($productCategory, ProductCategoryResource::class), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }

    }


    public function show(string $id)
    {
        try {
            $productCategory = $this->productCategoryRepository->getById($id);

            if (!$productCategory) {
                return ResponseHelper::jsonResponse(false, 'Data kategori produk gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil ditemukan', new ProductCategoryResource($productCategory), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function showBySlug(string $slug)
    {
        try {
            $productCategory = $this->productCategoryRepository->getBySlug($slug);

            if (!$productCategory) {
                return ResponseHelper::jsonResponse(false, 'Data kategori produk gagal ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil ditemukan', new ProductCategoryResource($productCategory), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function update(ProductCategoryUpdateRequest $request, string $id)
    {
        try {
            $productCategory = $this->productCategoryRepository->getById($id);

            if (!$productCategory) {
                return ResponseHelper::jsonResponse(false, 'Data kategori produk gagal ditemukan', null, 404);
            }
            $productCategory = $this->productCategoryRepository->update($id, $productCategory);
            return ResponseHelper::jsonResponse(true, 'Data kategori produk berhasil diupdate', new ProductCategoryResource($productCategory), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }


    public function destroy(string $id)
    {
        try {
            $productCategory = $this->productCategoryRepository->getById($id);
            if (!$productCategory) {
                return ResponseHelper::jsonResponse(false, 'Data kategori gagal ditemukan', null, 404);
            }

            $productCategory = $this->productCategoryRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Data kategori berhasil dihapus', new ProductCategoryResource($productCategory), 201);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
