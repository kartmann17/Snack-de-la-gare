const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

// Définir les variables du jeu
let paddleWidth = 100;
let paddleHeight = 10;
let paddleX = (canvas.width - paddleWidth) / 2;
let rightPressed = false;
let leftPressed = false;
let ballRadius = 10;
let x = canvas.width / 2;
let y = canvas.height - 30;
let dx = 2;
let dy = -2;
let score = 0;
let gameOver = false;

// Ajout des écouteurs pour les touches
document.addEventListener("keydown", keyDownHandler);
document.addEventListener("keyup", keyUpHandler);

// Mise à jour du score dans le DOM
function updateScore() {
    let scoreDisplay = document.getElementById("score");
    scoreDisplay.textContent = score;
}

function keyDownHandler(e) {
    if (e.key === "Right" || e.key === "ArrowRight") {
        rightPressed = true;
    } else if (e.key === "Left" || e.key === "ArrowLeft") {
        leftPressed = true;
    }
}

function keyUpHandler(e) {
    if (e.key === "Right" || e.key === "ArrowRight") {
        rightPressed = false;
    } else if (e.key === "Left" || e.key === "ArrowLeft") {
        leftPressed = false;
    }
}

function drawBall() {
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, Math.PI * 2);
    ctx.fillStyle = "#FF5733";
    ctx.fill();
    ctx.closePath();
}

function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height - paddleHeight - 10, paddleWidth, paddleHeight);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}

function draw() {
    if (gameOver) return;

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBall();
    drawPaddle();

    // Détection des bords pour la balle
    if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
        dx = -dx;
    }
    if (y + dy < ballRadius) {
        dy = -dy;
    } else if (y + dy > canvas.height - ballRadius - paddleHeight - 10) {
        if (x > paddleX && x < paddleX + paddleWidth) {
            dy = -dy;
            score++; // Incrémentation du score
            updateScore(); // Mise à jour de l'affichage du score
        } else {
            // Fin de partie
            gameOver = true; // Marquer la fin du jeu
            alert("Game Over! Score : " + score); // Afficher le score final
        }
    }

    // Déplacement de la balle
    x += dx;
    y += dy;

    // Déplacement de la raquette
    if (rightPressed && paddleX < canvas.width - paddleWidth) {
        paddleX += 7;
    } else if (leftPressed && paddleX > 0) {
        paddleX -= 7;
    }
}

// Initialisation de l'affichage du score
updateScore();

// Boucle principale du jeu
setInterval(draw, 10);