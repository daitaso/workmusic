import Vue from 'vue'
import axios from 'axios';
import moment from 'moment';

//
// お気に入り一覧画面ＪＳ
//
// 役割：お気に入り一覧画面用ＪＳ
//

//
// 検索結果ヘッダー（vueコンポーネント）
//
Vue.component('search-result-header', {
  props:['start_idx','end_idx','keyword','category','show_keyword','show_category'],
  template: `
                <h1>検索結果　{{ start_idx + 1 }}　―　{{ end_idx }} <span v-if="show_keyword">　タグ　{{keyword}}</span><span v-else-if="show_category">　カテゴリー　{{category}}</span></h1>
            `
})

//
// サムネイルパネル（vueコンポーネント）
//
Vue.component('thumb-panel', {
  props:['movie_id','title','created_at'],
  computed: {
    fromNow: function (){
      var date = this.created_at;
      moment.locale( 'ja' );
      return moment(date, 'YYYY/MM/DD HH:mm:S').fromNow();
    }
  },
  template: `
                    <a :href="'moviedetail.php?movie_id=' + movie_id " class="p-panel-list__panel">
                        <img class ="p-panel-list__panel__img" :src="'./assets/img/thumb/' + movie_id + '.jpg'" :alt="title">
                        <p class="p-panel-list__panel__title">{{title}}</p>
                        <span class="p-panel-list__panel__fromnow">{{this.fromNow}}</span>
                    </a>
                  `
})

//
// ページネーション（vueコンポーネント）
//
Vue.component('pagenation', {
  props:['pages','keyword','cur_page','category'],
  computed: {
    createPushClass : function () {
      let cur_page = this.cur_page
      self = this;
      return function (page) {
        if(Number(page) === Number(cur_page)){
          return 'p-pagination__list__list-item__button--select'
        }
        return '';
      };
    }
  },
  template: `
                <ul class="p-pagination__list">
                    <li class="p-pagination__list__list-item" v-for="page in pages">
                        <button class="p-pagination__list__list-item__button" :class="createPushClass(page)" v-on:click="$emit('page-change',page,keyword,category)">{{page}}</button>
                    </li>
                </ul>
             `
})

//
// ルートvueインスタンス（お気に入り一覧）
//
new Vue({
  el: '#favorite_list',
  data () {
    return {
      info: null,
      flg: false
    }
  },
  methods: {
    onPageChange: function (page) {
      axios
          .get( 'api/movies/list.json?page=' + page + '&favorite=on')
          .then(response => {
            this.info = response.data
            this.flg = true
          })
    }
  },
  mounted () {

    this.onPageChange(1)
  }

})

