<?php


class Furniture extends ProductController {
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
            'height' => [
                'required' => [],
                'digits' => [],
            ],
            'width' => [
                'required' => [],
                'digits' => [],
            ],
            'length' => [
                'required' => [],
                'digits' => [],
            ],

        ]);
        if (count(AddProductRequest::getErrors()) == 0) {
            echo "<br> add ";
            $data['displayProductFormat'] = $this->displayProductFormat($data['attributes']);
            $product = new Product($data);
            $product->add();
            return  "1";
        } else {
            $errors = AddProductRequest::getErrors();
            return $errors;
        }
    }
    public function displayProductFormat($obj) : string {
        $height = $obj[0]->value;
        $width = $obj[1]->value;
        $length = $obj[2]->value;

        return "Dimensions " . ' : ' .$height . 'x'   . $width . 'x' . $length;
    }
}
