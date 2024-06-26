<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultat du calcul du tarif</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<canvas id="canvas"></canvas>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="/index">Exposition Picasso</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/Oeuvres">Les œuvres</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/Infos">Informations pratiques</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/Base">Tarifs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Mentions%20légales.html">Mentions Légales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/Formulaire">Formulaire</a>
      </li>
        <li class="nav-item"><a class="nav-link" href="/Reserver">Reserver</a></li>
        <li class="nav-item">
            <a class="nav-link" href="/Reserver">Reserver</a>
        </li>
    </ul>
  </div>
</nav>
<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer les quantités de tickets pour chaque catégorie
  $normal = isset($_POST['normal']) ? intval($_POST['normal']) : 0;
  $reduit = isset($_POST['reduit']) ? intval($_POST['reduit']) : 0;
  $etudiant = isset($_POST['etudiant']) ? intval($_POST['etudiant']) : 0;
  $membre = isset($_POST['membre']) ? intval($_POST['membre']) : 0;
  $moins12 = isset($_POST['moins12']) ? intval($_POST['moins12']) : 0;

  // Définir les prix des tickets pour chaque catégorie

  $prix_normal = 32;
  $prix_reduit = 24;
  $prix_etudiant = 20;
  $prix_membre = 12;
  $prix_moins12 = 5;

  // Calculer le tarif total
  $tarif_total = ($normal * $prix_normal) + ($reduit * $prix_reduit) + ($etudiant * $prix_etudiant) + ($membre * $prix_membre) + ($moins12 * $prix_moins12);

  // Afficher le tarif total
  echo '<div class="container content-wrapper">';
  echo "<h2>Tarif total : $tarif_total €</h2>";
  echo '</div>';
}
?>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
