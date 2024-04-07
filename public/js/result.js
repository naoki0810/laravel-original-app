const addressInput = document.getElementById('addressInput').innerText;

async function initMap() {

    const geocoder = new google.maps.Geocoder(); // Googlgのサーバーと通信するためのインスタンスを生成
    geocoder.geocode(
        {
            address: addressInput, // フォームに入力された値を渡す
            region: "jp",
        },
        function (results, status) {

            console.log(results, status);

            var latlng = "";


            if (status == google.maps.GeocoderStatus.OK) {

                // 取得が成功した場合
                // 結果をループして取得します。
                for (var i in results) {
                    if (results[i].geometry) {

                        // 緯度を取得します。
                        var lat = results[i].geometry.location.lat();
                        // 経度を取得します。
                        var lng = results[i].geometry.location.lng();

                        var place = document.getElementById("name").innerText;

                        map = document.getElementById("map");

                        let LatLng = { lat: lat, lng: lng };
                        // オプションを設定
                        opt = {
                            zoom: 13, //地図の縮尺を指定
                            center: LatLng, //センターを取得した緯度経度に指定
                        };
                        // 地図のインスタンスを作成します。第一引数にはマップを描画する領域、第二引数にはオプションを指定
                        mapObj = new google.maps.Map(map, opt);

                        //   marker = new google.maps.Marker({
                        marker = new google.maps.Marker({
                            // ピンを差す位置を決めます。
                            position: LatLng,
                            // ピンを差すマップを決めます。
                            map: mapObj,
                            // ホバーしたときに場所の名前が表示されるようにします。
                            title: place,
                        });

                        // そもそも、ループを回して、検索結果にあっているものをiに入れていっているため
                        // 精度の低いものもでてきてしまう。その必要はないから、一回でbreak
                        break;
                    }
                }
            } else if (status == google.maps.GeocoderStatus.ERROR) {
                alert("サーバ接続に失敗しました。");
            } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
                alert("リクエストが無効でした。");
            } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                alert("リクエストの制限回数を超えました。");
            } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
                alert("サービスが使えない状態でした。");
            } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
                alert("原因不明のエラーが発生しました。");
            }
        }
    );
}