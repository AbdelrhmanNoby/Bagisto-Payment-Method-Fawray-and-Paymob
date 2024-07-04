<?php

namespace Webkul\Fawray\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Webkul\Fawray\Http\Controllers\controller;

class ApiFawrayController extends Controller
{
    public function index(){

        return response()->json(['message' => 'Hello from FawrayController!']);
    }


    public function login(Request $request)
    {
        // catch data 
        $userIdentifier = $request->input('userIdentifier');
        $password = $request->input('password');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://atfawry.fawrystaging.com/user-api/auth/login', [
                'userIdentifier' => $userIdentifier,
                'password' => $password,
            ]);

            // Check if the request was successful
            if ($response->successful()) {
                $responseData = $response->json();

                // Check if the 'type' key exists in the response
                if (array_key_exists('type', $responseData)) {
                    $loginData = $responseData['type'];

                    return response()->json([
                        'loginData' => $loginData,
                    ]);
                } else {
                    // Log the response for debugging
                    Log::error('Unexpected response structure', ['response' => $responseData]);

                    return response()->json([
                        'error' => 'Unexpected response structure',
                        'response' => $responseData,
                    ], 400);
                }
            } else {
                // Log the error response for debugging
                Log::error('API request failed', ['response' => $response->body()]);

                return response()->json([
                    'error' => 'API request failed',
                    'response' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Exception during API request', ['exception' => $e]);

            return response()->json([
                'error' => 'Exception during API request',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



}
