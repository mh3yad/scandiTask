<template>
  <div class="home">
    <header>
        <h1>Product List</h1>
        <div class="btns">
           <button> <router-link to="/addproduct">ADD</router-link></button>
           <button id="delet-product-btn"  @click="massDelete()"> MASS DELETE</button>

        </div>
    </header>
       <br>
       <hr>
    <section class="cards">
        <div v-for="product in products" :key="product.id" class="card" >
          <input type="checkbox" class="delete-checkbox" :id="product.id"  @click="addToDelete(product.id,$event)">
          <label :for="product.id">{{product.SKU}}<br>{{product.name}}<br>{{product.price}} $<br>{{product.displayProductFormat}}</label>
          </div>
    </section>
    <hr>
  </div>
</template>

<script>
// @ is an alias timport axios from "axios";
import axios from "axios";
export default {
  name: 'Home',
  data(){
    return{
        products:[],
        toDelete:[],
    }
  },
  methods:{
      addToDelete(id,event){
        if(event.target.checked){
          this.toDelete.push(id);
        }else{
          this.toDelete = this.toDelete.filter(item => item != id);
        }
        console.log(this.toDelete);
      },
      massDelete(){
        var data = new FormData();
        data.append("toDeleteArray", this.toDelete);
        axios
          .post(
            "http://localhost/pleacework/src/assets/api/api.php?action=delete",data
          ).then(res => {
              if (res.data.error) {
                console.log("Error", res);

              } else {
                  this.getAllData();
              }
            })
            .catch(err => {
              console.log("Error", err);
            });
        },
        getAllData(){
           axios
              .get(
                "http://localhost/pleacework/src/assets/api/api.php?action=getAll"
              )
              .then(res => {
                if (res.data.error || res.data === 'empty') {
                  console.log("Error", res);

                } else {
                   this.products = res.data
                }
              })
              .catch(err => {
                console.log("Error", err);
              });
    
        }
  },
  mounted(){
    this.getAllData();
  }
}
</script>

<style lang="scss">
  @import '@/assets/sass/productList.scss';
</style>
