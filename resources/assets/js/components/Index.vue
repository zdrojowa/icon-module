<template>
    <b-card no-header>
      <b-card-text class="grid">
        <div v-for="(item, i) in icons" :key="i" class="column-flex">
          <b-button :href="edit(item.icon.id)" variant="primary">
            <b-icon-pencil></b-icon-pencil>
          </b-button>
          <file-view
              :file="item.file"
              :route="mediaRoute"
              :show="false"
              type="default"
              :link="false"
          ></file-view>
          <b-button type="button" @click="remove(i)" variant="danger">
            <b-icon-trash></b-icon-trash>
          </b-button>
        </div>
      </b-card-text>
    </b-card>
</template>

<script>
import FileView from './../../../../../media-module/resources/assets/js/components/FileView'
export default {
  props: ['items', 'mediaRoute', 'mediaSearchRoute', 'editRoute', 'removeRoute', 'csrf'],

  components: {
    FileView
  },

  data() {
    return {
      icons: []
    }
  },

  methods: {
    edit(icon) {
      return this.editRoute.replace('id', icon)
    },

    remove(i) {
      let self = this
      this.$bvModal.msgBoxConfirm('Czy jesteś pewny?', {
        title: 'Usunąć ikonkę',
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: 'Tak',
        cancelTitle: 'Nie',
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true
      })
      .then(value => {
        if (value) {
          let route = self.removeRoute.replace('id', self.icons[i].icon.id)
          axios.delete(route, {
            headers: {
              'X-CSRF-TOKEN': self.csrf
            }
          })
          .then(function(response) {
            self.icons.splice(i, 1)
          }).catch(function(error) {
            console.log(error)
          })
        }
      })
      .catch(err => {
        console.log(err)
      })
      this.$emit('remove', i)
    }
  },

  watch: {
    items() {
      let self = this
      self.icons = []
      this.items.forEach(icon => {
        axios.get(self.mediaSearchRoute + '?search=' + icon.file)
          .then(res => {
            if (0 in res.data) {
                self.icons.push({file: res.data[0], icon: icon})
            }
          }).catch(err => {
          console.log(err)
        })
      })
    }
  }
}
</script>