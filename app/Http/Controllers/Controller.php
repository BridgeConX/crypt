<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param Request $request
     */
    public function encrypt(Request $request)
    {
        $this->validate($request, [
          'key'   => 'required',
          'value' => 'required',
        ]);

        try {
            return response()->json([
              'status'    => true,
              'decrypted' => $request->get('value'),
              'encrypted' => $this->getEncrypter($request)->encrypt($request->get('value')),
            ]);
        } catch (DecryptException $e) {
            return response()->json([
              'status'    => false,
              'decrypted' => $request->get('value'),
              'encrypted' => null,
            ]);
        }
    }

    /**
     * @param Request $request
     */
    public function decrypt(Request $request)
    {
        $this->validate($request, [
          'key'   => 'required',
          'value' => 'required',
        ]);

        try {
            return response()->json([
              'status'    => true,
              'encrypted' => $request->get('value'),
              'decrypted' => $this->getEncrypter($request)->decrypt($request->get('value')),
            ]);
        } catch (DecryptException $e) {
            return response()->json([
              'status'    => false,
              'encrypted' => $request->get('value'),
              'decripted' => null,
            ]);
        }
    }

    /**
     * @param Request $request
     *
     * @return Encrypter
     */
    protected function getEncrypter(Request $request)
    {
        return new Encrypter($request->get('key'), $request->get('cipher', config('app.cipher')));
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  Request $request
     * @param  array   $errors
     *
     * @return Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return new JsonResponse($errors, 422);
    }

}
