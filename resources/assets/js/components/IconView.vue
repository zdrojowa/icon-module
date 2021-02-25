<template>
    <div>
      <b-img
          v-if="icon"
          :src="mediaRoute + icon.file"
      />
      <span v-else>Bez ikonki</span>
    </div>
</template>

<script>
    export default {
        props : ['id', 'route', 'mediaRoute'],

        data() {
            return {
                icon: null
            }
        },

        mounted: function() {
            if (this.id) {
              this.find()
            }
        },

        methods: {
            find() {
              let self = this
              if (this.id) {
                axios.get(this.route + '?id=' + this.id)
                    .then(function (response) {
                      self.icon = response.data
                    }).catch(function (error) {
                  console.log(error)
                })
              } else {
                this.icon = null
              }
            }
        },

        watch: {
            id() {
              this.find()
            }
        }
    }
</script>
