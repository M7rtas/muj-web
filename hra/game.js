const canvas = document.getElementById("hra");

const engine = new BABYLON.Engine(canvas, true);

const createScene = function () {

    const scene = new BABYLON.Scene(engine);

    const camera = new BABYLON.FreeCamera(
        "kamera",
        new BABYLON.Vector3(0, 3, -8),
        scene
    );

    camera.attachControl(canvas, true);

    const light = new BABYLON.HemisphericLight(
        "svetlo",
        new BABYLON.Vector3(0, 1, 0),
        scene
    );

    const ground = BABYLON.MeshBuilder.CreateGround(
        "zem",
        {
            width: 50,
            height: 50
        },
        scene
    );

    const player = BABYLON.MeshBuilder.CreateBox(
        "hrac",
        {
            size: 1
        },
        scene
    );

    player.position.y = 0.5;

    return scene;
};

const scene = createScene();

engine.runRenderLoop(function () {
    scene.render();
});

window.addEventListener("resize", function () {
    engine.resize();
});