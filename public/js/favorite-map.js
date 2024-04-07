// viewファイルよりお気に入り店舗の情報を取得している
let markerData = Laravel.favorite_shops;
let marker = [];

// googleMapsAPIを持ってくるときに,callback=initMapと記述しているため、initMap関数を作成
async function initMap() {

  // welcome.blade.phpで描画領域を設定するときに、id=mapとしたため、その領域を取得し、mapに格納します。
  map = document.getElementById("map");

  async function setLocation(pos) {

    // 現在の緯度・経度を取得
    const currentLat = pos.coords.latitude;
    const currentLng = pos.coords.longitude;

    // 現在の緯度経度を代入
    let currentLocation = { lat: currentLat, lng: currentLng };

    map = document.getElementById("map");

    // オプションを設定
    opt = {
      zoom: 11, //地図の縮尺を指定
      center: currentLocation, //センターを取得した緯度経度に指定
    };

    // 地図のインスタンスを作成します。第一引数にはマップを描画する領域、第二引数にはオプションを指定
    mapObj = new google.maps.Map(map, opt);

    let marker = new Array();
    // 複数のピンを作成する
    for (let i = 0; i < markerData.length; i++) {

      let place = markerData[i]['name'];
      console.log(place);

      const geocoder = new google.maps.Geocoder(); // Googlgのサーバーと通信するためのインスタンスを生成
      geocoder.geocode(
        {
          address: markerData[i]['address'], // 住所から緯度経度に変換
          region: "jp",
        },
        async function (results, status) {
          console.log(place);

          if (status == google.maps.GeocoderStatus.OK) {

            // 取得が成功した場合
            // 結果をループして取得します。
            for (let j in results) {
              if (results[j].geometry) {

                // 緯度を取得します。
                let lat = results[j].geometry.location.lat();
                // 経度を取得します。
                let lng = results[j].geometry.location.lng();

                let markerLatLng = new google.maps.LatLng({ lat: lat, lng: lng }); // 緯度経度のデータ作成  

                marker[i] = new google.maps.Marker({
                  // ピンを差す位置を決めます。
                  position: markerLatLng,
                  // ピンを差すマップを決めます。
                  map: mapObj,
                  title: place,
                });

                // そもそも、ループを回して、検索結果にあっているものをiに入れていっているため
                // 精度の低いものもでてきてしまう。その必要はないから、一回でbreak
                break;
              }
            }
          } else if (status == google.maps.GeocoderStatus.ERROR) {
            console.log("サーバ接続に失敗しました。");
          } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
            console.log("リクエストが無効でした。");
          } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            console.log("リクエストの制限回数を超えました。");
          } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
            console.log("サービスが使えない状態でした。");
          } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
            console.log("原因不明のエラーが発生しました。");
          }
        }
      );
    }
  }

  // エラー時に呼び出される関数
  function showErr(err) {
    switch (err.code) {
      case 1:
        console.log("位置情報の利用が許可されていません");
        break;
      case 2:
        console.log("デバイスの位置が判定できません");
        break;
      case 3:
        console.log("タイムアウトしました");
        break;
      default:
        console.log(err.message);
    }
  }

  // geolocation に対応しているか否かを確認
  if ("geolocation" in navigator) {
    let opt = {
      "enableHighAccuracy": true,
      "timeout": 10000,
      "maximumAge": 0,
    };
    navigator.geolocation.getCurrentPosition(setLocation, showErr, opt);
  } else {
    console.log("ブラウザが位置情報取得に対応していません");
  }

}



