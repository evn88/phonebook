var app = new Vue({
    el: '#app',
    data: {
      title: 'Телефонный справочник',
      filtersShow: false,
      search: null
    },
    methods: {
        tooggleFilter: function(){
            this.filtersShow = !this.filtersShow
        }
    },
    mounted: function() {

    }
})