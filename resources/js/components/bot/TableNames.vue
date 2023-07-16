<template>
  <div class="card">
    <div class="card-header d-flex align-items-center">
      <div class="col-10">{{ title }}</div>
      <div class="col-2">
        <button class="btn btn-primary" @click.prevent="add()">
          {{ add_button }}
        </button>
      </div>
    </div>

    <div class="card-body">
      <div v-for="(input, index) in inputs" :key="index" class="d-flex mb-2">
        <div class="col-10 pe-2">
          <input
            class="form-control"
            type="text"
            name="table_names[]"
            v-model="inputs[index]"
          />
        </div>

        <div class="col-2">
          <button class="btn btn-danger" @click.prevent="remove(index)">
            {{ delete_button }}
          </button>
        </div>
      </div>

      <span class="text-danger" v-if="errorsPresent">
        <strong>You must have at least one table.</strong>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    add_button: {
      type: String,
      required: true,
    },
    delete_button: {
      type: String,
      required: true,
    },
    table_names: {
      type: Array,
      default: () => [""],
    },
    error: {
      type: Boolean,
      default: () => false,
    },
  },

  data() {
    return {
      inputs: this.table_names,
      errorsPresent: this.error,
    };
  },

  methods: {
    add() {
      this.inputs.push("");
      this.errorsPresent = false;
    },
    remove(index) {
      if (this.inputs.length > 1) {
        this.inputs.splice(index, 1);
        this.errorsPresent = false;
      } else {
        this.errorsPresent = true;
      }
    },
  },
};
</script>
