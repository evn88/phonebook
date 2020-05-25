<template>
<div v-show="filtersShow" class="card">
 <div class="card-body">

    <div class="form-row align-items-center" > <!--  .d-none -->
        <div class="col-auto my-2">
          <label class="mr-sm-3 sr-only" for="inlineFormCustomSelect">Preference</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="selected_filial">
            <!-- <option value=null disabled>Филиал...</option> -->
            <option value="null" selected>Филиал...</option>
            <option v-for="filial in items.filials" v-bind:value="filial.id" v-bind:key="filial.id">
                {{ filial.name }}
            </option>
          </select>
        </div>
        <div class="col-auto my-2">
          <label class="mr-sm-3 sr-only" for="inlineFormCustomSelect">Preference</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="selected_departament">
            <option value="null" selected>Подразделение...</option>
            <option v-for="d in dep.departaments" v-bind:value="d.id" v-bind:key="d.id">
                {{ d.name }}
            </option>
            <!-- <option value="1">Группа по внедрению и обслуживанию средств связи и телемеханики</option>
            <option value="2">Контрольное управление</option> -->
          </select>
        </div>
    </div>
    <hr>
    <div class="form-row align-items-center">
        <div class="col-6">

          <div class="input-group mb-6">
            <div class="custom-control custom-checkbox mr-sm-2">
              <input type="checkbox" class="custom-control-input" id="customControlAutosizing" v-model="save_filter_state">
              <label class="custom-control-label" for="customControlAutosizing">Запомнить настройки фильтров</label>
            </div>


          </div>
        </div>

        <div class="col-6 ">
            <div class="custom-control">
              <button type="button" class="btn btn-outline-dark" @click="reset_filters">Сбросить фильтры</button>
            </div>
        </div>

    </div>

  </div>
</div>

</template>

<script>
export default {
    data: function() {
        return {
            selected_filial: null,
            selected_departament: null,
            save_filter_state: false,
            dep: { departaments: [{ id:null, name: null}] }
        }
    },
    props: ['filtersShow','items'],
    watch: {
        selected_filial: function(v){
          if(v !== 'null'){
              this.selected_departament = null //сбрасываем значение
              this.dep = (this.items.filials.filter(function(el){
                  return v === el.id
              })[0]) || { departaments: [{ id:null, name: null}] }
              this.$emit('id-SelectedFilial', this.selected_filial);
          } else {
              this.reset_filters()
          }
        },
        selected_departament: function(v){
          if(v !== 'null'){
            this.$emit('id-SelectedDepartament', this.selected_departament);
          } else {
            this.selected_departament = null
          }
        }
    },
    methods: {
      reset_filters: function() {
        console.log('reset filter selected')
        this.selected_filial = null
        this.selected_departament = null
        this.dep = { departaments: [{ id:0, name: null}] }
      }
    }
}
</script>