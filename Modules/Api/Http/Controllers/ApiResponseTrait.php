<?php
/**
 * Created by PhpStorm.
 * User: longta
 * Date: 2019/03/01
 * Time: 15:38
 */

namespace Modules\Api\Http\Controllers;


trait ApiResponseTrait
{
    protected function returnSuccess($data = null)
    {
        $return = ['success' => 1];
        if(!empty($data)){
            $return['data'] = $data;
        }
        return response()->json($return);
    }

    /**
     * @param $error_code
     * @param null $mess
     * @param int $return_code
     * @return \Illuminate\Http\JsonResponse
     * @internal param array $data
     */
    protected function returnError($error_code, $mess = null, $return_code = 400){
        if(empty($mess)){
            $mess = [__('messages.error_mess.server_error')];
        } else if ( !is_array($mess)){
            $mess = [$mess];
        }

        return response()->json([
            'success' => 0,
            'error_code' => $error_code,
            'msg' => $mess,
        ], $return_code);
    }

    /**
     * Unauthorized error
     *
     * @param null $mess
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnUnAuthorizedError($mess = null)
    {
        if(empty($mess)){
            $mess = [__('messages.error_mess.unauthorized')];
        } elseif (!is_array($mess)){
            $mess = [$mess];
        }

        return $this->returnError(ERROR_CODE_UNAUTHORIZED, $mess, HTTP_ERROR_CODE_UNAUTHORIZED);
    }

    /**
     * Bad request
     *
     * @param null $mess
     * @return \Illuminate\Http\JsonResponse
     */
    protected function returnBadRequestError($mess = null)
    {
        if(empty($mess)){
            $mess = [__('messages.error_mess.bad_request')];
        } elseif (!is_array($mess)){
            $mess = [$mess];
        }

        return $this->returnError(ERROR_CODE_BAD_REQUEST, $mess, HTTP_ERROR_BAD_REQUEST);
    }

    /**
     * @param $field_message_map  ex. ['field_1' => ['msg1'],'field_2' => ['msg2'],]
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @internal param null $mess
     * @internal param int $return_code
     * @internal param array $data
     */
    protected function returnValidationError($field_message_map)
    {
        throw \Illuminate\Validation\ValidationException::withMessages($field_message_map);
    }
}