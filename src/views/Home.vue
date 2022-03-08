<template>
  <div class="home">
    <header>
        <h1>Product List</h1>
        <div class="btns">
           <button> <router-link to="/addproduct">ADD</router-link></button>
           <!-- <button id="dltbtn" value="MASS DELETE" @click="massDelete()">MASS DELETE</button> -->
           <button id="dltbtn" value="MASS DELETE" @click="massDelete()">MASS DELETE</button>

        </div>
    </header>
       <br>
       <hr>
    <section v-if="Object.keys(products).length != 0" class="cards">
       
        <div  v-for="product in products" :key="product.id" class="card" >
          <input type="checkbox" class="delete-checkbox" :id="product.id" >
          <label :for="product.id">{{product.SKU}}<br>{{product.name}}<br>{{product.price}} $<br>{{product.displayProductFormat}}</label>
          </div>
          
    </section>
    <hr>
  </div>
  
</template>


<script>
// @ is an alias timport axios from "axios";

// checks = document.getElementsByClassName("delete-checkbox");
// for(let i=0;i<checks.length;i++){
// checks[i].checked=true;
// }
// let btn = document.getElementById("dltbtn");
// btn.click();


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
      
      massDelete(){
        let checks = document.getElementsByClassName("delete-checkbox");
        for(let i=0;i<checks.length;i++){
        if(checks[i].checked == true){
            this.toDelete.push(checks[i].id);
            }
        }
        var data = new FormData();
        data.append("toDeleteArray", this.toDelete);
        axios
          .post(
            "https://scandiwebtaskayad.000webhostapp.com/api.php?action=delete",data
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
                "https://scandiwebtaskayad.000webhostapp.com/api.php?action=getAll"
              )
              .then(res => {
                if (res.data.error || res.data === []) {
                  this.products = [];

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
