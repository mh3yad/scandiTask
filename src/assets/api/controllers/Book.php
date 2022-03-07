<?php


class Book extends ProductController{
    public function productValidate($data)
    {
        AddProductRequest::validate([
            'SKU' => [
                'required' => [],
                'unique' => ['product']
            ],
            'name' => [
                'required' => [],
            ],
            'price' => [
                'required' => [],
                'digits' => [],
            ],
            'product_type' => [
                'required' => [],
            ],
            'weight' => [
                'required' => [],
                'digits' => [],
            ],
        ]);
        if (count(AddProductRequest::getErrors()) == 0) {
            $data['displayProductFormat'] = $this->displayProductFormat($data['attributes']);
            $product = new Product($data);
            $product->add();
            return true;
        } else {
            $errors = AddProductRequest::getErrors();
            // $e = json_encode($errors,JSON_FORCE_OBJECT);
            return $errors;
        }
    }
}