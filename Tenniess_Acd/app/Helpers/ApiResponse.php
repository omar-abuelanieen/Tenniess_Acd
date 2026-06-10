<?php

if (!function_exists('successResponse')) {
    function successResponse($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}

if (!function_exists('createdResponse')) {
    function createdResponse($data = null, string $message = 'Created successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 201);
    }
}

if (!function_exists('updatedResponse')) {
    function updatedResponse($data = null, string $message = 'Updated successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}

if (!function_exists('deletedResponse')) {
    function deletedResponse(string $message = 'Deleted successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}

if (!function_exists('notFoundResponse')) {
    function notFoundResponse(string $message = 'Resource not found')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 404);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string $message = 'Something went wrong', int $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }
}

if (!function_exists('validationErrorResponse')) {
    function validationErrorResponse($errors, string $message = 'Validation failed')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }
}

if (!function_exists('unauthorizedResponse')) {
    function unauthorizedResponse(string $message = 'Unauthorized')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 401);
    }
}
