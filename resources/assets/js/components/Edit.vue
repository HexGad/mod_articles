<template>
  <div class="card card-body">
    <div class="container">
      <div class="row mt-3 mb-3">
        <div class="col">
          <div class="form-group">
            <label class="form-label mb-0">Title</label>
            <input class="form-control form-control-solid" v-model="article.title" />
            <small class="text-danger" v-if="errors.title">{{ errors.title[0] }}</small>
          </div>
        </div>
      </div>

      <div class="row mt-3 mb-3">
        <div class="col">
          <div class="form-group">
            <label class="form-label mb-0">Category</label>
            <select class="form-select form-select-solid" v-model="article.category_id">
              <option :value="null">Please Choose ...</option>
              <option v-for="(category, id) in categories" :value="id">{{ category }}</option>
            </select>
            <small class="text-danger" v-if="errors.category_id">{{ errors.category_id[0] }}</small>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="form-label mb-0">Leads Form</label>
            <select class="form-select form-select-solid" v-model="article.form_id">
              <option :value="null">Please Choose ...</option>
              <option v-for="(form, id) in forms" :value="id">{{ form }}</option>
            </select>
            <small class="text-danger" v-if="errors.form_id">{{ errors.form_id[0] }}</small>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="form-label mb-0">Pixel</label>
            <select class="form-select form-select-solid" v-model="article.pixel_id">
              <option :value="null">Please Choose ...</option>
              <option v-for="(pixel, id) in pixels" :value="id">{{ pixel }}</option>
            </select>
            <small class="text-danger" v-if="errors.pixel_id">{{ errors.pixel_id[0] }}</small>
          </div>
        </div>
      </div>

      <div class="row mt-3 mb-3">
        <div class="d-flex justify-content-center" v-if="articleData.media.length">
          <img :src="articleData.media[0].original_url" style="width: 400px; height: auto">
        </div>
        <div class="col">
          <label class="form-label required mb-0">Cover Image</label>
          <input type="file" class="form-control form-control-solid" @change="handleFileChange">
          <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
        </div>
      </div>

      <div class="row mt-3 mb-3">
        <div class="col">
          <label class="form-label mb-0">Content</label>
          <editor v-model="article.content"></editor>
          <small class="text-danger" v-if="errors.content">{{ errors.content[0] }}</small>
        </div>
      </div>
      <div class="row mt-3 mb-3 px-3">
        <button type="button" class="btn btn-primary" @click="editArticle" :data-kt-indicator="is_loading? 'on':'off'"
                :disabled="is_loading">
          <span class="indicator-label">
              <span class="svg-icon svg-icon-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path
                      d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
              </span>
              Save
          </span>
          <span class="indicator-progress">Please wait...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Edit",
  props: ['categories', 'forms', 'pixels', 'articleData'],

  created() {
    this.article = Object.assign({}, this.articleData)
  },

  data: () => ({
    is_loading: false,
    edit_slug: false,
    article: {
      title: null,
      slug: null,
      image: null,
      category_id: null,
      form_id: null,
      pixel_id: null,
      content: null,
    },
    errors: {
      title: null,
      slug: null,
      image: null,
      category_id: null,
      form_id: null,
      pixel_id: null,
      content: null,
    }
  }),
  methods: {
    handleFileChange(event){
      this.article.image = event.target.files[0];
    },

    async editArticle() {
      this.is_loading = true;
      this.errors = {
        title: null, slug: null, image: null,
        category_id: null, form_id: null, pixel_id: null,
        content: null,
      };

      const headers = { 'Content-Type': 'multipart/form-data' };
      const formData = new FormData();
      formData.append('_method', 'PATCH')
      for (const key in this.article)
        if(this.article[key] !== null)
          formData.append(key, this.article[key]);


      await axios.post(route('dashboard.articles.update', this.articleData.id), formData, {headers}).then((res) => {
        window.location.href = route('dashboard.articles.index')
      }).catch((err) => {
        if (err.response && err.response.status === 422)
          this.errors = Object.assign(this.errors, err.response.data.errors);

        this.is_loading = false;
      });

    },
  },
}
</script>
