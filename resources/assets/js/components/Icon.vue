<template>
    <div>
        <b-form @submit="save">
            <b-card header-tag="header">
                <template #header>
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </template>
                <b-card-text>
                    <b-row>
                        <b-col>
                            <b-form-group
                                label="Nazwa"
                                description="To pole musi być unikalne"
                            >
                                <b-form-input
                                    v-model="name"
                                    type="text"
                                    placeholder="Wpisz nazwe"
                                    :state="nameState"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-row v-for="lang in langs" :key="lang.id">
                              <b-col>
                                <b-form-group
                                    :label="lang.name"
                                >
                                  <b-form-input
                                      v-model="translations[lang.short_name]"
                                      type="text"
                                      placeholder="Wpisz tłumaczenie"
                                  ></b-form-input>
                                </b-form-group>
                              </b-col>
                            </b-row>
                        </b-col>
                        <b-col>
                          <selector
                              extensions="svg"
                              @media-selected="select"
                              :route="mediaSearchRoute"
                              :media-route="mediaRoute"
                          ></selector>
                          <file-view v-if="file"
                              :file="file"
                              :route="mediaRoute"
                              :show="false"
                              type="default"
                              :link="false"
                          ></file-view>
                        </b-col>
                    </b-row>
                </b-card-text>
            </b-card>
        </b-form>
    </div>
</template>

<script>
    import Selector from './../../../../../../../vendor/zdrojowa/media-module/resources/assets/js/components/Selector'
    import FileView from './../../../../../../../vendor/zdrojowa/media-module/resources/assets/js/components/FileView'
    export default {
        props : ['csrf', 'route', 'icon', 'mediaSearchRoute', 'mediaRoute', 'checkKeyRoute', 'langs'],
        components: {
            Selector,
            FileView
        },

        data() {
            return {
                name: '',
                nameState: null,
                file: null,
                translations: {}
            }
        },

        created() {
            if (this.icon) {
                this.name         = this.icon.name
                this.translations = this.icon.translations

                this.getFile()

                this.langs.forEach(lang => {
                  if (!(lang.short_name in this.translations)) {
                    this.translations[lang.short_name] = ''
                  }
                })
            }
        },

        methods: {
          getFile() {
                let self = this
                  axios.get(self.mediaSearchRoute + '?search=' + self.icon.file)
                  .then(res => {
                      self.file = res.data[0]
                  }).catch(err => {
                      console.log(err)
                  })
            },

            select(file) {
                this.file = file.file
            },

            save(e) {
                e.preventDefault()
                if (this.nameState && '_id' in this.file) {
                    let formData = new FormData()
                    formData.append('_method', this.icon ? 'PUT' : 'POST')
                    formData.append('name', this.name)
                    formData.append('file', this.file._id)
                    formData.append('translations', JSON.stringify(this.translations))

                    axios.post(this.route, formData, {
                        headers: {
                            'X-CSRF-TOKEN': this.csrf
                        }
                    })
                    .then(res => {
                        window.location = res.data.redirect
                    }).catch(err => {
                        console.log(err);
                    });
                } else {
                    return false;
                }
            },

            checkKeyUnique() {
                let route = this.checkKeyRoute + '?key=' + this.name
                if (this.icon) {
                    route += '&id=' + this.icon.id
                }
                axios.get(route)
                .then(res => {
                    this.nameState = !!res.data
                }).catch(err => {
                    console.log(err)
                })
            }
        },

        watch: {
            name() {
                if (!this.name.length) {
                    this.nameState = false
                } else {
                    this.checkKeyUnique()
                }
            }
        }
    }
</script>
