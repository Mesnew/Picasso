<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three.js Scene</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto+Condensed');

        html, body {
            padding: 0;
            margin: 0;
            height: 100%;
            overflow: hidden;
            font-family: 'Roboto Condensed', sans-serif;
        }

        canvas {
            display: block;
        }

        #threejs-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/index">Exposition Picasso</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="/Oeuvres">Les œuvres</a></li>
            <li class="nav-item"><a class="nav-link" href="/Infos">Informations pratiques</a></li>
            <li class="nav-item"><a class="nav-link" href="/Base">Tarifs</a></li>
            <li class="nav-item"><a class="nav-link" href="/Mentions">Mentions Légales</a></li>
            <li class="nav-item"><a class="nav-link" href="/Formulaire">Formulaire</a></li>
        </ul>
    </div>
</nav>

<canvas id="scene"></canvas>

<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/three.min.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/shaders/CopyShader.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/postprocessing/ShaderPass.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/shaders/LuminosityHighPassShader.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/postprocessing/EffectComposer.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/postprocessing/UnrealBloomPass.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/postprocessing/RenderPass.js"></script>
<script src="https://threejsfundamentals.org/threejs/resources/threejs/r105/js/postprocessing/ShaderPass.js"></script>

<script id="vertexShader" type="x-shader/x-vertex">
    attribute vec3 color;
    attribute float size;
    varying vec3 vColor;
    void main() {
      vColor = color;
      vec4 mvPosition = modelViewMatrix * vec4( position, 1.0 );
      gl_PointSize = size * ( 800.0 / -mvPosition.z );
      gl_Position = projectionMatrix * mvPosition;
    }
</script>
<script id="fragmentShader" type="x-shader/x-fragment">
    varying vec3 vColor;
    void main() {
      float distanceToCenter = distance(gl_PointCoord, vec2(0.5)) * 2.0;
      float distanceToCenterAlpha = 1.0 - clamp(distanceToCenter, 0.0, 1.0);
      distanceToCenterAlpha = pow(distanceToCenterAlpha, 2.0);
      gl_FragColor = vec4( vColor, distanceToCenterAlpha );
    }
</script>
<script id="sphereVertexShader" type="x-shader/x-vertex">
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
    }
</script>
<script id="sphereFragmentShader" type="x-shader/x-fragment">
    varying vec2 vUv;
    uniform float time;

    void main() {
        vec2 st = vUv;

        vec3 color1 = vec3(25./255., 31./255., 30./255.);
        vec3 color2 = vec3(16./255., 21./255., 21./255.);

        float mixValue = distance(smoothstep(0.4, 1., vUv.y),1.);
        vec3 color = mix(color1,color2,mixValue);

        gl_FragColor = vec4(color,mixValue);
    }
</script>
<script id="fogVertexShader" type="x-shader/x-vertex">
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
    }
</script>
<script id="fogFragmentShader" type="x-shader/x-fragment">
    varying vec2 vUv;
    uniform float time;
    float rand(vec2 n) {
        return fract(sin(dot(n, vec2(12.9898, 4.1414))) * 43758.5453);
    }

    float noise(vec2 p){
        vec2 ip = floor(p);
        vec2 u = fract(p);
        u = u*u*(3.0-2.0*u);

        float res = mix(
            mix(rand(ip),rand(ip+vec2(1.0,0.0)),u.x),
            mix(rand(ip+vec2(0.0,1.0)),rand(ip+vec2(1.0,1.0)),u.x),u.y);
        return res*res;
    }
    const mat2 mtx = mat2( 0.80,  0.60, -0.60,  0.80 );

    float fbm( vec2 p )
    {
        float f = 0.0;

        f += 0.500000*noise( p + time  ); p = mtx*p*2.02;
        f += 0.031250*noise( p ); p = mtx*p*2.01;
        f += 0.250000*noise( p ); p = mtx*p*2.03;
        f += 0.125000*noise( p ); p = mtx*p*2.01;
        f += 0.062500*noise( p ); p = mtx*p*2.04;
        f += 0.015625*noise( p + sin(time) );

        return f/0.96875;
    }
    float pattern(vec2 p )
    {
        return fbm( p + fbm( p + fbm( p ) ) );
    }

    void main() {
        vec2 st = vUv;

        vec3 color1 = vec3(16./255., 21./255., 21./255.);
        vec3 color2 = vec3(142./255.,142./255.,92./255.);

        float mixValue = distance(vUv.y,1.);
        vec3 color = mix(color1,color2,mixValue);

        gl_FragColor = vec4(color * pattern(vUv), mixValue * .625);
    }
</script>

<script>
    const API = {
        exposure: 1.208,
        bloomStrength: 1,
        bloomThreshold: 0.5,
        bloomRadius: 0.24
    };
    var startTime = Date.now();
    var treetexture = new THREE.TextureLoader().load(
        "https://raw.githubusercontent.com/trinketmage/trinketmage.github.io/master/static/the-forest/oldtree.png"
    );
    var worldWidth = 256,
        worldDepth = 256,
        worldHalfWidth = worldWidth / 2,
        worldHalfDepth = worldDepth / 2;
    var matrix = new THREE.Matrix4();
    var quaternion = new THREE.Quaternion();

    class App {
        constructor({ container, caption }) {
            this.caption = caption;
            this.sizes = {
                width: document.body.offsetWidth,
                height: document.body.offsetHeight,
                halfWidth: document.body.offsetWidth * 0.5,
                halfHeight: document.body.offsetHeight * 0.5
            };
            this.currentName = null;
            this.mouse = new THREE.Vector2(0.15625, 0.15625);
            this.target = new THREE.Vector2(this.mouse.x, this.mouse.y);
            this.renderer = new THREE.WebGLRenderer({
                canvas: container,
                alpha: false,
                stencil: false,
                depth: false,
                powerPreference: "high-performance",
                antialias: true
            });
            this.renderer.shadowMap.enabled = true;
            this.scene = new THREE.Scene();
            this.camera = new THREE.PerspectiveCamera(
                75,
                this.sizes.width / this.sizes.height,
                0.1,
                1000
            );
            this.camera.rotation.order = "YXZ";
            this.wagon = new THREE.Object3D();
            this.camera.position.set(0, 1, 6.25);
            this.wagon.add(this.camera);
            this.camera.lookAt(0, 3.125, 0);
            this.scene.add(this.wagon);
            this.setSphereMap();
            this.setGround();
            this.setLight();
            this.setTrees();
            this.setFog();
            this.setPasses();
            this.setMain();
            this.render();
            window.addEventListener("resize", () => this.handleResize(), {
                passive: true
            });
            window.addEventListener("mousemove", e => this.handleMousemove(e), false);
        }
        setSphereMap() {
            var geometry = new THREE.SphereGeometry(925, 32, 32);
            this.sphereMaterial = new THREE.ShaderMaterial({
                uniforms: {
                    time: { type: "f", value: 1.0 }
                },
                vertexShader: document.getElementById("sphereVertexShader").textContent,
                fragmentShader: document.getElementById("sphereFragmentShader")
                    .textContent,
                side: THREE.BackSide
            });
            var sphere = new THREE.Mesh(geometry, this.sphereMaterial);
            sphere.position.y = 0;
            this.scene.add(sphere);
        }
        setGround() {
            var geometry = new THREE.PlaneBufferGeometry(
                256,
                256,
                1,
                1
            );
            geometry.rotateX(-Math.PI * 0.5);
            var material = new THREE.MeshBasicMaterial({
                color: 0x000000
            });
            var plane = new THREE.Mesh(geometry, material);
            plane.position.y = 0;
            this.scene.add(plane);
        }
        setLight() {
            var geometry = new THREE.SphereGeometry(3, 32, 32);
            var material = new THREE.MeshBasicMaterial({ color: 0xffef4e });
            var sphere = new THREE.Mesh(geometry, material);
            sphere.position.y = 30;
            sphere.position.z = -30;
            this.scene.add(sphere);
            this.setStars();
        }
        setStars() {
            var particles = 500;
            var geometry = new THREE.BufferGeometry();
            var positions = [];
            var colors = [];
            var sizes = [];
            var n = 1000,
                n2 = n / 2;
            for (var i = 0; i < particles; i++) {
                var x = Math.random() * n - n2;
                var y = Math.random() * n - n2;
                var z = -Math.random() * n;
                positions.push(x, y, z);
                var s = Math.pow(Math.random(), 12.0);
                sizes.push(1);
                const c = new THREE.Color("#ffffff");
                colors.push(c.r, c.g, c.b);
            }
            geometry.setAttribute(
                "position",
                new THREE.Float32BufferAttribute(positions, 3)
            );
            geometry.setAttribute("color", new THREE.Float32BufferAttribute(colors, 3));
            geometry.setAttribute("size", new THREE.Float32BufferAttribute(sizes, 1));
            var material = new THREE.ShaderMaterial({
                transparent: true,
                depthWrite: false,
                uniforms: {
                    uColor: { type: "v3", value: new THREE.Color(0xffffff) },
                    uAlpha: { value: 1.0 }
                },
                vertexShader: document.getElementById("vertexShader").textContent,
                fragmentShader: document.getElementById("fragmentShader").textContent
            });
            this.stars = new THREE.Points(geometry, material);
            this.scene.add(this.stars);
        }
        setTrees() {
            const size = 20;
            var geometry = new THREE.PlaneBufferGeometry(size, size, 1, 1);
            var material = new THREE.MeshBasicMaterial({
                map: treetexture,
                transparent: true,
                depthWrite: false,
                depthTest: false
            });
            var treeprefab = new THREE.Mesh(geometry, material);
            const trees = [
                {
                    position: new THREE.Vector3(5, size * 0.5 - 0.3125, -6),
                    scale: new THREE.Vector3(1, 1, 0.1)
                },
                {
                    position: new THREE.Vector3(-5, size * 0.5 - 0.3125, -5),
                    scale: new THREE.Vector3(-1, 1, 0.1)
                }
            ];
            trees.forEach(tree => {
                var plane = treeprefab.clone();
                plane.position.copy(tree.position);
                plane.scale.copy(tree.scale);
                this.scene.add(plane);
            });
            for (let i = 0; i < 60; i++) {
                var plane = treeprefab.clone();
                const x = Math.random() * 100 - 50;
                const z = Math.random() * 20 - 40;
                plane.position.copy(new THREE.Vector3(x, size * 0.5 - 0.3125, z));

                plane.scale.copy(
                    new THREE.Vector3(Math.round(Math.random()) * 2 - 1, 1, 1)
                );
                this.scene.add(plane);
            }
            for (let i = 0; i < 40; i++) {
                var plane = treeprefab.clone();
                const x = Math.random() * 40 + 6;
                const z = Math.random() * -25 + 5;
                plane.position.copy(new THREE.Vector3(x, size * 0.5 - 0.3125, z));

                plane.scale.copy(
                    new THREE.Vector3(Math.round(Math.random()) * 2 - 1, 1, 1)
                );
                this.scene.add(plane);
            }
            for (let i = 0; i < 40; i++) {
                var plane = treeprefab.clone();
                const x = Math.random() * -40 - 6;
                const z = Math.random() * -25 + 5;
                plane.position.copy(new THREE.Vector3(x, size * 0.5 - 0.3125, z));

                plane.scale.copy(
                    new THREE.Vector3(Math.round(Math.random()) * 2 - 1, 1, 1)
                );
                this.scene.add(plane);
            }
        }
        setFog() {
            const h = 4
            var geometry = new THREE.PlaneBufferGeometry(
                30,
                h,
                worldWidth - 1,
                worldDepth - 1
            );
            this.renderedMaterial = new THREE.ShaderMaterial({
                uniforms: {
                    time: { type: "f", value: 1.0 }
                },
                vertexShader: document.getElementById("fogVertexShader").textContent,
                fragmentShader: document.getElementById("fogFragmentShader")
                    .textContent,
                transparent: true
            });
            var plane = new THREE.Mesh(geometry, this.renderedMaterial);
            plane.position.y =  h * .5;
            plane.position.z = 3.5;
            this.wagon.add(plane);
        }

        setPasses() {
            this.renderScene = new THREE.RenderPass(this.scene, this.camera);
            this.bloomPass = new THREE.UnrealBloomPass(
                new THREE.Vector2(this.sizes.width, this.sizes.hegiht),
                1.5,
                0.4,
                0.85
            );
            this.bloomPass.threshold = API.bloomThreshold;
            this.bloomPass.strength = API.bloomStrength;
            this.bloomPass.radius = API.bloomRadius;
            this.composer = new THREE.EffectComposer(this.renderer);
            this.composer.setSize(window.innerWidth, window.innerHeight);
            this.composer.addPass(this.renderScene);
            this.composer.addPass(this.bloomPass);
        }
        handleMousemove(e) {
            e.preventDefault();
            this.mouse.x = e.pageX / this.sizes.width * 2 - 1;
            this.mouse.y = -(e.pageY / this.sizes.height) * 2 + 1;
            this.target.x = 0.3125 * this.mouse.x;
            this.target.y = 0.09765625 * this.mouse.y;
        }
        getScreenXY(position) {
            const { halfWidth, halfHeight } = this.sizes;
            var vector = position.clone();
            this.camera.updateProjectionMatrix();
            vector.project(this.camera);
            return vector;
        }
        render() {
            requestAnimationFrame(() => this.render());

            var elapsedMilliseconds = Date.now() - startTime;
            var elapsedSeconds = elapsedMilliseconds / 1000000.;
            this.renderedMaterial.uniforms.time.value = 60. * elapsedSeconds;
            this.wagon.rotation.y += (this.target.x - this.wagon.rotation.y) * 0.04;
            this.composer.render();
        }
        setMain() {
            this.renderer.setSize(this.sizes.width, this.sizes.height);
            this.composer.setSize(this.sizes.width, this.sizes.height);
            this.camera.aspect = this.sizes.width / this.sizes.height;
            this.camera.updateProjectionMatrix();
        }
        handleResize() {
            this.sizes.width = document.body.offsetWidth;
            this.sizes.height = document.body.offsetHeight;
            this.sizes.halfWidth = this.sizes.width * 0.5;
            this.sizes.halfHeight = this.sizes.height * 0.5;
            this.setMain();
        }
    }
    const app = new App({
        container: document.body.querySelector("#scene")
    });
</script>
</body>
</html>
