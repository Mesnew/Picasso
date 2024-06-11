<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nébuleuse</title>
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
    </style>
</head>
<body>
<div id="threejs-container"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script>
    // Initialisation de la scène
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    var renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0); // Assure la transparence
    document.getElementById('threejs-container').appendChild(renderer.domElement);

    // Contrôles d'orbite
    var controls = new THREE.OrbitControls(camera, renderer.domElement);

    // Création des étoiles
    function createStars() {
        var geometry = new THREE.BufferGeometry();
        var vertices = [];

        for (var i = 0; i < 5000; i++) {
            var x = THREE.MathUtils.randFloatSpread(2000);
            var y = THREE.MathUtils.randFloatSpread(2000);
            var z = THREE.MathUtils.randFloatSpread(2000);
            vertices.push(x, y, z);
        }

        geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
        var material = new THREE.PointsMaterial({ color: 0xffffff });
        var points = new THREE.Points(geometry, material);
        scene.add(points);
    }

    createStars();

    // Création de la nébuleuse
    function createNebula() {
        var textureLoader = new THREE.TextureLoader();
        var texture = textureLoader.load('https://threejsfundamentals.org/threejs/resources/images/nebula.jpg');
        var material = new THREE.SpriteMaterial({ map: texture, color: 0xffffff, transparent: true });
        var sprite = new THREE.Sprite(material);
        sprite.scale.set(500, 500, 1);
        scene.add(sprite);
    }

    createNebula();

    camera.position.z = 1000;

    // Fonction d'animation
    var animate = function () {
        requestAnimationFrame(animate);

        controls.update();
        renderer.render(scene, camera);
    };

    animate();
</script>
</body>
</html>
