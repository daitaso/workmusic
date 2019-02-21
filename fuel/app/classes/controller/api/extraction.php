<?php
//
// 動画サイト情報抽出ＡＰＩ
//
// 役割：下記URLのHTMLを解析し、動画情報（動画ＩＤ、サムネ、タイトル、検索タグ、共有タグ）を抽出し、ＤＢに格納する
//
// 対象URL
//   YOUTUBE
//

define('YOUTUBE_API_KEY', 'AIzaSyCPbvUE5ltej2yFpgjyF1Ku3wt-1niGPtA'); // APIキー (Google Developer Consoleから取得したものをセットしてください)
function json_get($url, $query = array(), $assoc = false) { // JSONデータ取得用
    if ($query) $url .= ('?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986));

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url); // URL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // リクエスト先が https の場合、証明書検証をしない (環境によって動作しない場合があるため)
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // curl_exec() 経由で応答データを直接取得できるようにする
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); // 接続タイムアウトの秒数
    $responseString = curl_exec($curl); // 応答データ取得
    curl_close($curl);
    return ($responseString !== false) ? json_decode($responseString, $assoc) : false;
}
function h($value, $encoding = 'UTF-8') { return htmlspecialchars($value, ENT_QUOTES, $encoding); } // HTMlエスケープ出力用
function eh($value, $encoding = 'UTF-8') { echo h($value, $encoding); } // 同上

class Controller_Api_Extraction extends Controller_Rest{

    public function get_list(){

        $response = json_get('https://www.googleapis.com/youtube/v3/search', array(
            'key' => YOUTUBE_API_KEY,
//            'channelId' => 'UCHkm57ZjExicHc630M2xJ-Q', // チャンネルID (チャンネルで絞り込む場合)
             'q' => 'WorkMusic', // 検索キーワード (キーワードで絞り込む場合)
            'part' => 'snippet', // 取得するデータの種類 (タイトルや画像を含める場合はsnippet)
            'order' => 'date', // 日時降順
            'maxResults' => 50, // 検索数 (5～50)
            'type' => 'video', // 結果の種類 (channel,playlist,video)
        ), true);
        if ($response === false || isset($response['error'])) {
        }elseif (count($response['items']) == 0) {
        }else {
            foreach ($response['items'] as $item) {
                $title = $item['snippet']['title'];
                $img_url = $item['snippet']['thumbnails']['medium']['url']; // 画像情報 (default, medium, highの順で画像が大きくなります)
                $id = $item['id']['videoId'];

                $t = new DateTime($item['snippet']['publishedAt']);
                $t->setTimeZone(new DateTimeZone('Asia/Tokyo'));
                $publishedAt = $t->format('Y/m/d H:i:s'); // 投稿日時 (日本時間)

                $context = stream_context_create(array(
                    'http' => array('ignore_errors' => true)
                ));
                $img = file_get_contents($img_url,false,$context);
                file_put_contents('./assets/img/thumb/' .$id.'.jpg' , $img);

                try{

                    $query = DB::insert('movies');
                    $query->set(array(
                        'site_id'  => 'YOUTUBE',
                        'movie_id' => $id,
                        'embed_tag'    => 'koko',
                        'title'    => $title,
                        'created_at' => $publishedAt));
                    $query->execute();
                    $query->reset();

                }catch (Exception $e){
                    Log::info('ExtractionAPI YOUTUBE Excepiton');
                }
            }
        }
        return ;
    }
}
?>