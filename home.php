<?php
  $page_title = 'Bienvenidos a Global Backups';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<style>
  body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
      background: linear-gradient(to bottom, #001a33, #000d1a); /* azul oscuro degradado */
  }

  /* Contenedor de estrellas */
  .stars {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 0;
  }

  /* Cada estrella */
  .star {
      position: absolute;
      background: white;
      border-radius: 50%;
      width: 1px;   /* estrella pequeña */
      height: 1px;
      opacity: 0.8;
      animation: twinkle 2s infinite alternate;
  }

  /* Parpadeo aleatorio */
  @keyframes twinkle {
      0% { opacity: 0.2; }
      50% { opacity: 1; }
      100% { opacity: 0.2; }
  }
  </style>

  <script>
  // Crear muchas estrellas pequeñas
  const numStars = 200; // cantidad de estrellitas
  const starsContainer = document.createElement('div');
  starsContainer.classList.add('stars');
  document.body.appendChild(starsContainer);

  for (let i = 0; i < numStars; i++) {
      const star = document.createElement('div');
      star.classList.add('star');
      star.style.top = Math.random() * window.innerHeight + 'px';
      star.style.left = Math.random() * window.innerWidth + 'px';
      star.style.animationDuration = (Math.random() * 2 + 1) + 's'; // velocidad aleatoria
      star.style.opacity = Math.random();
      starsContainer.appendChild(star);
  }
</script>

<style>

  /* Tarjeta de bienvenida */
  .welcome-card {
    background: linear-gradient(90deg, #0c2e8dff, #692eb5ff); /* azul profundo a morado */
    padding: 60px 50px;
    left: 350px;
    border-radius: 30px;
    max-width: 700px;
    width: 90%;
    text-align: center;
    box-shadow: 0 15px 30px rgba(0,0,0,0.2),
                0 25px 50px rgba(0,0,0,0.25),
                0 35px 70px rgba(0,0,0,0.2);
    border: 2px solid rgba(255, 255, 255, 0.2);
    position: relative;
    animation: floatCard 6s ease-in-out infinite;
    transition: all 0.3s;
  }

  @keyframes floatCard {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
  }

  .welcome-card:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.25),
                0 35px 60px rgba(0,0,0,0.35),
                0 50px 80px rgba(0,0,0,0.3);
    transform: translateY(-8px);
  }

  /* Logo */
  .welcome-logo img {
    max-width: 350px;
    margin-bottom: 30px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  }

  /* Título */
  .welcome-card h1 {
    font-size: 48px;
    font-weight: bold;
    color: #ffffff; /* blanco para contrastar con azul/morado */
    text-shadow: 0 0 2px #a0c4ff, 0 0 4px #182848;
    margin-top: 15px;
  }

  /* Subtítulo */
  .welcome-card p {
    color: #e0e0ff;
    margin-top: 20px;
    font-size: 20px;
  }
</style>


<div class="welcome-container">
  <div class="welcome-card">
    <div class="welcome-logo">
      <img src="uploads/GLOBALBACKUPS.png" alt="Logo de Global Backups">
    </div>

    <h1>Global Backups Universidad</h1>
    <p>Bienvenido a tu espacio seguro de gestión de datos.</p>
  </div>
</div>

<script>
  // Estrellas animadas
  const starContainer = document.getElementById('stars');
  const numStars = 100;

  for(let i=0; i<numStars; i++){
    const star = document.createElement('div');
    star.className = 'star';
    star.style.top = Math.random() * 100 + '%';
    star.style.left = Math.random() * 100 + '%';
    const size = Math.random() * 2 + 1;
    star.style.width = size + 'px';
    star.style.height = size + 'px';
    star.style.opacity = Math.random() * 0.5 + 0.2;
    star.style.animationDuration = (Math.random() * 5 + 3) + 's';
    starContainer.appendChild(star);
  }
</script>




<?php include_once('layouts/footer.php'); ?>
