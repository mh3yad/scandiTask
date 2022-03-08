<?php



abstract class  ProductController{
    public array $data;
    protected string $displayProductFormat;
    public function __construct($data){

        // $this->data = $this->sanitizeData($data);
    }

    public function sanitizeData(array $data) :array{
        foreach ($data as $item => $item_value)
        {
            if(is_array($item_value)){
               for ($i=0;$i<sizeof($item_value);$i++){

                    foreach ($item_value[$i] as $key =>$value  ) {
                        $value = trim($value);
                        $value = stripslashes($value);
                        $value = htmlspecialchars($value);
                       $data[$item][$i]->$key = $value;

                    }
                }
            }else {
                $item_value = trim($item_value);
                $item_value = stripslashes($item_value);
                $item_value = htmlspecialchars($item_value);
                $data[$item] = $item_value;
            }
        }

        return $data;
    }
    public  abstract function   productValidate($data);
    public function displayProductFormat($obj): string
    {
        $obj = (array) $obj;
        $obj = $obj[0];
        return $obj->name . ' : ' .$obj->value . ' ' .  $obj->measurement_unit;
    }
    public static  function getAttributes($type_id){
        return Product::getAttributes($type_id);
    }
    public static  function getTypes(){
        return Product::getTypes();
    }
    public static function delete($id){
        return Product::delete($id);
    }


}



