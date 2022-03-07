<template>
  <div>
<div class="form-style-2">
 <header>
        <h1>Product Add</h1>
        <div class="btns">
            <button @click="back()">Cancel</button>
            <button type="submit" @click="addProduct()">Save</button>
        </div>
    </header>
       <br>
       <hr>
  <form action="" id="product_form" @submit.prevent="addProduct()">
    
        <p class="errors" v-for="error in errors" :key="error">{{error}}</p>
        <br>
    <label for="field1">
      <span>SKU</span>
      <input type="text" id="sku" class="input-field" name="field1" v-model="Product.SKU" />
    </label>
    <label for="field2">
      <span>Name </span>
      <input type="text" id="name" class="input-field" name="field2" v-model="Product.name" />
    </label>
    <label for="field3">
      <span>Price </span>
      <input type="text" id="price" class="input-field" name="field3" v-model="Product.price" />
    </label>
    <label for="field4">
      <span>Select type</span>
      <select name="switcher" id="productType" @change="getAttributes($event)"  class="select-field">
          <option  selected disabled>please select product</option>
          <option v-for="type in types" :key="type.id" :value="type.id" :id="type.name" >{{type.name}}</option>
      </select>
    </label>

       <label  v-for="attribute in attributes" :key="attribute.id">
            <label for="{{attribute.name}}" >
              <span>{{attribute.name}} ({{attribute.measurement_unit}}) </span> </label>
              <input   class="input-field" name="field1" type="text"   v-model="attribute.value">
        </label>
        <p>{{type.description}}</p>

  </form>
</div>
  </div>


</template>

<script>
import axios from "axios";
export default {
  name: "Home",

  data() {
    return {
      errors:{},
      types:{},
      attributes:[{
      
      }],
      type:{
        id:'',
        name:'',
        description:''
      },
      Product: {
        SKU: '',
        name: '',
        price: '',

        product_attributes:{}
      }
    };
  },
  methods: {
    addProduct() {
      var data = new FormData();
      data.append("SKU", this.Product.SKU);
      data.append("name", this.Product.name);
      data.append("price", this.Product.price);
      data.append("product_type", this.type.name);
      data.append("attributes",JSON.stringify(this.attributes));
      this.attributes.forEach(attr => data.append(attr.name,attr.value));
      axios
        .post(
          "http://localhost/pleacework/src/assets/api/api.php?action=addProduct",
          data
        )
        .then(res => {
          if (res.data.error) {
              this.errors = res.data.message

          } else {
              this.back();
          }
        })
        .catch(err => {
          console.log("Error", err);
        });
    },
    setTypeValues(type_id){
     
      for(const type of this.types){
          if(type.id == type_id){
              this.type.id = type.id;
              this.type.name = type.name;
              this.type.description = type.description;
          }
      }
    },
    getAttributes(type){
       
       this.setTypeValues(type.target.value);
       let id = type.target.value;
       axios
        .get(
          "http://localhost/scandi/src/api/api.php?action=getAttributes&id="+id,
        )
        .then(res => {
          if (res.data.error) {
            console.log("Error", res);
          } else {
            this.attributes =res.data
          }
        })
        .catch(err => {
          console.log("Error", err);
        });
    

    },

    back(){
      this.$router.push("/");
    }
  },
  mounted(){
     axios
        .get(
          "http://localhost/scandi/src/api/api.php?action=getTypes",
        )
        .then(res => {
          if (res.data.error) {
            console.log("Error", res);
          } else {
            this.types = res.data
          }
        })
        .catch(err => {
          console.log("Error", err);
        });
    }
}
</script>

<style lang="scss">
  @import '@/assets/sass/productAdd.scss';
</style>