<?php
$today = date('m-d');
$showGame = ($today >= '06-13');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Birthday Game 🎉</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #ffc0cb, #87ceeb);
      min-height: 100vh;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

     .navbar {
  background-color: rgba(0, 0, 0, 0.8);
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1030;
}

.navbar-brand {
  font-family: 'Brush Script MT', cursive;
  font-weight: bold;
  font-size: 2rem;
  color: #ffc0cb !important;
}

.navbar-nav .nav-link {
  color: #fff !important;
  font-weight: 500;
  transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
  color: #87ceeb !important; /* Light Sky Blue on hover */
}

.navbar-nav .nav-link.active {
  color: #87ceeb !important; /* Sky Blue */
  font-weight: bold;
}


    .box {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      text-align: center;
      max-width: 800px;
      margin: auto;
      margin-top: 100px;
    }

    h1 {
      color: #ff6f61;
      margin-bottom: 20px;
    }

    .memory-game {
      display: grid;
      grid-template-columns: repeat(4, 80px);
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
    }

    .card {
      width: 80px;
      height: 80px;
      background-color: #ffb6c1;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      border-radius: 10px;
      cursor: pointer;
      user-select: none;
      transition: 0.3s;
    }

    .card.flipped {
      background-color: #fff;
      border: 2px solid #ff69b4;
    }

    .footer {
      text-align: center;
      margin: 20px 0;
      color: #555;
    }

    .game-info {
      margin-top: 20px;
      color: #333;
      font-size: 1.1rem;
    }

    .coming-soon {
      color: #444;
    }

    #restartBtn {
      margin-top: 20px;
      display: none;
    }
  </style>
</head>
<body>
<audio autoplay loop>
  <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mp3">
  Your browser does not support the audio element.
</audio>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Love & Memories</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <?php
          $pages = [
            'index.php' => 'Home',
            'timeline.php' => 'Timeline',
            'gallery.php' => 'Gallery',
            'love_notes.php' => 'Love Notes',
            'why.php' => 'Why I Love You',
            'surprise.php' => 'Surprise',
            'birthday_game.php' => 'Birthday Game'
          ];
          $current = basename($_SERVER['PHP_SELF']);
          foreach ($pages as $file => $title) {
            $active = ($file == $current) ? 'active' : '';
            echo "<li class='nav-item'><a href='$file' class='nav-link $active'>$title</a></li>";
          }
        ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Game Box -->
<div class="box">
  <?php if ($showGame): ?>
    <h1>🎉 Happy Birthday Game 🎉</h1>
    <p class="text-info">Surprise! A love-based memory game just for today. Flip the matching hearts 💘</p>

    <div class="game-info">
      <strong>Score:</strong> <span id="score">0</span> |
      <strong>Time Left:</strong> <span id="timer">60</span> sec
    </div>

    <div class="memory-game" id="memoryGame"></div>

    <button id="restartBtn" class="btn btn-outline-danger">🔁 Try Again</button>

    <!-- Background Music -->
    <audio id="bgMusic" src="audio/happy.mp3" autoplay loop></audio>
    <!-- Flip Sound -->
    <audio id="flipSound" src="audio/flip.mp3"></audio>

  <?php else: ?>
    <h1>🎈 Coming Soon 🎈</h1>
    <p class="coming-soon">This birthday game will unlock only on <strong>13th June</strong>. Stay tuned! 😊</p>
  <?php endif; ?>
</div>

<!-- Footer -->
<div class="footer">
  Made with 💖 for someone special
</div>

<!-- Game Script -->
<?php if ($showGame): ?>
<script>
  const cardsArray = ['💘','💘','🌹','🌹','🎁','🎁','🍫','🍫','🎈','🎈','💕','💕','😍','😍','🥰','🥰'];
  let shuffled = cardsArray.sort(() => 0.5 - Math.random());
  const gameContainer = document.getElementById('memoryGame');
  const flipSound = document.getElementById('flipSound');
  const restartBtn = document.getElementById('restartBtn');
  let score = 0, timer = 60, firstCard = null, secondCard = null, lock = false;

  function initGame() {
    gameContainer.innerHTML = '';
    shuffled = cardsArray.sort(() => 0.5 - Math.random());
    shuffled.forEach(symbol => {
      const card = document.createElement('div');
      card.classList.add('card');
      card.dataset.symbol = symbol;
      card.innerHTML = '?';
      card.addEventListener('click', () => {
        if (lock || card.classList.contains('flipped')) return;
        flipSound.play();
        card.innerHTML = symbol;
        card.classList.add('flipped');

        if (!firstCard) {
          firstCard = card;
        } else {
          secondCard = card;
          lock = true;
          if (firstCard.dataset.symbol === secondCard.dataset.symbol) {
            score++;
            document.getElementById('score').textContent = score;
            firstCard = secondCard = null;
            lock = false;
          } else {
            setTimeout(() => {
              firstCard.innerHTML = '?';
              secondCard.innerHTML = '?';
              firstCard.classList.remove('flipped');
              secondCard.classList.remove('flipped');
              firstCard = secondCard = null;
              lock = false;
            }, 1000);
          }
        }
      });
      gameContainer.appendChild(card);
    });
  }

  initGame();

  const timerDisplay = document.getElementById('timer');
  let countdown = setInterval(() => {
    timer--;
    timerDisplay.textContent = timer;
    if (timer <= 0) {
      clearInterval(countdown);
      alert("⏰ Time's up! Your Score: " + score);
      restartBtn.style.display = 'inline-block';
    }
  }, 1000);

  restartBtn.addEventListener('click', () => {
    score = 0;
    timer = 60;
    document.getElementById('score').textContent = 0;
    timerDisplay.textContent = 60;
    restartBtn.style.display = 'none';
    initGame();
    countdown = setInterval(() => {
      timer--;
      timerDisplay.textContent = timer;
      if (timer <= 0) {
        clearInterval(countdown);
        alert("⏰ Time's up! Your Score: " + score);
        restartBtn.style.display = 'inline-block';
      }
    }, 1000);
  });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



