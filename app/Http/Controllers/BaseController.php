<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\BaseService;
use App\Http\Resources\BaseResource;
use App\Http\Requests\BaseRequest;

class BaseController extends Controller
{
    protected BaseService $service;
    protected string $resourceClass;
    protected string $createRequestClass;
    protected string $updateRequestClass;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    /**
     * Get all records with filtering and search
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $data = $this->service->all($request->all());
            
            return $this->successResponse(
                __('messages.data_retrieved_successfully'),
                $this->resourceClass::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_retrieving_data'), 500);
        }
    }

    /**
     * Display a listing of the resource
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->service->paginate($request->all());
            
            return $this->successResponse(
                __('messages.data_retrieved_successfully'),
                $this->resourceClass::collection($data->items()),
                [
                    'pagination' => [
                        'current_page' => $data->currentPage(),
                        'last_page' => $data->lastPage(),
                        'per_page' => $data->perPage(),
                        'total' => $data->total(),
                        'from' => $data->firstItem(),
                        'to' => $data->lastItem()
                    ]
                ]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_retrieving_data'), 500);
        }
    }

    /**
     * Store a newly created resource
     */
    public function store(): JsonResponse
    {
        try {
            $request = app($this->createRequestClass);
            $data = $this->service->create($request->validated());
            
            return $this->successResponse(
                __('messages.created_successfully'),
                new $this->resourceClass($data),
                [],
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_creating_record'), 500);
        }
    }

    /**
     * Display the specified resource
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->service->findById($id);
            
            return $this->successResponse(
                __('messages.data_retrieved_successfully'),
                new $this->resourceClass($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.record_not_found'), 404);
        }
    }

    /**
     * Update the specified resource
     */
    public function update(int $id): JsonResponse
    {
        try {
            $request = app($this->updateRequestClass);
            $data = $this->service->update($id, $request->validated());
            
            return $this->successResponse(
                __('messages.updated_successfully'),
                new $this->resourceClass($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_updating_record'), 500);
        }
    }

    /**
     * Remove the specified resource
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);
            
            return $this->successResponse(__('messages.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.error_deleting_record'), 500);
        }
    }

    /**
     * Success response format
     */
    protected function successResponse(string $message, $data = null, array $meta = [], int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    /**
     * Error response format
     */
    protected function errorResponse(string $message, int $status = 400, array $errors = [], string $code = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if ($code) {
            $response['code'] = $code;
        }

        return response()->json($response, $status);
    }
}