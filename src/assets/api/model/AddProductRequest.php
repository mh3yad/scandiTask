<?php


class AddProductRequest implements Validation
{
    private static $validatedData = [];
    private static $errors = [];

    public static function required($attr, $args)
    {
        if (empty($_POST[$attr]) || $_POST[$attr] == 'undefined' ) {
            self::$errors[] = "$attr is required";
        }
    }

    public static function unique($attr, $args)
    {
        $result = DB::query("SELECT * FROM $args[0] WHERE $attr=:data", [':data' => $_POST[$attr]]);
        if (!empty($_POST[$attr]) && count($result) > 0) {
            self::$errors[] = "$attr entered is already exists, please enter another $attr";
        }
    }

    public static function digits($attr, $args)
    {
        if (!empty($_POST[$attr]) && !is_numeric($_POST[$attr])) {
            self::$errors[] = "$attr must contain only digits";
        }
    }

    // Custom validation rules

    public static function validate($rules): array
    {
        foreach ($rules as $key => $rule) {
            foreach ($rule as $item => $values) {
               self::$item($key, $values);
            }
        }

        return self::$validatedData;
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

}