<?php 
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<style>
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow: hidden;
    background: linear-gradient(to bottom, rgb(0,26,51), rgb(0,13,26)); /* azul oscuro degradado */
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
<style>
  body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('uploads/GLOBALBACKUPS.png') no-repeat center center;
      background-size: cover; /* cubrir toda el área */
      opacity: 0.05; /* sutil, elegante */
      z-index: 0;
  }

  .login-page {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 55vh;
      right:120px;
      position: relative;
      background: #7700ff41; /* azul translúcido */
      padding: 50px 40px;
      border-radius: 20px;
      width: 420px;
      text-align: center;
      box-shadow: 0 15px 30px rgba(0,0,0,0.1),
                  0 25px 50px rgba(0,0,0,0.15),
                  0 35px 70px rgba(0,0,0,0.1); /* fondo más profundo */
      border: 2px solid rgba(200,200,200,0.5);
      z-index: 1;
  }

  .login-card {
      background: linear-gradient(90deg, #0c2e8dff, #692eb5ff);
      padding: 45px 35px;
      border-radius: 20px;
      width: 420px;
      text-align: center;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2),
                  0 20px 40px rgba(0,0,0,0.3),
                  0 30px 60px rgba(0,0,0,0.25); /* sombra más profunda y suave */
      border: 2px solid rgba(255, 255, 255, 0.6);
      position: relative;
      transition: all 0.3s;
  }

  /* Efecto hover */
  .login-card:hover {
      box-shadow: 0 15px 30px rgba(0,0,0,0.25),
                  0 30px 60px rgba(0,0,0,0.4),
                  0 45px 80px rgba(0,0,0,0.3);
      transform: translateY(-5px);
  }


    .login-logo img {
      max-width: 140px;
      margin-bottom: 20px;
    }

    .login-card h2 {
      font-size: 32px;
      font-weight: bold;
      color: #ff79c6; 
    }

    @keyframes subtleGlow {
      0% { text-shadow: 0 0 2px #ff79c6, 0 0 4px #00d1ff; }
      50% { text-shadow: 0 0 3px #ff79c6, 0 0 6px #00d1ff; }
      100% { text-shadow: 0 0 2px #ff79c6, 0 0 4px #00d1ff; }
    }

    .login-card p {
      color: #333;
      margin-bottom: 30px;
    }

    .login-card input {
      width:100%;
      padding:12px;
      border-radius:8px;
      border:1px solid #bbb;
      background:#ffffff;
      color:#333;
      outline:none;
      transition: all 0.3s;
      margin-bottom:20px;
    }

    .login-card input:focus {
      border-color: #ff79c6;
      background: #f0f0f0;
    }

    .login-card button {
      width:100%;
      padding:14px;
      border:none;
      border-radius:12px;
      background: linear-gradient(90deg, #ff79c6, #ffb6c1);
      color:white;
      font-weight:bold;
      font-size:16px;
      cursor:pointer;
      transition: all 0.3s;
    }

    .login-card button:hover {
      transform: scale(1.05);
    }

</style>

<div class="stars" id="stars"></div>

<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <img src="uploads/GLOBALBACKUPS.png" alt="Logo de Global Backups">
        </div>

        <h2>Bienvenido</h2>
        <p>Inicia sesión en tu cuenta</p>

        <?php echo display_msg($msg); ?>

        <form method="post" action="auth.php">
            <input type="text" name="username" placeholder="Usuario">
            <input type="password" name="password" placeholder="Contraseña">
            <button type="submit">Entrar</button>
        </form>
    </div>
</div>

<script>
  // Estrellas
  const starContainer = document.getElementById('stars');
  const numStars = 100;

  for(let i=0; i<numStars; i++){
    const star = document.createElement('div');
    star.className = 'star';
    star.style.top = Math.random() * 100 + '%';
    star.style.left = Math.random() * 100 + '%';
    const size = Math.random() * 3 + 1;
    star.style.width = size + 'px';
    star.style.height = size + 'px';
    star.style.opacity = Math.random() * 0.6 + 0.2;
    star.style.animationDuration = (Math.random() * 5 + 3) + 's';
    starContainer.appendChild(star);
  }
</script>

<?php include_once('layouts/footer.php'); ?>
