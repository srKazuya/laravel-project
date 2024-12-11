<script>
export default {
  data() {
    return {
      msg: null,
      articleUrl: null,
      showToast: false,
    };
  },
  created() {
    window.Echo.channel('test').listen('NewArticleEvent', (article) => {
      console.log(article);
      this.msg = `Новая статья: ${article.article.name}`;
      this.articleUrl = `/article/${article.article.id}`; // Формируем ссылку на статью
      this.showToast = true;
      setTimeout(() => {
        this.showToast = false;
      }, 3000);
    });
  },
};
</script>


<template>
  <div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;" v-if="showToast">
      <div class="toast show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <a :href="articleUrl" class="text-white text-decoration-underline">
              {{ msg }}
            </a>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" aria-label="Close"
            @click="showToast = false"></button>
        </div>
      </div>
    </div>
  </div>
</template>


<style></style>
