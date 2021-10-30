<template>
  <div class="px-6">
    <v-card shaped outlined>
      <v-card-text>
        <v-form ref="devForm" @submit.prevent="devTest()">
          <v-row class="mt-2">
            <v-col cols="12" md="4" lg="2">
              <v-select
                hide-details
                :items="['get', 'post', 'put', 'delete']"
                label="Method"
                outlined
                v-model="devMethod"
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col cols="12" md="6" lg="8">
              <v-text-field
                hide-details
                outlined
                label="Route"
                v-model="devRoute"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
              <v-btn fab text type="submit" color="primary">Send</v-btn>
            </v-col>
          </v-row>
          <v-divider class="my-6"></v-divider>
          <v-row v-for="(param, i) in paramsArray" :key="i">
            <v-col cols="2">
              <v-select
                hide-details
                :items="['text', 'number', 'file']"
                label="Type"
                outlined
                v-model="param.type"
              ></v-select>
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model="param.key"
                hide-details
                outlined
                label="Key"
              ></v-text-field>
            </v-col>
            <v-col cols="5">
              <v-file-input
                v-if="param.type === 'file'"
                v-model="param.value"
                label="Value"
                multiple
                prepend-icon=""
                outlined
              ></v-file-input>
              <v-text-field
                v-else
                :type="param.type"
                v-model="param.value"
                hide-details
                outlined
                label="Value"
              ></v-text-field>
            </v-col>
            <v-col cols="1">
              <v-btn icon color="error" @click="deleteParam(i)" class="mt-1"
                ><v-icon>fas fa-trash</v-icon></v-btn
              >
            </v-col>
          </v-row>
          <v-btn block text @click="addParam()" class="mt-2">Add Param</v-btn>
        </v-form>
        <v-tabs right v-model="devTabs">
          <v-tab>Response</v-tab>
          <v-tab>Response Data</v-tab>
          <v-tab>Request</v-tab>
        </v-tabs>
        <div v-if="inProcess">
          <v-row justify="center">
            <v-progress-circular
              indeterminate
              color="primary"
              class="my-8"
            ></v-progress-circular>
          </v-row>
        </div>
        <div v-else>
          <div v-if="devTabs === 0">
            <json-viewer
              :value="$store.state.dev.response"
              :theme="$vuetify.theme.isDark ? 'json-theme-dark' : ''"
              :expand-depth="5"
              copyable
              boxed
              sort
            ></json-viewer>
          </div>
          <div v-if="devTabs === 1 && $store.state.dev.response">
            <json-viewer
              :value="
                $store.state.dev.response.data
                  ? $store.state.dev.response.data
                  : $store.state.dev.response.response.data
              "
              :theme="$vuetify.theme.isDark ? 'json-theme-dark' : ''"
              :expand-depth="5"
              copyable
              boxed
              sort
            ></json-viewer>
          </div>
          <div v-else-if="devTabs === 2">
            <prism-editor
              v-model="requestCode"
              :highlight="highlighter"
            ></prism-editor>
          </div>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { PrismEditor } from 'vue-prism-editor'
import 'vue-prism-editor/dist/prismeditor.min.css'
import { highlight, languages } from 'prismjs/components/prism-core'
import 'prismjs/components/prism-clike'
import 'prismjs/components/prism-javascript'
import 'prismjs/themes/prism-tomorrow.css'

export default {
  data: () => ({
    inProcess: false,
    devMethod: null,
    devRoute: null,
    paramsArray: [
      { key: null, value: null, type: 'text' },
      { key: null, value: null, type: 'text' },
      { key: null, value: null, type: 'text' },
      { key: null, value: null, type: 'text' }
    ],
    rules: {
      required: (value) => !!value || 'Required'
    },
    devTabs: 0
  }),

  components: {
    PrismEditor
  },

  computed: {
    params() {
      if (this.paramsArray.length > 0) {
        let params = {}
        for (let i = 0; i < this.paramsArray.length; i++) {
          let param = this.paramsArray[i]
          if (param.key != null && param.key != '') {
            let paramObject = {}
            paramObject[param.key] = param.value
            Object.assign(params, paramObject)
          }
        }
        return params
      } else {
        return null
      }
    },

    requestCode: {
      get() {
        return `
    return new Promise((resolve, reject) => {
        axios.${this.devMethod}('${this.devRoute}', {${this.getParamsObject()}
        }).then(response => {
            resolve(response);
        }).catch(error => {
            dispatch("errors/errorHandle", error.response, {root: true});
            reject(error.response);
        });
            `
      },
      set() {}
    }
  },

  methods: {
    highlighter(code) {
      return highlight(code, languages.js)
    },

    addParam() {
      this.paramsArray.push({
        key: null,
        value: null,
        type: 'text'
      })
    },

    deleteParam(i) {
      this.paramsArray.splice(i, 1)
    },

    devTest() {
      if (this.$refs.devForm.validate()) {
        this.inProcess = true
        this.devTabs = 0
        this.$store
          .dispatch(`dev/${this.devMethod}`, {
            params: this.params,
            route: this.devRoute
          })
          .then(() => {
            this.inProcess = false
          })
          .catch(() => {
            this.inProcess = false
          })
      }
    },

    getParamsObject() {
      if (this.paramsArray.length > 0) {
        let params = ''
        for (let i = 0; i < this.paramsArray.length; i++) {
          let param = this.paramsArray[i]
          if (param.key != null && param.key != '') {
            params = `${params} \n            ${param.key}: ${param.value},`
          }
        }
        return params
      } else {
        return ''
      }
    }
  }
}
</script>

<style lang="scss">
.json-theme-dark {
  background: #1e1e1e;
  white-space: nowrap;
  color: #ffffff;
  font-size: 14px;
  font-family: Consolas, Menlo, Courier, monospace;

  .jv-ellipsis {
    color: #ffffff;
    background-color: #0e0e0e;
    display: inline-block;
    line-height: 0.9;
    font-size: 0.9em;
    padding: 0px 4px 2px 4px;
    border-radius: 3px;
    vertical-align: 2px;
    cursor: pointer;
    user-select: none;
  }
  .jv-button {
    color: #49b3ff;
  }
  .jv-key {
    color: #ffffff;
  }
  .jv-item {
    &.jv-array {
      color: #ffffff;
    }
    &.jv-boolean {
      color: #fc1e70;
    }
    &.jv-function {
      color: #067bca;
    }
    &.jv-number {
      color: #fc1e70;
    }
    &.jv-number-float {
      color: #fc1e70;
    }
    &.jv-number-integer {
      color: #fc1e70;
    }
    &.jv-object {
      color: #ffffff;
    }
    &.jv-undefined {
      color: #e08331;
    }
    &.jv-string {
      color: #42b983;
      word-break: break-word;
      white-space: normal;
    }
  }
  .jv-code {
    .jv-toggle {
      &:before {
        padding: 0px 2px;
        border-radius: 2px;
      }
      &:hover {
        &:before {
          background: #eee;
        }
      }
    }
  }
}
</style>
