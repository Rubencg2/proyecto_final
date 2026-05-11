<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sobre Nosotros — La Casa del Fútbol</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./CSS/estilos.css"/>
  <link rel="stylesheet" href="./CSS/sobre-nosotros.css"/>
</head>
<body>
  <?php
  include("./cabecera.php");
  ?>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-inner">
      <p class="hero-eyebrow">Sobre nosotros</p>
      <h1>Vivimos el fútbol,<br /><em>lo vestimos todo.</em></h1>
      <p class="hero-desc">Somos una tienda online especializada en ropa deportiva de fútbol. 
        Equipaciones oficiales, chandales y camisetas retro para todos los que sienten el fútbol de verdad, 
        desde los más pequeños hasta los más veteranos.</p>
    </div>
  </section>

  <!-- HISTORIA -->
  <section class="historia">
    <div class="historia-grid">
      <div class="historia-text">
        <p class="section-eyebrow">Nuestra historia</p>
        <h2 class="section-title">Nacidos del <em>amor al fútbol</em></h2>
        <p>En La Casa del Fútbol vivimos el deporte con pasión. Nacimos con la idea de crear una tienda pensada para todos los amantes del fútbol, donde jugadores, aficionados y equipos puedan encontrar ropa y equipación de calidad al mejor precio.</p>
        <p>Nuestra historia comenzó con una simple ilusión: acercar el fútbol a todo el mundo a través de productos cómodos, modernos y adaptados a cada persona. Con el paso del tiempo, hemos ido creciendo gracias a la confianza de nuestros clientes y al esfuerzo por ofrecer siempre las últimas novedades y las mejores marcas.</p>
        <p>Hoy seguimos trabajando con la misma pasión del primer día, ayudando a cada cliente a encontrar todo lo necesario para disfrutar del fútbol dentro y fuera del campo.</p>
      </div>
      <div class="historia-img">
        <div class="historia-img-placeholder">
          <i class="ti ti-photo" aria-hidden="true"></i>
          <span>Añade tu imagen aquí</span>
        </div>
      </div>
    </div>
  </section>

  <!-- MISIÓN -->
  <section class="mision">
    <p class="section-eyebrow">Nuestra misión</p>
    <h2 class="section-title">Por qué hacemos lo que hacemos</h2>
    <p class="mision-quote">Queremos que cada jugador, sea del equipo que sea y juegue donde juegue, pueda vestir con orgullo y comodidad. El fútbol es para todos, y nuestra tienda también.</p>
  </section>

  <!-- VALORES -->
  <section class="valores">
    <div class="valores-inner">
      <div class="valores-header">
        <p class="section-eyebrow">Nuestros valores</p>
        <h2 class="section-title">Lo que nos mueve <em>cada día</em></h2>
      </div>
      <div class="valores-grid">

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-ball-football" aria-hidden="true"></i>
          </div>
          <h3>Pasión por el fútbol</h3>
          <p>Somos aficionados antes que comerciantes. Conocemos el deporte desde dentro y eso nos permite ofrecerte lo que realmente necesitas sobre el terreno de juego.</p>
        </div>

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-shield-check" aria-hidden="true"></i>
          </div>
          <h3>Calidad garantizada</h3>
          <p>Solo trabajamos con marcas y productos que cumplen los estándares más exigentes. Si no lo usaríamos nosotros en el campo, no lo vendemos en nuestra tienda.</p>
        </div>

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-truck-delivery" aria-hidden="true"></i>
          </div>
          <h3>Envío rápido y seguro</h3>
          <p>Sabemos que cuando necesitas una equipación, la necesitas ya. Por eso nos comprometemos con plazos de entrega rápidos y un embalaje que protege cada prenda.</p>
        </div>

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-users" aria-hidden="true"></i>
          </div>
          <h3>Para todos los niveles</h3>
          <p>Desde el niño que empieza en la escuela de fútbol hasta el club semiprofesional. Tenemos equipaciones y ropa de entrenamiento para cada nivel y presupuesto.</p>
        </div>

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-headset" aria-hidden="true"></i>
          </div>
          <h3>Atención cercana</h3>
          <p>Nuestro equipo responde rápido y con conocimiento. Te ayudamos a elegir la talla, el modelo o la personalización que mejor se adapte a lo que buscas.</p>
        </div>

        <div class="valor-card">
          <div class="valor-icon">
            <i class="ti ti-medal" aria-hidden="true"></i>
          </div>
          <h3>Personalización</h3>
          <p>Equipaciones con el nombre y dorsal de tu elección, kits para clubes con su escudo propio. Hacemos que cada camiseta sea única, igual que cada jugador.</p>
        </div>

      </div>
    </div>
  </section>

  <?php
  include("./footer.html");
  ?>

</body>
</html>