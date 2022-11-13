<template>
<select class="form-control">
    <slot></slot>
  </select>
</template>

<script>
import Select2 from 'select2';

export default {
  props: ['options', 'value','name'],
  
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({
          theme: 'bootstrap4',
          data: this.options })
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
  },
  watch: {
    value: function (param) {
      // update value
      $(this.$el).val(param).trigger('change');
    },
    options: function (param) {
      // update options
      $(this.$el).select2({ 
          data: param 
          });
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
  
}
</script>