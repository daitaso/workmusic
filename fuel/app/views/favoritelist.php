<!--お気に入り一覧画面(view)-->
<!--役割：お気に入り一覧画面のview-->
<div class="l-site-980">

    <h1>お気に入り一覧</h1>

    <!--　動画一覧リスト（お気に入り）    -->
    <div id="favorite_list">

        <!-- vueコンポーネント（検索結果ヘッダー）       -->
        <search-result-header :start_idx="info.start_idx" :end_idx="info.end_idx" :keyword="info.keyword" :category="info.category" :show_keyword="info.show_keyword" :show_category="info.show_category"></search-result-header>

        <!-- vueコンポーネント（パネルリスト）       -->
        <div class="p-panel-list ">
            <thumb-panel
                    v-for="movie in info.movie_list"
                    v-bind:movie_id="movie.movie_id"
                    v-bind:title="movie.title"
                    v-bind:created_at="movie.created_at"
            ></thumb-panel>
        </div>

        <!-- vueコンポーネント（ページネーション）       -->
        <div class="p-pagination">
            <pagenation :pages="info.pages" :cur_page="info.cur_page" :keyword="info.keyword" :category="info.category" v-on:page-change="onPageChange"></pagenation>
        </div>
    </div>
</div>