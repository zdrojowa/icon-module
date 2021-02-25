<template>
    <div>
        <b-button v-b-modal="'modal-icon-selector-' + id" variant="primary">Wybierz ikonkę</b-button>
        <b-modal :id="'modal-icon-selector-' + id" title="Wybierz ikonkę" hide-footer>
            <b-form-group
              label="Ikonka"
            >
              <b-form-select
                  v-model="icon"
                  :options="icons"
              ></b-form-select>
            </b-form-group>
            <b-button variant="primary" @click="choose">Wybierz</b-button>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props : {
            id: {
                type: String,
                default: ''
            },
            route: {
                type: String
            }
        },

        data() {
            return {
                icons: [],
                icon: null
            }
        },

        mounted: function() {
            this.find()
        },

        methods: {
            find() {
                let self = this
                axios.get(this.route)
                .then(function(response) {
                    self.icons = []
                    self.icons.push({value: null, text: 'Bez ikonki'})
                    response.data.forEach(icon => {
                      self.icons.push({value: icon.id, text: icon.name})
                    })
                }).catch(function(error) {
                    console.log(error)
                })
            },

            choose() {
                this.$emit('icon-selected', this.icon)
            }
        }
    }
</script>
