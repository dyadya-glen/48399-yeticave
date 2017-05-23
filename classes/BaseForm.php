<?php

/**
 * Created by PhpStorm.
 * User: glen
 * Date: 20.05.17
 * Time: 10:19
 */
class BaseForm
{
    /**
     * @var array $fields Список имен полей формы
     */
    protected $fields =[];

    /**
     * @var array $errors Список ошибок валидации
     */
    protected $errors = [];

    /**
     * @var array $rules Список правил для валидации
     */
    protected $rules =[];

    /**
     * @var array $form_data Отправленные данные
     */
    protected $form_data =[];

    /**
     * @var string Имя формы
     */
    public $form_name;

    /**
     * BaseForm constructor.
     * @param array $data Данные формы
     */
    public function __construct($data = [])
    {
        $this->fillFormData($data);
    }

    /**
     * @return bool
     *
     * Проверяет что форма была отправлен
     */
    public function isSubmitted()
    {
        return isset($_POST[$this->form_name]);
    }

    /**
     * Проверка на ошибки валидации.
     *
     * @return bool
     */
    public function isValid()
    {
        return count($this->errors) == 0;
    }

    /**
     * Возвращает данные, отправленные из формы
     *
     * @return array
     */
    public function getFormData()
    {
        return $this->form_data;
    }

    /**
     * Возвращает текст ошибки для поля.
     *
     * @param string $field Имя поля
     * @return mixed|null Текст ошибки
     */
    public function getError($field)
    {
        return $this->errors[$field] ?? null;
    }

    /**
     * Возвращает валидно ли поле
     * если валидно то true
     *
     * @param string $field
     * @return bool
     */
    public function isValidField($field)
    {
        return empty($this->errors[$field]);
    }

    /**
     * Возвращает список всех ошибок валидации.
     *
     * @return array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }

    /**
     * Выполняет валидацию формы
     * @return void
     */
    public function validate()
    {
        foreach ($this->rules as $rule) {
            list($rulename, $fields) = $rule;

            $this->runValidator($rulename, $fields);
        }
    }

    /**
     * Магический метод для получения
     * значения поля по его имени
     *
     * @param string $name Имя поля
     * @return mixed|null
     */
    public function __get($name)
    {
        $result = $this->form_data[$name] ?? null;
        return $result;
    }

    /**
     * Метод для получения
     * значения поля по его имени
     *
     * @param string $name
     * @return mixed|null
     */
    public function getFieldData($name)
    {
        return $this->form_data[$name] ?? null;
    }

    /**
     * Запускает валидатор по его имени.
     *
     * @param string $name Имя валидатора
     * @param array $fields Список имен полей валидации
     */
    protected function runValidator($name, $fields)
    {
        $method_name = 'run' . ucfirst($name) . 'Validator';

        if (method_exists($this, $method_name)) {
            $this->$method_name($fields);
        }
    }

    /**
     * Проверка полей на заполнение
     *
     * @param array $fields Проверяемое поле
     * @return bool Результат проверки
     */
    protected function runRequiredValidator($fields)
    {
        $result = true;

        foreach ($fields as $key => $value) {
            if (!$this->form_data[$value]) {
                $result = false;

                $this->errors[$value] = "Это поле должно быть заполненно!";
            }
        }

        return $result;
    }

    /**
     * Заполняет данные данными из формы
     *
     * @param array $data Данные для заполнения
     */
    private function fillFormData($data = [])
    {
        if (!$this->isSubmitted()) {
            return;
        }

        $fill_data = !empty($data) ? $data : $_POST[$this->form_name];

        foreach ($this->fields as $field) {
            $this->form_data[$field] = array_key_exists($field, $fill_data) ? $fill_data[$field] : null;
        }
    }
}
