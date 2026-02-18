<?php include_once('layouts/headerPROF.php'); ?>
<body style="
    background:linear-gradient(rgba(0, 0, 255, 0.1), rgba(169, 169, 192, 0.35)),
        url('uploads/GLOBALBACKUPS.png') no-repeat;
    background-size: 45%;
    background-attachment: fixed;

    /* Aquí mueves la imagen */
    background-position: 600px 150px; /* X Y */
">
<ul>

<!-- Sección departamentos -->
<li>
  <a href="" class="submenu-toggle">
    <i class="glyphicon glyphicon-th-large"></i>
    <span>PROFESORES</span>
  </a>

  <ul class="nav submenu" style="list-style:none; margin:0; padding:0; background:white; display:none;">
    <li><a href="add_profesor.php" class="submenu-action">AGREGAR_PROF</a></li>
    <li><a href="edit_profesor.php" class="submenu-action">EDITAR_PROF</a></li>
    <li><a href="delete_profesor.php" class="submenu-action">ELIMINAR_PROF</a></li>
    <li><a href="view_profesor.php" class="submenu-action">VER_PROF</a></li>
  </ul>

</li>
</ul>

 
 <script>
        // ------------------ TOGGLE DEL MENÚ (EL QUE TE FALTABA) ------------------
        document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.submenu-toggle').forEach(toggle => {
            toggle.addEventListener('click', e => {
            e.preventDefault();
            const submenu = toggle.nextElementSibling;

            if (submenu.style.display === "none" || submenu.style.display === "") {
                submenu.style.display = "block";
            } else {
                submenu.style.display = "none";
            }
            });
        });

        setupSubmenuToggleEffect();
        setupCurtainEffect();
        });

        // ------------------ EFECTO DEL BOTÓN PRINCIPAL ------------------
        function setupSubmenuToggleEffect() {
        document.querySelectorAll('.submenu-toggle').forEach(el => {

            el.style.display = 'block';
            el.style.color = '#ffffff';
            el.style.fontWeight = 'bold';
            el.style.fontSize = '14px';
            el.style.padding = '12px 25px';
            el.style.borderLeft = '4px solid #1a4dbf';
            el.style.borderRadius = '4px';
            el.style.textDecoration = 'none';
            el.style.background = 'rgba(27, 39, 53, 0.8)';
            el.style.transition = 'all 0.3s ease-in-out';

            el.addEventListener('mouseenter', () => {
            el.style.background = 'linear-gradient(90deg, #0c2e8dff, #692eb5ff)';
            el.style.paddingLeft = '30px';
            el.style.boxShadow = '0 4px 8px rgba(0,0,0,0.5)';
            });

            el.addEventListener('mouseleave', () => {
            el.style.background = 'rgba(27, 39, 53, 0.8)';
            el.style.paddingLeft = '25px';
            el.style.boxShadow = 'none';
            });
        });
        }

        // ------------------ EFECTO TELÓN ------------------
        function setupCurtainEffect() {
        document.querySelectorAll('.submenu-action').forEach(el => {
            el.style.position = 'relative';
            el.style.overflow = 'hidden';
            el.style.borderRadius = '4px';
            el.style.color = '#1a4dbf';
            el.style.background = 'white';
            el.style.padding = '12px 50px';
            el.style.textDecoration = 'none';

            if (el.querySelectorAll('span').length < 3) {
            const text = document.createElement('span');
            text.textContent = el.textContent;
            text.style.position = 'relative';
            text.style.zIndex = 2;

            const left = document.createElement('span');
            left.style.position = 'absolute';
            left.style.top = 0;
            left.style.left = '50%';
            left.style.width = '0';
            left.style.height = '100%';
            left.style.background = '#2e5bb5e8';
            left.style.zIndex = 1;
            left.style.transition = 'width 0.3s';

            const right = document.createElement('span');
            right.style.position = 'absolute';
            right.style.top = 0;
            right.style.right = '50%';
            right.style.width = '0';
            right.style.height = '100%';
            right.style.background = '#2e5bb5';
            right.style.zIndex = 1;
            right.style.transition = 'width 0.3s';

            el.innerHTML = '';
            el.appendChild(text);
            el.appendChild(left);
            el.appendChild(right);

            el.addEventListener('mouseenter', () => {
                text.style.color = 'white';
                left.style.width = '50%';
                right.style.width = '50%';
                left.style.left = '0';
                right.style.right = '0';
            });

            el.addEventListener('mouseleave', () => {
                text.style.color = '#153985ff';
                left.style.width = '0';
                right.style.width = '0';
            });
            }
        });
        }
    </script>

