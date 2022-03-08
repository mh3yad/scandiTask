<?php

class Product
{
    private string $sku;
    private string $name;
    private int $price;
    private string $displayProductFormat;
    private  $attributes;
    private int $lastProductId;

    public function __construct($data)
    {

        $this->sku = $data['SKU'];
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->displayProductFormat = $data['displayProductFormat'] ;
        $this->attributes =  $data['attributes'];
    }



    // adding new product
    public  function add()
    {
        DB::query("INSERT INTO product (sku, name, price,  displayProductFormat)
                                            VALUES (:SKU, :name, :price, :displayProductFormat)", [
            ':SKU' => $this->sku,
            ':name' => $this->name,
            ':price' => $this->price,
            ':displayProductFormat' => $this->displayProductFormat,
        ]);

        //getting last product's id as we need it in value table
        $this->lastProductId = DB::productLastId('product')['last'];
        foreach ($this->attributes as $attr){
            DB::query('INSERT INTO `value` (product_id, attribute_id, attribute_value) VALUES (:product_id, :attribute_id, :attribute_value)', [
                ':product_id' => $this->lastProductId,
                ':attribute_id' => $attr->id,
                ':attribute_value' => $attr->value,
            ]);
        }
   }


    public static function delete($id)
    {
        return DB::query("DELETE FROM product WHERE id=:id", [':id' => $id]);
    }


    // get all products
    public static function all()
    {
        return DB::query("SELECT * FROM product");
    }

    public static function getTypes(){
        return DB::query("SELECT * FROM type");
    }
    public static function getAttributes($type_id){
        return DB::query("SELECT * FROM attribute where type_id=:id",['id'=>$type_id]);
    }
}
