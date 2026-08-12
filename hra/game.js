const canvas = document.getElementById("hra");

const engine = new BABYLON.Engine(canvas, true);

const scene = new BABYLON.Scene(engine);

scene.clearColor = new BABYLON.Color4(
    0.1,
    0.1,
    0.15,
    1
);

const kamera = new BABYLON.FreeCamera(
    "kamera",
    new BABYLON.Vector3(0, 5, -10),
    scene
);

kamera.setTarget(
    new BABYLON.Vector3(0, 0, 0)
);

const svetlo = new BABYLON.HemisphericLight(
    "svetlo",
    new BABYLON.Vector3(0, 1, 0),
    scene
);

svetlo.intensity = 1;

const zem = BABYLON.MeshBuilder.CreateGround(
    "zem",
    {
        width: 50,
        height: 50
    },
    scene
);


// NAČTENÍ OBJEKTU

BABYLON.SceneLoader.ImportMesh(
    "",
    "./",
    "objekt.glb",
    scene,

    function (meshes) {

        console.log("OBJekt načten!");

        const objekt = meshes[0];

        objekt.position.x = 0;
        objekt.position.y = 0;
        objekt.position.z = 5;

        objekt.scaling = new BABYLON.Vector3(
            1,
            1,
            1
        );

    },

    null,

    function (scene, message) {

        console.error(
            "CHYBA PŘI NAČÍTÁNÍ:",
            message
        );

    }
);


engine.runRenderLoop(function () {

    scene.render();

});


window.addEventListener(
    "resize",
    function () {

        engine.resize();

    }
);