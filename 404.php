<?php $footer_text = get_option('origami_footer_text'); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#87d1df">
  <?php wp_head(); ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-exp.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/spectre.css@0.5.8/dist/spectre-icons.min.css">
  <style>
    html,body {
      height: 100%;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      flex: 1;
      transform: translateY(10%);
    }
    .main-content section {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .main-content a {
      margin-top: 1rem;
      margin-left: 0.5rem;
      margin-right: 0.5rem;
    }
    .main-content h2:first-child {
      padding-right: 1rem;
      border-right: .1rem solid;
    }
    .main-content h2:last-child {
      padding-left:  .8rem;
      font-size: 1rem;
    }
    .ori-footer {
      padding-bottom: 1rem;
      text-align: center;
    }
    .my-face {
      animation: my-face 5s infinite ease-in-out;
      display: inline-block;
      margin: 0 5px;
    }

    @keyframes my-face {
      2%,
      24%,
      80% {
        transform: translate(0, 1.5px) rotate(1.5deg);
      }

      4%,
      68%,
      98% {
        transform: translate(0, -1.5px) rotate(-0.5deg);
      }

      38%,
      6% {
        transform: translate(0, 1.5px) rotate(-1.5deg);
      }

      8%,
      86% {
        transform: translate(0, -1.5px) rotate(-1.5deg);
      }

      10%,
      72% {
        transform: translate(0, 2.5px) rotate(1.5deg);
      }

      12%,
      64%,
      78%,
      96% {
        transform: translate(0, -0.5px) rotate(1.5deg);
      }

      14%,
      54% {
        transform: translate(0, -1.5px) rotate(1.5deg);
      }

      16% {
        transform: translate(0, -0.5px) rotate(-1.5deg);
      }

      18%,
      22% {
        transform: translate(0, 0.5px) rotate(-1.5deg);
      }

      20%,
      36%,
      46% {
        transform: translate(0, -1.5px) rotate(2.5deg);
      }

      26%,
      50% {
        transform: translate(0, 0.5px) rotate(0.5deg);
      }

      28% {
        transform: translate(0, 0.5px) rotate(1.5deg);
      }

      30%,
      40%,
      62%,
      76%,
      88% {
        transform: translate(0, -0.5px) rotate(2.5deg);
      }

      32%,
      34%,
      66% {
        transform: translate(0, 1.5px) rotate(-0.5deg);
      }

      42% {
        transform: translate(0, 2.5px) rotate(-1.5deg);
      }

      44%,
      70% {
        transform: translate(0, 1.5px) rotate(0.5deg);
      }

      48%,
      74%,
      82% {
        transform: translate(0, -0.5px) rotate(0.5deg);
      }

      52%,
      56%,
      60% {
        transform: translate(0, 2.5px) rotate(2.5deg);
      }

      58% {
        transform: translate(0, 0.5px) rotate(2.5deg);
      }

      84% {
        transform: translate(0, 1.5px) rotate(2.5deg);
      }

      90% {
        transform: translate(0, 2.5px) rotate(-0.5deg);
      }

      92% {
        transform: translate(0, 0.5px) rotate(-0.5deg);
      }

      94% {
        transform: translate(0, 2.5px) rotate(0.5deg);
      }

      0%,
      100% {
        transform: translate(0, 0) rotate(0);
      }
    }
  </style>
</head>
<body>
    <main class="main-content">
        <section>
          <h2>404</h2>
          <h2>Not Found</h2>
        </section>
        <section>
          The requested resources is not available.
        </section>
        <section>
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">Home</a>
          <a href="javascript:history.back(-1);" class="btn">Go Back</a>
        </section>
    </main>
    <footer class="ori-footer">
      <section class="ori-copyright">
          <?php echo $footer_text; ?>
          <br/>
          <span id="origami-theme-info">
              Theme - <a href="https://blog.ixk.me/theme-origami.html">Origami</a> By <a href="https://www.ixk.me">Otstar Lin</a>
          </span>
      </section>
    </footer>
</body>
</html>