<template>
<div class="container" id="app">
    <div class="row my-2">
        <div class="col-9">
            <h2>{{title}}</h2>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-md-end">
            <a href="#" class="btn btn-light lead" @click="tooggleFilter" :class="{ active: filtersShow }"><i class="fas fa-filter"></i></a> &nbsp;
            <a href="#" class="btn btn-light lead"><i class="far fa-question-circle"></i></a>
        </div>
    </div>

    <!-- Форма поиска -->
    <div class="row">
        <div class="col">
            <form>
                <div class="form-group">
                    <input type="search" name="search" class="form-control" placeholder="Поиск" autocomplete="off" autofocus="autofocus" v-model.trim="search">
                </div>
            </form>
        </div>
    </div>
    {{search}}

    <!-- фильтр START -->
    <filterpanel-component :filtersShow="filtersShow" :items="items"></filterpanel-component>
    <!-- фильтр END -->

    <div class="row justify-content-md-center my-2" v-if="loading">
        <div class="col text-center"><i class="fas fa-spinner fa-spin"></i></div>
    </div>

    <!-- Список контактов -->
    <div class="row justify-content-md-center my-2">
        <div class="col-12 ">
            <div class="list-group accordion">
                <div class="accordion" id="accordionExample">
                    
                    <!-- начало филиала -->
                    <div class="card" v-for="(filial, f) in items.filials" v-bind:key="filial.id">
                        <div >
                            <div class="card-header bg-dark text-white">
                                <div class="row">
                                    <div class="col-6"><i class="fas fa-home"></i> <b>{{ filial.name }}</b></div>
                                    <div class="col-6 text-right">
                                        <small class="text-muted">
                                            <i class="fas fa-phone-alt"></i> Код: (8442); 400075, <i class="fas fa-home"></i> г. Волгоград, ул. Шопена, 13
                                        </small>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        
                            <!-- начало группы -->
                            <div v-for="(departament, d) in items.filials[f].departaments" v-bind:key="departament.id">
                                <div >
                                    <div class="card-header ">
                                        <div class="row">
                                            <div class="col-12"><b><i class="fas fa-caret-right"></i> {{ departament.name }}</b></div>
                                        </div>    
                                    </div>
                                </div>
                                

                                <!-- начало контакта -->
                                <div class="list-group list-group-flush" v-for="people in items.filials[f].departaments[d].people" :key="people.id">
                                    <a class="list-group-item list-group-item-action  no-border"
                                        :href="'#collapse-' + people.id"  
                                        :id="'heading-' + people.id"
                                        :data-target="'#collapse-' + people.id" 
                                        :aria-controls="'collapse-' + people.id"
                                        data-toggle="collapse" 
                                        aria-expanded="false"
                                        >
                                        <div class="row">
                                            <div class="col-4">{{ people.name }}</div>
                                            <div class="col-6 text-secondary">{{ people.profession }}</div>
                                            <div class="col-2 text-right"><i class="fas fa-phone-alt"></i> <b>{{ people.tel }}</b></div>
                                        </div>
                                    </a>

                                    <div :id="'collapse-' + people.id" class="collapse" :aria-labelledby="'heading-' + people.id" data-parent="#accordionExample">
                                        <div class="card-body bg-secondary text-light">
                                            <p class="">Дополнительные параметры</p>
                                            <p v-if="people.ext_phone"><i class="fas fa-phone-alt"></i> {{ people.ext_phone }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- конец контакта -->
                            </div>
                            <!-- конец группы -->
                    </div>
                    <!-- Конец филиала -->
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import { setTimeout } from 'timers';
    export default {
        data: function() {
            return {
                items: [],
                title: "Телефонная книга",
                filtersShow: false,
                search: null,
                loading: true
            }
        },


        created() {
            },
        mounted() {
            this.getContactsAsync()
        },
        updated() {

        },
        watch: {
            search: (query) => {
                console.log(this.items)
               let result = this.items.filter((data)=>{
                   console.log(data.filials)
                   return data.filials[0].name.toUpperCase().indexOf(query) !== -1
               })
               console.log(result)
               console.log(query)

            }
        },
        methods: {
            tooggleFilter: function(){
                this.filtersShow = !this.filtersShow
            },
            async getContactsAsync() {
                this.loading = true;

                try{
                    const {data} = await axios.get('./api/contacts')
                    // console.log("getPostsAsync", data);
                    this.items = data
                    this.loading = false
                    return data
                } catch(error) {
                    console.error("error load contacts: ", error)
                    this.loading = false
                }
            },
            // toggle(event) {
            //     // if (this.multiple) this.item.active = !this.item.active
            //     // else {
            //         this.$parent.$children.forEach((item, index) => {
            //             console.log(item)
            //             console.log(index)
            //             console.log(event.currentTarget.parentElement)

            //             // if (item.$el.id === event.currentTarget.parentElement.parentElement.id) item.item.active = !item.item.active
            //             // else item.item.active = false
            //         }) 
            //     // }
            // },
            
        }
    }
</script>
