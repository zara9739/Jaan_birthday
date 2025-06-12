<?php
// JSON file to store timeline events
$jsonFile = 'timeline.json';
$events = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Handle Add Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $imagePath = '';

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
        if (in_array($_FILES['image']['type'], $allowed)) {
            $imgName = time() . '_' . basename($_FILES['image']['name']);
            $target = 'uploads/' . $imgName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $imagePath = $target;
            }
        }
    }

    $events[] = [
        'id' => uniqid(),
        'date' => $date,
        'title' => $title,
        'desc' => $desc,
        'img' => $imagePath
    ];

    file_put_contents($jsonFile, json_encode($events, JSON_PRETTY_PRINT));
    header("Location: timeline.php");
    exit;
}

// Handle Delete Event
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    foreach ($events as $index => $event) {
        if ($event['id'] === $id) {
            if (!empty($event['img']) && file_exists($event['img'])) {
                unlink($event['img']); // Delete image from server
            }
            unset($events[$index]); // Remove event from array
        }
    }
    file_put_contents($jsonFile, json_encode(array_values($events), JSON_PRETTY_PRINT));
    header("Location: timeline.php");
    exit;
}

// Apply year filter
$filterYear = $_GET['year'] ?? null;
if ($filterYear) {
    $events = array_filter($events, fn($e) => date('Y', strtotime($e['date'])) == $filterYear);
}

// Sort events chronologically
usort($events, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Timeline – Love & Memories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #add8e6, #ffc0cb);
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
  color: #87ceeb !important; /* Sky Blue when active */
  font-weight: bold;
}

    .timeline {
      position: relative; max-width: 900px; margin: 50px auto;
    }
    .timeline::after {
      content: ''; position: absolute; width: 6px; background: #fff;
      top: 0; bottom: 0; left: 50%; margin-left: -3px;
    }
    .container-tl {
      padding: 10px 40px; position: relative; width: 50%;
    }
    .left { left: 0; }
    .right { left: 50%; }
    .container-tl::after {
      content:''; position: absolute; width: 25px; height: 25px;
      background:#fff; border:4px solid #6c63ff;
      top: 15px; border-radius:50%; z-index:1;
    }
    .right::after { left: -16px; }
    .content-tl {
      position: relative;
      padding: 20px 30px; background: #6c63ff; color: #fff;
      border-radius: 8px; animation: fadeInUp 0.7s;
    }
    img.timeline-img {
      width: 100%; max-height: 250px;
      object-fit: cover; border-radius: 8px; margin-top: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.2);
    }
    .delete-btn {
      position: absolute; top: 10px; right: 15px;
      background: transparent; border: none;
      color: #fff; font-size: 20px; font-weight: bold;
      text-decoration: none;
    }
    .delete-btn:hover {
      color: red;
      transform: scale(1.1);
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width:768px) {
      .timeline::after { left: 31px; }
      .container-tl { width:100%; padding-left:70px; padding-right:25px; }
      .container-tl::after { left:60px; }
      .right { left:0; }
    }
    .btn-primary {
      background: #6c63ff; border: none;
    }
    .btn-primary:hover {
      background: #5248d2;
    }
    .offcanvas-title {
      color: #6c63ff;
    }
  </style>
</head>
<body>
<audio id="bg-music" autoplay loop>
  <source src="song2.mp3" type="audio/mpeg">
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
          <li class="nav-item"><a href="index.php" class="nav-link ">Home</a></li>
          <li class="nav-item"><a href="timeline.php" class="nav-link active">Timeline</a></li>
          <li class="nav-item"><a href="gallery.php" class="nav-link">Gallery</a></li>
          <li class="nav-item"><a href="love_notes.php" class="nav-link">Love Notes</a></li>
          <li class="nav-item"><a href="why.php" class="nav-link">Why I Love You</a></li>
          <li class="nav-item"><a href="surprise.php" class="nav-link">Surprise</a></li>
          <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
        </ul>
      </div>
    </div>
  </nav>


<div class="container mt-5 pt-5">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h2 class="text-light">Our Timeline Memories</h2>
    <form class="d-flex" method="GET">
      <input name="year" type="number" class="form-control me-2"
        placeholder="Filter by year" value="<?= htmlspecialchars($_GET['year'] ?? '') ?>">
      <button class="btn btn-outline-dark">Filter</button>
    </form>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Timeline</button>
  </div>
</div>

<div class="timeline mt-5">
  <?php foreach($events as $i => $e): ?>
    <div class="container-tl <?= ($i % 2 === 0) ? 'left' : 'right' ?>">
      <div class="content-tl">
        <a href="?delete=<?= htmlspecialchars($e['id']) ?>" class="delete-btn" onclick="return confirm('Delete this event?')">×</a>
        <h5><?= htmlspecialchars($e['title']) ?> <small>(<?= date('d M Y', strtotime($e['date'])) ?>)</small></h5>
        <p><?= nl2br(htmlspecialchars($e['desc'])) ?></p>
        <?php if (!empty($e['img']) && file_exists($e['img'])): ?>
          <img src="<?= htmlspecialchars($e['img']) ?>" class="timeline-img" alt="Event Image">
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Timeline Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="add_event" value="1">
        <input type="date" name="date" class="form-control mb-2" required>
        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
        <textarea name="desc" class="form-control mb-2" rows="3" placeholder="Description" required></textarea>
        <input type="file" name="image" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Add</button>
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        // Remove active from all links
        navLinks.forEach(l => l.classList.remove('active'));

        // Add active to clicked link
        this.classList.add('active');
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
