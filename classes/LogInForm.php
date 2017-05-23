<?php

/**
 * Created by PhpStorm.
 * User: glen
 * Date: 20.05.17
 * Time: 13:47
 */
class LogInForm extends BaseForm
{
    public $form_name = 'login';

    protected $fields = ['email', 'password'];

    protected $rules =
    [
        ['email', ['email']],
        ['required', ['email', 'password']],
    ];

    public function setError($field, $error)
    {
        $this->errors[$field] = $error;
    }

    /**
     * Проверка корректности введенного email
     *
     * @param array $fields Список полей для проверки
     * @return bool Результат проверки
     */
    protected function runEmailValidator($fields)
    {
        $result = true;

        foreach ($fields as $value) {
            $field = $this->form_data[$value];

            if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
                $result = false;

                $this->errors[$value] = "Введите корректный email";
            }
        }

        return $result;
    }

}