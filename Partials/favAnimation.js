const colors = ["#FC4F4F", "#FFBC80", "#FF9F45", "#F76E11"];
// const shapes = ['square', 'circle', 'triangle', 'heart']
const shapes = ["heart"];

const randomIntBetween = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1) + min);
};

class Particle {
    constructor({
        x,
        y,
        rotation,
        shape,
        color,
        size,
        duration,
        parent,
    }) {
        this.x = x;
        this.y = -y - 200;
        this.parent = parent;
        this.rotation = rotation;
        this.shape = shape;
        this.color = color;
        this.size = size;
        this.duration = duration;
        this.children = document.createElement("div");
    }

    draw() {
        this.children.style.setProperty("--x", this.x + "px");
        this.children.style.setProperty("--y", this.y + "px");
        this.children.style.setProperty(
            "--r",
            this.rotation + "deg"
        );
        this.children.style.setProperty("--c", this.color);
        this.children.style.setProperty("--size", this.size + "px");
        this.children.style.setProperty(
            "--d",
            this.duration + "ms"
        );
        this.children.className = `shape ${this.shape}`;
        this.parent.append(this.children);
    }

    animate() {
        this.draw();

        const timer = setTimeout(() => {
            this.parent.removeChild(this.children);
            clearTimeout(timer);
        }, this.duration);
    }
}


function animateParticles({
    total
}) {
    for (let i = 0; i < total; i++) {
        const particle = new Particle({
            x: randomIntBetween(-1000, 1000),
            //   y: window.innerHeight,
            y: randomIntBetween(-200, -1000),
            rotation: randomIntBetween(-360 * 5, 360 * 5),
            shape: shapes[randomIntBetween(0, shapes.length - 1)],
            color: colors[randomIntBetween(0, colors.length - 1)],
            size: randomIntBetween(4, 7),
            duration: randomIntBetween(400, 800),
            parent
        })
        particle.animate()
    }
}

document.addEventListener('click', function (e) {
    if (e.target.matches('.confeti')) {
        console.log("Button clicked");

        parent.classList.remove("pumping");
        animateParticles({
            total: 10
        });
    }
});
let intervalTimer = setInterval(() => {
    animateParticles({ total: 10 })
}, 100)

const parent = document.querySelector(".confeti");
parent.addEventListener("touchstart", () => { }, false);
parent.addEventListener("click", (e) => {

});
const buttons = document.querySelectorAll(".confeti");

buttons.forEach((button) => {
    button.addEventListener("touchstart", () => { }, false);
    button.addEventListener("click", (e) => {
        console.log("1");

        button.classList.remove("pumping");

        // Get the position of the button
        // const rect = button.getBoundingClientRect();
        // const x = rect.left + window.scrollX;
        // const y = rect.top + window.scrollY;

        const rect = button.getBoundingClientRect();
        const x = rect.left + window.scrollX + randomIntBetween(-200, 200); // Add a random offset to x
        const y = rect.top + window.scrollY;

        // Pass the position to animateParticles
        animateParticles({
            total: 150,
            x,
            y
        });
    });
});