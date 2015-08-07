<?php

namespace Mitul\Controller;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AppBaseController extends Controller
{
    /**
     * Validate request for current resource.
     *
     * @param Request $request
     * @param array   $rules
     * @param array   $messages
     * @param array   $customAttributes
     */
    public function validateRequestOrFail($request, array $rules, $messages = [], $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new HttpException(400, json_encode($validator->errors()->getMessages()));
        }
    }

    public function makeResponse($result, $message)
    {
        return [
            'data'    => $result,
            'message' => $message,
        ];
    }

    public function sendResponse($result, $message)
    {
        return Response::json($this->makeResponse($result, $message));
    }
}
