<?php
$num = $_GET['num'];
$id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv=" X-UA-Compatible" content="ie=edge">
    <title>Infomation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="three.min.js"></script>
    <script src="OrbitControls.js"></script>
    <script src="OBJLoader.js"></script>
    <script src="MTLLoader.js"></script>

    <style>
        #wrap {
            /* margin: 20px 40px 10px 40px; */
            width: 380px;
            margin: 0 auto;
        }

        #title {
            margin: 0px 0px 50px 0px;
            color: #000;
            border-bottom: solid 5px #3F51B5;
            font-weight: bold;
            position: relative;
            text-align: left;

        }

        #title :after {
            position: absolute;
            content: '';
            display: bk;
            left: 0;
            bottom: -.125em;
            border-bottom: solid #F44336;
            width: 30%;
            height: 100%;
        }

        h1 {}

        h5 {
            margin: 10px 0px 0px 0px;
            float: left;
        }

        h3 {
            padding-left: 7px;
            border-left: 10px solid #9cb4a4;
        }

        #upper {
            border: 1px solid #eee;
            width: 280px;
            min-height: 180px;
            list-style: none;
            /* margin: 0px 0px 0px 0px;
            padding: 5px 5px 5px 5px; */
            border-radius: 10px;
        }

        #middle {
            border: 1px solid #eee;
            width: 380px;
            min-height: 40px;
            list-style: none;
            margin: 0px 0px 0px 0px;
            padding: 5px 5px 5px 5px;
            border-radius: 10px;
        }

        #lower {
            /* border: 1px solid #eee; */
            width: 300px;
            list-style: none;
            margin: 10px 0px 0px 0px;
            padding: 5px 5px 5px 5px;
            border-radius: 10px;
        }
    </style>

</head>

<body>
    <div id="wrap">
        <div id="title">
            <h1 id="upper_text">
            </h1>
            <h5>
                Information.
            </h5>
        </div>


        <div id="middle">
            <div id="middle_text">
            </div>
        </div>
        <div id="lower">
            <div id="lower_text">
            </div>
        </div>


    </div>

    <script>
        var num = <?php echo json_encode($num); ?> ;
        var id = <?php echo json_encode($id); ?> ;

        ///////// Import Google SpletSheet //////////
        var sheet01_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/od6/public/values?alt=json';
        var sheet02_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/onzhsga/public/values?alt=json';
        var sheet03_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/olyeb2u/public/values?alt=json';
        var sheet04_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/oi7y1ze/public/values?alt=json';
        var sheet05_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/o620ang/public/values?alt=json';
        var sheet06_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/ofeij31/public/values?alt=json';
        var sheet07_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/o4e9xts/public/values?alt=json';
        var sheet08_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/oe1jt1r/public/values?alt=json';
        var sheet09_url =
            'https://spreadsheets.google.com/feeds/cells/1il1mY1AlQnMr5z1C233ZKJWVxEkn4NplDg5WPTN70Kk/ordhs9x/public/values?alt=json';

        var sheet_num = [sheet01_url, sheet02_url, sheet03_url, sheet04_url, sheet05_url, sheet06_url, sheet07_url,
            sheet08_url, sheet09_url
        ];

        getSheet(sheet_num[num - 1], id - 1);

        function getSheet(url, id) {
            // ここは非同期処理
            fetch(url, {
                    method: "GET",
                }).then(response => response.text())
                .then(text => {
                    // ここは通信が終わったら実行される
                    const targetID = "hoge";
                    const _obj = JSON.parse(text);
                    var sheetsEntry = _obj.feed.entry; // 実データ部分を取得
                    var categorized = [];

                    for (var i = 0; i < sheetsEntry.length; i++) {
                        if (sheetsEntry[i].gs$cell.col == 1) {
                            categorized[sheetsEntry[i].gs$cell.row - 1] = [];
                        }
                        categorized[sheetsEntry[i].gs$cell.row - 1][sheetsEntry[i].gs$cell.col - 1] =
                            sheetsEntry[i]
                            .gs$cell.$t;
                    }

                    // Set list
                    const head = categorized.shift();
                    var sheet_list = [];
                    for (var b = 0; b < categorized.length; b++) {
                        var tmp = {};
                        for (var i = 0; i < head.length; i++) {
                            tmp[head[i]] = categorized[b][i];
                        }
                        sheet_list.push(tmp);
                    }


                    //Generate HTML
                    var p = document.createElement('p');
                    p.innerHTML = sheet_list[id]['Name'];
                    document.getElementById('upper_text').appendChild(p);
                    var p = document.createElement('p');
                    p.innerHTML = sheet_list[id]['A'];
                    document.getElementById('middle').appendChild(p);
                    var p = document.createElement('p');
                    p.innerHTML = sheet_list[id]['B'];
                    document.getElementById('lower_text').appendChild(p);

                    /////// Set Contents ///////
                    name_list = sheet_list[id]['D'].split('.');
                    console.log(name_list);

                    /////// Image ///////
                    if (name_list[1] == 'google') {
                        var result = sheet_list[id]['D'].replace('open', 'uc');
                        console.log(result);

                        // img要素を生成
                        var img = document.createElement('img');
                        // 画像パスを追加
                        img.src = result;
                        // altを追加
                        img.alt = '画像コンテンツ';
                        img.width = 380;

                        // 生成したimg要素を追加する
                        document.getElementById('lower').appendChild(img);

                    } else if (name_list[1] == 'obj') {
                        /////// 3D Object ///////
                        /** WebGLRendererの生成*/
                        var renderer = new THREE.WebGLRenderer({
                            antialias: true
                        });
                        //renderer.setSize(window.innerWidth, window.innerHeight);
                        renderer.setSize(380, 214);
                        renderer.setPixelRatio(window.devicePixelRatio);
                        renderer.setClearColor(0x000000, 1.0);
                        document.getElementById('lower').appendChild(renderer.domElement);

                        /** シーンの追加*/
                        var scene = new THREE.Scene();

                        /** カメラの生成*/
                        var fov = 40;
                        // var aspect = window.innerWidth / window.innerHeight;
                        var aspect = 16 / 9
                        var near = 0.1;
                        var far = 10000;
                        var camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
                        var camera_position_x0 = 0;
                        var camera_position_y0 = 0;
                        var camera_position_z0 = -180;
                        camera.position.set(camera_position_x0, camera_position_y0, camera_position_z0);
                        camera.rotation.set(0, 0, Math.PI * 0.7);

                        /* * Orbitコントローラを生成 */
                        var controls = new THREE.OrbitControls(camera, renderer.domElement);

                        /** Lightをシーンに追加*/
                        var light = new THREE.DirectionalLight(0xffffff, 0.5);
                        light.position.set(0, 30, -50);
                        scene.add(light);

                        const h_light = new THREE.HemisphereLight(0x888888, 0x0000FF, 0.5);
                        scene.add(h_light);

                        /* *環境光を追加 */
                        var ambient = new THREE.AmbientLight(0x333333, 2.0);
                        scene.add(ambient);

                        // MTLLoader
                        var mtlLoader = new THREE.MTLLoader();
                        mtlLoader.setPath("./");
                        mtlLoader.load(name_list[0] + ".mtl", function(materials) {
                            materials.preload();

                            // OBJLoader
                            var objLoader = new THREE.OBJLoader();
                            objLoader.setPath("./");
                            objLoader.setMaterials(materials);
                            objLoader.load(sheet_list[id]['D'], function(meshes) {
                                meshes.scale.set(10, 10, 10);
                                meshes.rotation.set(0, Math.PI, 0);
                                meshes.position.set(0, 0, 0);

                                scene.add(meshes);
                            });

                        });
                        /* *レンダリング */
                        function renderRender() {
                            renderer.render(scene, camera);
                            requestAnimationFrame(animate);
                        }
                        /* *アニメーション*/
                        function animate() {
                            renderRender()
                        }
                        animate();
                    } else {
                        /////// Youtube ///////
                        var result = sheet_list[id]['D'];
                        console.log(result);

                        // img要素を生成
                        var iframe = document.createElement('iframe');
                        // 画像パスを追加
                        iframe.src = result;
                        iframe.width = 380;
                        iframe.height = 214;
                        iframe.frameborder = 0

                        iframe.muted = true;
                        iframe.autoplay = true;
                        iframe.loop = true;
                        iframe.setAttribute('playsinline', '');

                        // altを追加
                        iframe.alt = '映像コンテンツ';

                        // 生成したimg要素を追加する
                        document.getElementById('lower').appendChild(iframe);

                    }


                });
        };
    </script>
</body>

</html>