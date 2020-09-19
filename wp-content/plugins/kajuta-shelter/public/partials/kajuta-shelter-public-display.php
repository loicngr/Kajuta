<?php
/**
 * Fournir une vue du front-office pour le plugin
 *
 * @since      1.0.0
 *
 * @package    Kajuta_Shelter
 * @subpackage Kajuta_Shelter/public/partials
 */

function getShelters(): void
{
    $args = [
        'numberposts' => 3,
        'post_type' => 'kajuta_shelter',
    ];

    $shelters = get_posts($args);
    $cpt = 0;

    if (!empty($shelters)):
        foreach ($shelters as $shelter):
            $shelterId = intval($shelter->ID);
            $shelter3D = get_field("3d_file", $shelterId);

            $shelter3D_url = esc_url($shelter3D['url']);
            $shelterImage = esc_url(get_the_post_thumbnail_url($shelterId));
            $shelterContent = sanitize_text_field($shelter->post_content);
            $shelterTitle = sanitize_text_field($shelter->post_title);

            $htmlContent = "";

            if ($cpt === 0) {
                $htmlContent = "<div class=\"carousel-item active\" data-3d_file=\"$shelter3D_url\">";
            } else {
	            $htmlContent = "<div class=\"carousel-item\" data-3d_file=\"$shelter3D_url\">";
            }

	        $htmlContent = $htmlContent . "
                        <img src=\"$shelterImage\" class=\"d-block w-100\" alt=\"$shelterTitle\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h5>$shelterTitle</h5>
                            <p>$shelterContent</p>
                        </div>
                        <div class='carousel-btn'>
                            <button 
                                type='button' 
                                data-file-name='$shelterTitle'
                                data-file-url='$shelter3D_url'
                            >3D</button>
                        </div>
                    </div>";

            echo $htmlContent;

            $cpt++;
        endforeach;
    else:
        echo "Aucun abris trouvés.";
    endif;
} ?>
<div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel">
	<div class="carousel-inner">
		<?php getShelters(); ?>
	</div>
	<a class="carousel-control-prev" href="#carouselFade" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselFade" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>


<script type="module">
    import * as THREE from 'https://unpkg.com/three@0.118.3/build/three.module.js';
    import { OrbitControls } from 'https://unpkg.com/three@0.118.3/examples/jsm/controls/OrbitControls.js';
    import { GLTFLoader } from 'https://unpkg.com/three@0.118.3/examples/jsm/loaders/GLTFLoader.js';


    /**
     * Récupère tous les boutons "3D" dans le DOM
     *
     * @return {Promise<unknown>}
     */
    async function getCarouselBtns() {
        let cpt = 0;

        /**
         * On boucle tant que nous avons pas récupéré les boutons dans le DOM
         * (Le Dom peut ne pas être encore totalement chargé)
         */
        return new Promise((res, rej) => {
           let inter_instance = setInterval(() => {
               const carouselBtns = document.querySelectorAll('.carousel-btn button');
               if (carouselBtns) {
                   clearInterval(inter_instance);
                   inter_instance = null;
                   return res(carouselBtns);
               }

               if (cpt > 5000) {
                   /**
                    * Si la boucle dur trop longtemps, on stop tout
                    * */
                   clearInterval(inter_instance);
                   inter_instance = null;
                   return rej();
               }

               cpt ++;
           }, 100);
        });
    }

    function scrollToThree() {
        const parentElement = document.querySelector('.preview_file_bloc');
        if (!parentElement) return;

        window.scrollBy({
            top: parentElement.scrollHeight - 75,
            left: 0,
            behavior: 'smooth'
        });
    }

    function scrollToCarousel(previewHeight) {
        const parentElement = document.querySelector('#section-products');
        if (!parentElement) return;

        window.scrollBy({
            top: - ((previewHeight + parentElement.scrollHeight) / 2),
            left: 0,
            behavior: 'smooth'
        });
    }

    /**
     * Partie qui génère la vue Three
     *
     * @param {string} fileUrl
     * */
    function loadThreeJs(fileUrl) {
        let container, controls;
        let camera, scene, renderer;

        const parentElement = document.querySelector('.preview_file_bloc');

        init();
        render();

        /**
         * Retourne la longueur de l'écran
         * */
        function getScreenWidth() {
            const innerWidth = parseInt(window.innerWidth);
            let subs = 0;

            if (innerWidth > 1700) subs = 600;
            else if (innerWidth > 1000 && innerWidth < 1700) subs = 400;
            else if (innerWidth < 1000 && innerWidth > 500) subs = 200;
            else subs = 80;

            return innerWidth - subs;
        }

        /**
         * Retourne la hauteur de l'écran
         **/
        function getScreenHeight() {
            const innerHeight = parseInt(window.innerHeight);
            return innerHeight - 100;
        }

        /**
         * Initialise ThreeJs
         * */
        function init() {

            container = document.createElement( 'div' );
            container.style.position = 'relative';

            /**
             * Bouton pour fermer la prévisualisation 3D
             * */
            const btnClose = document.createElement('button');
            btnClose.addEventListener('click', deletePreviewBloc);
            btnClose.classList.add("threeCloseBtn");
            btnClose.innerText = 'X';


            container.appendChild(btnClose);


            parentElement.appendChild( container );

            camera = new THREE.PerspectiveCamera( 45, getScreenWidth() / getScreenHeight(), 1, 10000 );
            camera.position.set( 800, 600, 800 );


            scene = new THREE.Scene();
            scene.background = new THREE.Color( 0xa0a0a0 );
            scene.fog = new THREE.Fog( 0xa0a0a0, 10, 50 );

            /**
             * Lumières
             * */
            const hemiLight = new THREE.HemisphereLight( 0xffffff, 0x444444 );
            hemiLight.position.set( 0, 20, 0 );
            scene.add( hemiLight );

            const dirLight = new THREE.DirectionalLight( 0xffffff );
            dirLight.position.set( - 3, 10, - 10 );
            dirLight.castShadow = true;
            dirLight.shadow.camera.top = 2;
            dirLight.shadow.camera.bottom = - 2;
            dirLight.shadow.camera.left = - 2;
            dirLight.shadow.camera.right = 2;
            dirLight.shadow.camera.near = 0.1;
            dirLight.shadow.camera.far = 40;
            scene.add( dirLight );


            /**
             * Sol
             * */
            const mesh = new THREE.Mesh( new THREE.PlaneBufferGeometry( 100, 100 ), new THREE.MeshPhongMaterial( { color: 0x999999, depthWrite: false } ) );
            mesh.rotation.x = - Math.PI / 2;
            mesh.receiveShadow = true;
            scene.add( mesh );


            /**
             * On va récupérer le fichier 3d pour le charger dans Three
             * */
            const loaderGLTF = new GLTFLoader();
            loaderGLTF.load( fileUrl, function ( gltf ) {
                scene.add( gltf.scene );
                carouselLoader(false);
                render();
            }, undefined, function ( error ) {
                console.error( error );
                carouselLoader(false);
                alert("Impossible d'afficher le modèle 3D.");
            });

            /**
             * Rendu WebGL
             * */
            renderer = new THREE.WebGLRenderer( { antialias: true } );
            renderer.setPixelRatio( window.devicePixelRatio );
            renderer.setSize( getScreenWidth(), getScreenHeight() );
            renderer.toneMapping = THREE.ACESFilmicToneMapping;
            renderer.toneMappingExposure = 1;
            renderer.outputEncoding = THREE.sRGBEncoding;
            container.appendChild( renderer.domElement );


            /**
             * Ajout des controls pour la caméra
             * */
            controls = new OrbitControls( camera, renderer.domElement );
            controls.addEventListener( 'change', render );
            controls.minDistance = 2;
            controls.maxDistance = 10;
            controls.target.set( 0, 0, - 0.2 );
            controls.update();

            window.addEventListener( 'resize', onWindowResize, false );
        }

        /**
         * Modifie la taille du canvas quand la taille de l'écran change
         * */
        function onWindowResize() {
            camera.aspect = getScreenWidth() / getScreenHeight();
            camera.updateProjectionMatrix();

            renderer.setSize( getScreenWidth(), getScreenHeight() );

            render();
        }

        /**
         * Affiche la vue ThreeJs
         * */
        function render() {
            renderer.render( scene, camera );
        }
    }

    /**
     * Supprime la div pour la preview
     * */
    function deletePreviewBloc() {
        const parentElement = document.querySelector(".preview_file_bloc");
        if (!parentElement) return;

        const elementHeight = parentElement.clientHeight;

        parentElement.remove();
        scrollToCarousel(elementHeight);
    }

    /**
     * @param {string} fileName
     * @param {string} fileUrl
     * @param {string} parentRef - Optional
     * */
    function addPreviewBloc(fileName, fileUrl, parentRef = '#section-products') {
        let parentElement = document.querySelector(".preview_file_bloc");

        if (!parentElement) {
            parentElement = document.createElement("div");
            parentElement.classList.add('preview_file_bloc');

            document.querySelector(parentRef).appendChild(parentElement);
        }

        parentElement.innerHTML = "";
        carouselLoader(true);

        const h1Element = document.createElement('h1');
        h1Element.innerText = fileName;

        parentElement.appendChild(h1Element);

        loadThreeJs(fileUrl);
        scrollToThree();
    }

    /**
     * Loader des fichiers 3d
     * */
    function carouselLoader(status, parentRef = '.preview_file_bloc') {
        let parentElement = document.querySelector("#loaderCarousel");

        if (!parentElement && status) {
            parentElement = document.createElement("div");
            parentElement.setAttribute('id', 'loaderCarousel');

            document.querySelector(parentRef).appendChild(parentElement);
            parentElement.innerText = 'chargement ...';
        } else if (!parentElement && !status) {
            return;
        }

        parentElement.style.display = (status)? 'block':'none';
    }

    /**
     * Quand on clique sur un bouton d'affichage 3d
     * @param {Event} e
     * */
    function onClickCarouselBtn(e) {
        let {fileName, fileUrl} = e.target.dataset;
        addPreviewBloc(fileName, fileUrl);
    }

    /**
     * Fonction principal
     * */
    async function main() {
        let carouselButtonsElements;

        try {
            carouselButtonsElements = await getCarouselBtns();
        } catch (e) {
            throw new Error(e);
        }


        for (const button of carouselButtonsElements) {
            /**
             * @param {HTMLButtonElement} button
             */
            button.addEventListener('click', onClickCarouselBtn);
        }
    }

    main();
</script>