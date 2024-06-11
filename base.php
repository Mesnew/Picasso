<?php include 'db.config.php'?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarifs</title>

  <!-- Liens vers Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: transparent;
        }
        canvas {
            display: block;
            background: transparent;
            z-index: -1;
            top: 0;
            display: block;
            width: 100%;
            height: 100%;
            position: fixed;
        }
        #threejs-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        .content-wrapper {
            position: relative;
            z-index: 1;
            margin-top: 70px; /* Ajustez cette valeur pour ajouter de l'espacement sous la navbar */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }
    </style>
</head>
<body>
<canvas id="canvas"></canvas>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>
<script>
    // Textures
    var q = 'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjExMjU4fQ&auto=format&fit=crop&w=827&q=80';
    var e = 'https://images.unsplash.com/photo-1464802686167-b939a6910659?ixlib=rb-1.2.1&auto=format&fit=crop&w=1033&q=80';
    var p = 'https://images.unsplash.com/photo-1504333638930-c8787321eee0?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80';
    var a = 'https://images.unsplash.com/photo-1484589065579-248aad0d8b13?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=696&q=80';

    var s_group = new THREE.Group();
    var s_galax = new THREE.Group();

    function main() {
        const canvas = document.querySelector('#canvas');
        const renderer = new THREE.WebGLRenderer({canvas, antialias: true});
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(18);
        //--
        camera.near = 1;
        camera.far = 2000;
        camera.position.z = -10;
        renderer.gammaInput = true;
        renderer.gammaOutput = true;
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        //--
        const controls = new THREE.OrbitControls(camera, canvas);
        controls.target.set(0, 0, 0);
        controls.update();
        controls.enableZoom = false;
        //--
        scene.fog = new THREE.Fog(0x391809, 9, 15)
        scene.add(s_group);
        scene.add(s_galax);
        //--
        function createLights() {
            const l_ambient = new THREE.HemisphereLight( 0xFFFFFF, 0x00A1A2, 1 );
            const r_ambient = new THREE.DirectionalLight( 0x333333, 4);
            r_ambient.position.set( 5, 5, 5 );
            r_ambient.lookAt( 0, 0, 0 );
            r_ambient.castShadow = true;
            r_ambient.shadow.mapSize.width = 512;  // default
            r_ambient.shadow.mapSize.height = 512; // default
            r_ambient.shadow.camera.near = 0.5;    // default
            r_ambient.shadow.camera.far = 500;     // default
            //--
            scene.add( r_ambient );
            //scene.add( l_ambient );
        }
        //--

        function e_material(value) {
            (value==undefined) ? value = a : value = value;
            const o = new THREE.TextureLoader().load(value);
            return o;
        }

        function e_envMap() {
            const t_envMap = new THREE.TextureLoader().load(a);
            t_envMap.mapping = THREE.EquirectangularReflectionMapping;
            t_envMap.magFilter = THREE.LinearFilter;
            t_envMap.minFilter = THREE.LinearMipmapLinearFilter;
            t_envMap.encoding = THREE.sRGBEncoding;
            //---
            return t_envMap;
        }
        var c_mat, a_mes, b_mes, c_mes, d_mes;
        function createElements() {
            const a_geo = new THREE.IcosahedronBufferGeometry(1,5);
            const b_geo = new THREE.TorusKnotBufferGeometry( 0.6, 0.25, 100, 15 );
            const c_geo = new THREE.TetrahedronGeometry(1, 3);
            const d_geo = new THREE.TorusGeometry(2, 0.4, 3, 60);

            c_mat = new THREE.MeshStandardMaterial({
                envMap: e_envMap(),
                map: e_material(e),
                aoMap: e_material(e),
                bumpMap: e_material(q),
                lightMap: e_material(p),
                emissiveMap: e_material(q),
                metalnessMap: e_material(e),
                displacementMap: e_material(p),
                flatShading: false,
                roughness: 0.0,
                emissive: 0x333333,
                metalness: 1.0,
                refractionRatio: 0.94,
                emissiveIntensity: 0.1,
                bumpScale: 0.01,
                aoMapIntensity: 0.0,
                displacementScale: 0.0
            });
            a_mes = new THREE.Mesh(a_geo, c_mat);
            b_mes = new THREE.Mesh(b_geo, c_mat);
            c_mes = new THREE.Mesh(c_geo, c_mat);

            d_mes = new THREE.Mesh(d_geo, c_mat);
            d_mes.name = 'd_mes_object';

            a_mes.castShadow = a_mes.receiveShadow = true;
            b_mes.castShadow = b_mes.receiveShadow = true;
            c_mes.castShadow = c_mes.receiveShadow = true;
            d_mes.castShadow = d_mes.receiveShadow = true;

            d_mes.rotation.x = -90 * Math.PI / 180;
            d_mes.scale.z = 0.02;
            a_mes.add(d_mes);

            s_group.add(a_mes);
            s_group.add(b_mes);
            s_group.add(c_mes);

            b_mes.visible = c_mes.visible = false;
        }

        function createPoints(value, size) {
            const geometry = new THREE.BufferGeometry();
            const positions = [];
            const n = (size) ? size : 20, n2 = n / 2;
            for (let i = 0; i < ((value) ? value : 15000); i++) {
                // positions
                const x = Math.random() * n - n2;
                const y = Math.random() * n - n2;
                const z = Math.random() * n - n2;
                positions.push(x, y, z);
            }
            geometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
            geometry.computeBoundingSphere();
            //
            const material = new THREE.PointsMaterial({ size: 0.02});
            const points = new THREE.Points(geometry, material);
            s_galax.add(points);
        }

        function animation() {
            requestAnimationFrame(animation);
            let time = Date.now() * 0.003;
            s_group.rotation.y -= 0.001;
            s_group.rotation.x += 0.0005;
            s_galax.rotation.z += 0.001 / 4;
            s_galax.rotation.x += 0.0005 / 4;
            //--
            //--
            //s_group.position.y = Math.sin(time * 0.05) * 0.05;

            camera.lookAt(scene.position);
            camera.updateMatrixWorld();
            renderer.render(scene, camera);
        }

        function onWindowResize() {
            const w = window.innerWidth;
            const h = window.innerHeight;
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            renderer.setSize(w, h);
        }
        //--
        createElements();
        createPoints();
        createLights();
        onWindowResize();
        animation();
        //--
        window.addEventListener('resize', onWindowResize, false);
    }

    window.addEventListener('load', main, false);
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
<?php?>