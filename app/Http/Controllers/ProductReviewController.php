<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\ProductReviewRequest;
use App\Http\Resources\ProductReviewResource;
use App\Interfaces\ProductReviewRepositoryInterface;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    private ProductReviewRepositoryInterface $productReviewRepository;
    public function __construct(ProductReviewRepositoryInterface $productReviewRepository)
    {
        $this->productReviewRepository = $productReviewRepository;
    }

    public function store(ProductReviewRequest $request)
    {
        $request = $request->validated();

        try {
            $productReview = $this->productReviewRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data product review successfully created!', new ProductReviewResource($productReview), 201);

        }catch (\Exception $exception){
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
