<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class BaseFormRequest extends FormRequest
{
    protected $hasError = false;
    protected $data = null;
    protected $errors = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function makeRules(): array
    {
        return [
            //
        ];
    }

    /**
     * Check validation of data from client
     *
     * @param array $data
     */
    public function validate($data)
    {
        $this->data = $data;
        $validator = Validator::make($data, $this->makeRules());
        $arrErrors = [];
        if ($validator->fails()) {
            $keys = $validator->errors()->keys();
            $messages = $validator->errors()->getMessages();
            foreach ($keys as $key) {
                $arrErrors[$key] = $messages[$key][0];
            }
        }
        if (empty($arrErrors)) {
            $this->hasError = false;
        } else {
            $this->hasError = true;
            $this->errors = $arrErrors;
        }

        return $this;
    }

    public function hasError() : bool
    {
        return $this->hasError;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getValidatedData() : array
    {
        return $this->data;
    }
}
