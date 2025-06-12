<?php
session_start();

$notesFile = 'notes.json';

// Load existing notes
if (file_exists($notesFile)) {
    $json = file_get_contents($notesFile);
    $_SESSION['love_notes'] = json_decode($json, true) ?? [];
} else {
    $_SESSION['love_notes'] = [];
}

// Clean invalid notes
$_SESSION['love_notes'] = array_filter($_SESSION['love_notes'], function ($note) {
    return isset($note['text'], $note['author'], $note['id'], $note['time']);
});

// Add Note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'], $_POST['author'])) {
    $newNote = [
        'text' => trim($_POST['note']),
        'author' => $_POST['author'],
        'id' => uniqid(),
        'time' => date('d M Y, h:i A')
    ];
    $_SESSION['love_notes'][] = $newNote;
    file_put_contents($notesFile, json_encode($_SESSION['love_notes']));
    header("Location: love_notes.php");
    exit();
}

// Delete Note
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $_SESSION['love_notes'] = array_filter($_SESSION['love_notes'], function ($note) use ($delete_id) {
        return $note['id'] !== $delete_id;
    });
    file_put_contents($notesFile, json_encode(array_values($_SESSION['love_notes'])));
    header("Location: love_notes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Love Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: url('love.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
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

    .overlay {
      background-color: rgba(0, 0, 0, 0.5);
      min-height: 100vh;
      padding-top: 80px;
    }
    .note-card {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid #fff;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 20px;
      position: relative;
      color: #fff;
      display: flex;
      flex-direction: column;
    }
    .note-card:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }
    .note-header {
      font-family: 'Brush Script MT', cursive;
      font-size: 1.8rem;
      color: #ffebcd;
    }
    .note-body {
      font-size: 1.1rem;
      line-height: 1.6;
      flex-grow: 1;
    }
    .note-footer {
      font-size: 0.9rem;
      color: #ddd;
      font-style: italic;
      text-align: right;
      margin-top: 10px;
    }
    .delete-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      color: #f99;
      background: none;
      border: none;
      font-size: 1rem;
      cursor: pointer;
    }
    .form-section {
      margin-top: 30px;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 15px;
    }
  </style>
</head>
<body>
<audio id="bg-music" autoplay loop>
  <source src="song3.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Love & Memories</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
          <li class="nav-item"><a href="timeline.php" class="nav-link">Timeline</a></li>
          <li class="nav-item"><a href="gallery.php" class="nav-link">Gallery</a></li>
          <li class="nav-item"><a href="love_notes.php" class="nav-link active">Love Notes</a></li>
          <li class="nav-item"><a href="why.php" class="nav-link">Why I Love You</a></li>
          <li class="nav-item"><a href="surprise.php" class="nav-link">Surprise</a></li>
          <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container overlay" style="padding-top: 100px;">
  <div class="text-center mb-4">
    <h2 class="display-5">💌 Love Notes for My One & Only 💌</h2>
    <p class="lead">These words carry all the feelings my heart can never fully express.</p>
  </div>

  <!-- Add Note Form -->
  <div class="form-section mb-5">
    <form method="POST" class="row g-3 align-items-end">
      <div class="col-md-7">
        <textarea name="note" class="form-control" rows="2" placeholder="Write your love note here..." required></textarea>
      </div>
      <div class="col-md-3">
        <select name="author" class="form-select" required>
          <option value="" disabled selected>Who are you?</option>
          <option value="Zara">Zara</option>
          <option value="Ali">Jaan (Ali)</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-light w-100">💌 Send</button>
      </div>
    </form>
  </div>

  <!-- Display Notes -->
  <?php if (!empty($_SESSION['love_notes'])): ?>
    <?php 
      $reversed_notes = array_reverse($_SESSION['love_notes']); 
      $note_count = count($reversed_notes);
      foreach ($reversed_notes as $note): 
    ?>
      <div class="note-card">
        <button class="delete-btn" onclick="if(confirm('Delete this note?')) location.href='?delete=<?= htmlspecialchars($note['id']) ?>'">×</button>
        <div class="note-header">Note #<?= $note_count-- ?></div>
        <div class="note-body"><?= nl2br(htmlspecialchars($note['text'])) ?></div>
        <div class="note-footer">— <?= htmlspecialchars($note['author']) ?> on <?= htmlspecialchars($note['time']) ?></div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center">No love notes yet. Be the first to write one 💌</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
