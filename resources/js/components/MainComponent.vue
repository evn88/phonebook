<template>
<div class="container" id="app">
    <div class="row my-2">
        <div class="col-9">
            <h2>{{title}}</h2>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-md-end">
            <a href="#" class="btn btn-light lead" @click="tooggleFilter" :class="{ active: filtersShow }">
                <i class="fas fa-filter"></i>
            </a> &nbsp;
            <a href="#" class="btn btn-light lead"><i class="far fa-question-circle"></i></a>
        </div>
    </div>

    <!-- Форма поиска -->
    <div class="row">
        <div class="col">
            <form>
                <div class="form-group">
                    <input 
                    type="search" 
                    name="search" 
                    class="form-control" 
                    placeholder="Поиск" 
                    autocomplete="off" 
                    autofocus="autofocus" 
                    v-model="search">
                </div>
            </form>
        </div>
    </div>
    <!-- {{search}}  -->
    <p>{{answer}}<p>

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
                    <div class="card" v-for="(filial, f) in filteredResult" v-bind:key="filial.id">
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
                            <div v-for="(departament, d) in filteredResult[f].departaments" v-bind:key="departament.id">
                                <div >
                                    <div class="card-header ">
                                        <div class="row">
                                            <div class="col-12"><b><i class="fas fa-caret-right"></i> {{ departament.name }}</b></div>
                                        </div>    
                                    </div>
                                </div>
                                

                                <!-- начало контакта -->
                                <div class="list-group list-group-flush" v-for="people in filteredResult[f].departaments[d].people" :key="people.id">
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
import { type } from 'os';
import { log } from 'util';
// import { setTimeout } from 'timers';
    export default {
        data: function() {
            return {
                items: [], //контакты
                filteredResult: [],
                title: "Телефонная книга",
                filtersShow: false,
                search: '',
                answer: "Кого будем искать?",
                loading: true
            }
        },
        created: function () {
          // _.debounce — это функция lodash, позволяющая ограничить то,
          // насколько часто может выполняться определённая операция.
          // В данном случае мы ограничиваем частоту обращений к yesno.wtf/api,
          // дожидаясь завершения печати вопроса перед отправкой ajax-запроса.
          // Узнать больше о функции _.debounce (и её родственнице _.throttle),
          // можно в документации: https://lodash.com/docs#debounce
          this.debouncedGetAnswer = _.debounce(this.getAnswer, 500)
        },
        mounted() {
            this.getContactsAsync()
            // this.filteredResult = this.items
        },
        watch: {
            search: function (query, oldQuery) {
                this.answer = 'Ожидаю, когда вы закончите печатать...'
                this.debouncedGetAnswer()
            }
        },
        methods: {
            getAnswer() {
                // this.filteredResult = this.items.filials
                if(this.search.length > 0){
                    this.answer = ''
                    console.log('search...')
                    let counter = 0
                    let filteredItem = []
                    // console.log("test arr: ", Array.isArray(this.filteredResult[0].departaments))
                    for(let fkey in this.items.filials){
                        for(let dkey in this.items.filials[fkey].departaments){
                            for(let pkey in this.items.filials[fkey].departaments[dkey].people){
                                if(
                                    this.items.filials[fkey].departaments[dkey].people[pkey].name.toLowerCase().includes(
                                        this.search.toLowerCase()
                                    )) 
                                {
                                // -------------------------
                                    let fname = this.items.filials[fkey].name 
                                    let dname = this.items.filials[fkey].departaments[dkey].name
                                    console.log(filteredItem.every(e => e.name !== fname ))

                                    // TODO: Нужно попробовать сделать такуюже проверку не только для филиалов
                                    if(filteredItem.every(function(e){ return e.name !== fname })) 
                                    {
                                        filteredItem.push({
                                            id: this.items.filials[fkey].id,
                                            name: this.items.filials[fkey].name,
                                            departaments: [{
                                                id: this.items.filials[fkey].departaments[dkey].id,
                                                name: this.items.filials[fkey].departaments[dkey].name,
                                                people: [{
                                                    id: this.items.filials[fkey].departaments[dkey].people[pkey].id,
                                                    name: this.items.filials[fkey].departaments[dkey].people[pkey].name,
                                                    profession: this.items.filials[fkey].departaments[dkey].people[pkey].profession,
                                                    tel: this.items.filials[fkey].departaments[dkey].people[pkey].tel
                                                }]
                                            }]
                                        })
                                    } else {
                                          // TODO: либо попробовать что то поколдовать с исключением...  
                                        let fIndex = filteredItem.findIndex( item => item.id == this.items.filials[fkey].id)
                                        let dIndex = filteredItem[fIndex].departaments.findIndex( 
                                                item => item.id == this.items.filials[fkey].departaments[dkey].id
                                            )

                                        if(filteredItem.every(function(e){ 
                                            return e.departaments.every( function(e) { return e.name !== dname }) 
                                        })) {
                                            
                                            filteredItem[fIndex].departaments.push({
                                                id: this.items.filials[fkey].departaments[dkey].id,
                                                name: this.items.filials[fkey].departaments[dkey].name,
                                                people: [{
                                                    id: this.items.filials[fkey].departaments[dkey].people[pkey].id,
                                                    name: this.items.filials[fkey].departaments[dkey].people[pkey].name,
                                                    profession: this.items.filials[fkey].departaments[dkey].people[pkey].profession,
                                                    tel: this.items.filials[fkey].departaments[dkey].people[pkey].tel
                                                }]
                                            })
                                        } else {
                                            filteredItem[fIndex].departaments[dIndex].people.push({
                                                id: this.items.filials[fkey].departaments[dkey].people[pkey].id,
                                                name: this.items.filials[fkey].departaments[dkey].people[pkey].name,
                                                profession: this.items.filials[fkey].departaments[dkey].people[pkey].profession,
                                                tel: this.items.filials[fkey].departaments[dkey].people[pkey].tel
                                            })
                                        }
                                 
                                    }
                                    console.log(
                                        'нашел: ', this.items.filials[fkey].departaments[dkey].people[pkey].name,
                                        ' филиал: ', this.items.filials[fkey].id ,this.items.filials[fkey].name , 
                                        ' отдел: ', this.items.filials[fkey].departaments[dkey].name
                                    );
    
    
                                // ---------------------------
    
                                } 
                                this.filteredResult = filteredItem
                                console.log("filtereditem: ", filteredItem)
                            }
                        }
                    }
                    console.log('counter: ', counter)
                } else {
                    // console.log("restore")
                    console.log('restored: ', this.items.filials)
                    this.filteredResult = this.items.filials
                }


            },
            tooggleFilter: function(){
                this.filtersShow = !this.filtersShow
            },
            async getContactsAsync() {
                this.loading = true;

                try{
                    const {data} = await axios.get('./api/contacts')
                    this.items = data
                    this.filteredResult = data.filials
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
